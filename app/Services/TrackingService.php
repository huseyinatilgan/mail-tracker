<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use App\Jobs\ProcessTrackingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TrackingService
{
    /**
     * Track event safely and securely
     */
    public function trackEvent(string $campaignKey, Request $request): bool
    {
        try {
            // Validate key format (alphanumeric, 20 chars)
            if (!preg_match('/^[a-zA-Z0-9]{20}$/', $campaignKey)) {
                // Log only partial key for debugging to avoid leaking secrets in logs
                Log::warning('Invalid tracking key format', [
                    'key_prefix' => substr($campaignKey, 0, 5) . '...',
                    'ip_hash' => hash('sha256', $request->ip()), // Log hash instead of raw IP
                ]);
                return false;
            }

            $keyHash = hash('sha256', $campaignKey);

            // 1. Rate Limit per Campaign Key (Endpoint Protection)
            // Prevent flooding the DB buffer or Cache with invalid keys
            // Allow 60 requests per minute per key
            $rateLimitKey = "tracking_limit:{$keyHash}";
            if (Cache::has($rateLimitKey) && Cache::increment($rateLimitKey) > 60) {
                return false;
            }
            Cache::add($rateLimitKey, 1, 60);

            // 2. Lookup Campaign by Hash
            // Cache campaign ID and User ID to avoid DB hit on every pixel load
            $campaignData = Cache::remember("campaign_data:{$keyHash}", now()->addMinutes(10), function () use ($keyHash) {
                return Campaign::where('key_hash', $keyHash)->select('id', 'user_id')->first()?->toArray();
            });

            if (!$campaignData) {
                return false;
            }

            $campaignId = $campaignData['id'];
            $userId = $campaignData['user_id'];

            // Enforce Seat Limit: 1000 Events / Day
            $today = now()->format('Y-m-d');
            $seatLimitKey = "seat_limit:{$userId}:{$today}";

            if (Cache::get($seatLimitKey, 0) >= 1000) {
                Log::warning('Seat limit exceeded', ['user_id' => $userId]);
                return false;
            }
            Cache::increment($seatLimitKey);

            if (!$campaignId) {
                return false;
            }

            // Set expiration for seat limit if it's new (24 hours)
            if (Cache::get($seatLimitKey) === 1) {
                Cache::put($seatLimitKey, 1, now()->addDay());
            }

            // 3. Process Request Data
            $ip = $request->ip();
            $ua = $request->userAgent();

            // Hashing for Privacy & Deduplication
            $ipHash = $ip ? hash('sha256', $ip) : null;
            $uaHash = $ua ? hash('sha256', $ua) : null;

            // 4. Proxy Detection
            $isProxy = false;
            $proxyType = null;

            if ($this->isGmailProxy($ua)) {
                $isProxy = true;
                $proxyType = 'gmail';
            } elseif ($this->isApplePrivacyProxy($ua)) {
                $isProxy = true;
                $proxyType = 'apple_privacy';
            }

            // 5. Deduplication
            // "Same campaign + IP hash + User-Agent hash within configurable time window"
            $dedupWindowMinutes = Config::get('mailtracker.deduplication_window', 60);
            $dedupKey = "tracking_dedup:{$campaignId}:{$ipHash}:{$uaHash}";

            if (Cache::has($dedupKey)) {
                // Already tracked recently
                return true;
            }
            // Mark as tracked
            Cache::put($dedupKey, 1, now()->addMinutes($dedupWindowMinutes));

            // 6. Privacy Handling (Masking/Hashing before storage)
            $storeIp = Config::get('mailtracker.track_ip', false);
            $storeUa = Config::get('mailtracker.track_user_agent', false);

            $ipAddress = $storeIp ? $this->sanitizeIpAddress($ip) : null;
            $userAgent = $storeUa ? $this->sanitizeUserAgent($ua) : null;

            // 7. Dispatch Job
            ProcessTrackingEvent::dispatch([
                'campaign_id' => $campaignId,
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'user_email' => $this->sanitizeEmail($request->get('email')), // Email support if passed
                'ip_hash' => $ipHash,
                'ua_hash' => $uaHash,
                'is_proxy' => $isProxy,
                'proxy_type' => $proxyType,
                'opened_at' => now(),
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Error tracking event', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function isGmailProxy(?string $ua): bool
    {
        if (!$ua)
            return false;
        return str_contains($ua, 'GoogleImageProxy');
    }

    private function isApplePrivacyProxy(?string $ua): bool
    {
        if (!$ua)
            return false;
        // Basic detection for Apple Mail on generic setups, usually masked IP but checked via UA
        // Apple often leaves "Mozilla/5.0" but fetches images via proxy. 
        // A more robust check might look for specific IP ranges (Cloudflare/Apple), but keeping it simple as requested.
        // Actually, Apple Mail often sends nothing distinctive in UA other than being generic or "AppleWebKit" without specific version sometimes.
        // Let's rely on a common known string if available, or just skip advanced detection for now if no clear signal.
        // There is no single 100% UA string for Apple MPP.
        return false;
    }

    private function sanitizeIpAddress(?string $ip): ?string
    {
        if (empty($ip))
            return null;
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $ip;
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : null;
    }

    private function sanitizeUserAgent(?string $userAgent): ?string
    {
        if (empty($userAgent))
            return null;
        // Strip tags and limit to 500 chars STRICTLY (no '...' suffix)
        $userAgent = substr(strip_tags($userAgent), 0, 500);
        return preg_replace('/[^\x20-\x7E\x80-\xFF]/', '', $userAgent) ?: null;
    }

    private function sanitizeEmail(?string $email): ?string
    {
        if (empty($email))
            return null;
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? Str::limit($email, 255) : null;
    }

    /**
     * Get Campaign Stats (Read-Only)
     * Still uses direct DB queries for now, but could be cached or aggregated.
     */
    public function getCampaignStats(int $campaignId): array
    {
        // ... (Existing logic, verified to work with new nullable columns as count(*) still works)
        // Adjusting logic simply to ensure it looks at 'opened_at' which exists.

        $now = now();
        $startOfDay = $now->copy()->startOfDay();
        $startOfWeek = $now->copy()->subWeek();
        $startOfMonth = $now->copy()->subMonth();

        $stats = Event::where('campaign_id', $campaignId)
            ->selectRaw(
                'COUNT(*) as total,
                SUM(CASE WHEN opened_at >= ? THEN 1 ELSE 0 END) as today,
                SUM(CASE WHEN opened_at >= ? THEN 1 ELSE 0 END) as week,
                SUM(CASE WHEN opened_at >= ? THEN 1 ELSE 0 END) as month',
                [$startOfDay, $startOfWeek, $startOfMonth]
            )
            ->first();

        if (!$stats) {
            return ['total' => 0, 'today' => 0, 'week' => 0, 'month' => 0];
        }

        return [
            'total' => (int) ($stats->total ?? 0),
            'today' => (int) ($stats->today ?? 0),
            'week' => (int) ($stats->week ?? 0),
            'month' => (int) ($stats->month ?? 0),
        ];
    }
    /**
     * Get Dashboard Stats
     */
    public function getDashboardStats(int $userId): array
    {
        $now = Carbon::now();

        // Campaigns Stats
        $totalCampaigns = Campaign::where('user_id', $userId)->count();
        $campaignsThisMonth = Campaign::where('user_id', $userId)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        // Views Stats via Events
        // We need to join campaigns to filter by user_id
        $viewsQuery = Event::whereHas('campaign', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        $totalViews = (clone $viewsQuery)->count();

        $viewsThisWeek = (clone $viewsQuery)
            ->where('opened_at', '>=', $now->copy()->startOfWeek())
            ->count();

        $viewsToday = (clone $viewsQuery)
            ->whereDate('opened_at', $now->today())
            ->count();

        $viewsYesterday = (clone $viewsQuery)
            ->whereDate('opened_at', $now->copy()->subDay()->toDateString())
            ->count();

        return [
            'total_campaigns' => $totalCampaigns,
            'campaigns_this_month' => $campaignsThisMonth,
            'total_views' => $totalViews,
            'views_this_week' => $viewsThisWeek,
            'views_today' => $viewsToday,
            'views_yesterday' => $viewsYesterday,
        ];
    }
}
