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
        $campaign = Campaign::with('events')->find($campaignId);

        if (!$campaign) {
            return [];
        }

        $totalEvents = $campaign->events->count();
        $todayEvents = $campaign->events->where('opened_at', '>=', now()->startOfDay())->count();
        $weekEvents = $campaign->events->where('opened_at', '>=', now()->subWeek())->count();
        $monthEvents = $campaign->events->where('opened_at', '>=', now()->subMonth())->count();

        return [
            'total' => $totalEvents,
            'today' => $todayEvents,
            'week' => $weekEvents,
            'month' => $monthEvents,
        ];
    }

    /**
     * Dashboard istatistiklerini getir
     */
    public function getDashboardStats(int $userId): array
    {
        $campaigns = Campaign::where('user_id', $userId)->with('events')->get();

        $totalCampaigns = $campaigns->count();
        $totalEvents = $campaigns->sum(function ($campaign) {
            return $campaign->events->count();
        });

        $todayEvents = $campaigns->sum(function ($campaign) {
            return $campaign->events->where('opened_at', '>=', now()->startOfDay())->count();
        });

        $weekEvents = $campaigns->sum(function ($campaign) {
            return $campaign->events->where('opened_at', '>=', now()->subWeek())->count();
        });

        return [
            'total_campaigns' => $totalCampaigns,
            'total_events' => $totalEvents,
            'today_events' => $todayEvents,
            'week_events' => $weekEvents,
        ];
    }
} 