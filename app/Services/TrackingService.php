<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TrackingService
{
    /**
     * Tracking event'i kaydet
     */
    public function trackEvent(string $campaignKey, Request $request): bool
    {
        try {
            // Key formatını doğrula (sadece alfanumerik, 20 karakter)
            if (!preg_match('/^[a-zA-Z0-9]{20}$/', $campaignKey)) {
                Log::warning('Invalid tracking key format', [
                    'key' => Str::limit($campaignKey, 50),
                    'ip' => $request->ip(),
                ]);
                return false;
            }

            $campaign = Campaign::where('key', $campaignKey)->first();

            if (!$campaign) {
                Log::info('Campaign not found for tracking', [
                    'key' => $campaignKey,
                    'ip' => $request->ip(),
                ]);
                return false;
            }

            // IP adresini doğrula ve sanitize et
            $ipAddress = $this->sanitizeIpAddress($request->ip());
            if (!$ipAddress) {
                Log::warning('Invalid IP address', [
                    'ip' => $request->ip(),
                    'campaign_id' => $campaign->id,
                ]);
                return false;
            }

            // Rate limiting kontrolü - aynı IP'den 1 dakikada 1 kez
            $recentEvent = Event::where('campaign_id', $campaign->id)
                ->where('ip_address', $ipAddress)
                ->where('opened_at', '>=', now()->subMinute())
                ->first();

            if ($recentEvent) {
                return false;
            }

            // User Agent'ı sanitize et ve uzunluğunu sınırla
            $userAgent = $this->sanitizeUserAgent($request->userAgent());
            
            // Email'i sanitize et ve doğrula
            $userEmail = $this->sanitizeEmail($request->get('email'));

            Event::create([
                'campaign_id' => $campaign->id,
                'user_agent' => $userAgent,
                'ip_address' => $ipAddress,
                'user_email' => $userEmail,
                'opened_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error tracking event', [
                'key' => Str::limit($campaignKey, 50),
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * IP adresini doğrula ve sanitize et
     */
    private function sanitizeIpAddress(?string $ip): ?string
    {
        if (empty($ip)) {
            return null;
        }

        // IPv4 ve IPv6 formatlarını kontrol et
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $ip;
        }

        // Private IP'ler de kabul edilebilir (localhost, internal network)
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }

        return null;
    }

    /**
     * User Agent'ı sanitize et
     */
    private function sanitizeUserAgent(?string $userAgent): ?string
    {
        if (empty($userAgent)) {
            return null;
        }

        // Maksimum 500 karakter (veritabanı text alanı için)
        $userAgent = Str::limit(strip_tags($userAgent), 500);
        
        // Sadece güvenli karakterlere izin ver
        return preg_replace('/[^\x20-\x7E\x80-\xFF]/', '', $userAgent) ?: null;
    }

    /**
     * Email'i sanitize et ve doğrula
     */
    private function sanitizeEmail(?string $email): ?string
    {
        if (empty($email)) {
            return null;
        }

        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Maksimum 255 karakter
            return Str::limit($email, 255);
        }

        return null;
    }

    /**
     * Kampanya istatistiklerini getir
     */
    public function getCampaignStats(int $campaignId): array
    {
        if (!Campaign::whereKey($campaignId)->exists()) {
            return [];
        }

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
            return [
                'total' => 0,
                'today' => 0,
                'week' => 0,
                'month' => 0,
            ];
        }

        return [
            'total' => (int) ($stats->total ?? 0),
            'today' => (int) ($stats->today ?? 0),
            'week' => (int) ($stats->week ?? 0),
            'month' => (int) ($stats->month ?? 0),
        ];
    }

    /**
     * Dashboard istatistiklerini getir
     */
    public function getDashboardStats(int $userId): array
    {
        $totalCampaigns = Campaign::where('user_id', $userId)->count();

        $now = now();
        $startOfDay = $now->copy()->startOfDay();
        $startOfWeek = $now->copy()->subWeek();

        $eventStats = Event::whereHas('campaign', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->selectRaw(
                'COUNT(*) as total,
                SUM(CASE WHEN opened_at >= ? THEN 1 ELSE 0 END) as today,
                SUM(CASE WHEN opened_at >= ? THEN 1 ELSE 0 END) as week',
                [$startOfDay, $startOfWeek]
            )
            ->first();

        if (!$eventStats) {
            return [
                'total_campaigns' => $totalCampaigns,
                'total_events' => 0,
                'today_events' => 0,
                'week_events' => 0,
            ];
        }

        return [
            'total_campaigns' => $totalCampaigns,
            'total_events' => (int) ($eventStats->total ?? 0),
            'today_events' => (int) ($eventStats->today ?? 0),
            'week_events' => (int) ($eventStats->week ?? 0),
        ];
    }
}
