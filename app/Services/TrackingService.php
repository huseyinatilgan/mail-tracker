<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Http\Request;

class TrackingService
{
    /**
     * Tracking event'i kaydet
     */
    public function trackEvent(string $campaignKey, Request $request): bool
    {
        $campaign = Campaign::where('key', $campaignKey)->first();

        if (!$campaign) {
            return false;
        }

        // Rate limiting kontrolü - aynı IP'den 1 dakikada 1 kez
        $recentEvent = Event::where('campaign_id', $campaign->id)
            ->where('ip_address', $request->ip())
            ->where('opened_at', '>=', now()->subMinute())
            ->first();

        if ($recentEvent) {
            return false;
        }

        Event::create([
            'campaign_id' => $campaign->id,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'user_email' => $request->get('email'),
            'opened_at' => now(),
        ]);

        return true;
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
