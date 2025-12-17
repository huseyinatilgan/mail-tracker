<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CampaignService
{
    /**
     * Yeni kampanya oluştur
     */
    public function createCampaign(array $data, int $userId): Campaign
    {
        try {
            $campaign = Campaign::create([
                'name' => $this->sanitizeCampaignName($data['name'] ?? ''),
                'key' => $this->generateUniqueKey(),
                'user_id' => $userId,
            ]);

            Log::info('Campaign created', [
                'campaign_id' => $campaign->id,
                'user_id' => $userId,
            ]);

            return $campaign;
        } catch (\Exception $e) {
            Log::error('Error creating campaign', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Kampanya adını sanitize et
     */
    private function sanitizeCampaignName(string $name): string
    {
        // HTML etiketlerini kaldır
        $name = strip_tags($name);
        
        // Trim yap
        $name = trim($name);
        
        // Çoklu boşlukları tek boşluğa çevir
        $name = preg_replace('/\s+/', ' ', $name);
        
        return $name;
    }

    /**
     * Kampanya güncelle
     */
    public function updateCampaign(Campaign $campaign, array $data): bool
    {
        try {
            $updated = $campaign->update([
                'name' => $this->sanitizeCampaignName($data['name'] ?? ''),
            ]);

            if ($updated) {
                Log::info('Campaign updated', [
                    'campaign_id' => $campaign->id,
                    'user_id' => $campaign->user_id,
                ]);
            }

            return $updated;
        } catch (\Exception $e) {
            Log::error('Error updating campaign', [
                'campaign_id' => $campaign->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Kampanya sil
     */
    public function deleteCampaign(Campaign $campaign): bool
    {
        try {
            $campaignId = $campaign->id;
            $userId = $campaign->user_id;
            
            $deleted = $campaign->delete();

            if ($deleted) {
                Log::info('Campaign deleted', [
                    'campaign_id' => $campaignId,
                    'user_id' => $userId,
                ]);
            }

            return $deleted;
        } catch (\Exception $e) {
            Log::error('Error deleting campaign', [
                'campaign_id' => $campaign->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Benzersiz 20 karakterlik key üret
     * Sadece alfanumerik karakterler kullanılır (güvenlik için)
     */
    private function generateUniqueKey(): string
    {
        $maxAttempts = 100;
        $attempts = 0;

        do {
            // Sadece alfanumerik karakterler (büyük/küçük harf ve rakam)
            $key = Str::random(20);
            $attempts++;
            
            if ($attempts >= $maxAttempts) {
                Log::error('Failed to generate unique campaign key after max attempts');
                throw new \RuntimeException('Kampanya key oluşturulamadı. Lütfen tekrar deneyin.');
            }
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
