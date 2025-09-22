<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Support\Str;

class CampaignService
{
    /**
     * Yeni kampanya oluştur
     */
    public function createCampaign(array $data, int $userId): Campaign
    {
        return Campaign::create([
            'name' => $data['name'],
            'key' => $this->generateUniqueKey(),
            'user_id' => $userId,
        ]);
    }

    /**
     * Kampanya güncelle
     */
    public function updateCampaign(Campaign $campaign, array $data): bool
    {
        return $campaign->update([
            'name' => $data['name'],
        ]);
    }

    /**
     * Kampanya sil
     */
    public function deleteCampaign(Campaign $campaign): bool
    {
        return $campaign->delete();
    }

    /**
     * Benzersiz 20 karakterlik key üret
     */
    private function generateUniqueKey(): string
    {
        do {
            $key = Str::random(20);
        } while (Campaign::where('key', $key)->exists());

        return $key;
    }

    /**
     * Kullanıcının kampanyalarını getir
     */
    public function getUserCampaigns(int $userId, int $perPage = 10)
    {
        return Campaign::where('user_id', $userId)
            ->withCount('events')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Kampanya detaylarını getir
     */
    public function getCampaignDetails(int $campaignId, int $userId)
    {
        return Campaign::where('id', $campaignId)
            ->where('user_id', $userId)
            ->with(['events' => function ($query) {
                $query->orderBy('opened_at', 'desc');
            }])
            ->first();
    }

    /**
     * Kullanıcının kampanyalarına ait istatistikleri getir
     */
    public function getUserCampaignSummary(int $userId): array
    {
        $totalCampaigns = Campaign::where('user_id', $userId)->count();

        $totalEvents = Event::whereHas('campaign', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        return [
            'total_campaigns' => $totalCampaigns,
            'total_events' => $totalEvents,
            'average_reads' => $totalCampaigns > 0
                ? round($totalEvents / $totalCampaigns, 1)
                : 0,
        ];
    }
}
