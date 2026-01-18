<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CampaignService
{
    /**
     * Create new campaign with secure key handling
     */
    public function createCampaign(array $data, int $userId): Campaign
    {
        try {
            // Generate Key
            $key = $this->generateUniqueKey();

            // Enforce Seat Limit: 50 Campaigns Max
            if (Campaign::where('user_id', $userId)->count() >= 50) {
                throw new \Exception('Campaign limit reached (Max: 50). Please upgrade or delete old campaigns.');
            }

            $campaign = Campaign::create([
                'name' => $this->sanitizeCampaignName($data['name'] ?? ''),
                'key_hash' => hash('sha256', $key),
                'encrypted_key' => Crypt::encryptString($key),
                'user_id' => $userId,
            ]);

            Log::info('Campaign created', ['campaign_id' => $campaign->id, 'user_id' => $userId]);

            return $campaign;
        } catch (\Exception $e) {
            Log::error('Error creating campaign', ['user_id' => $userId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function sanitizeCampaignName(string $name): string
    {
        return preg_replace('/\s+/', ' ', trim(strip_tags($name)));
    }

    public function updateCampaign(Campaign $campaign, array $data): bool
    {
        try {
            $updated = $campaign->update([
                'name' => $this->sanitizeCampaignName($data['name'] ?? ''),
            ]);
            return $updated;
        } catch (\Exception $e) {
            Log::error('Error updating campaign', ['campaign_id' => $campaign->id, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function deleteCampaign(Campaign $campaign): bool
    {
        return $campaign->delete();
    }

    /**
     * Generate unique 20-char key and ensure hash uniqueness
     */
    private function generateUniqueKey(): string
    {
        $maxAttempts = 100;
        $attempts = 0;

        do {
            $key = Str::random(20);
            $keyHash = hash('sha256', $key);
            $attempts++;

            if ($attempts >= $maxAttempts) {
                throw new \RuntimeException('Failed to generate unique campaign key.');
            }
        } while (Campaign::where('key_hash', $keyHash)->exists());

        return $key;
    }

    public function getUserCampaigns(int $userId, int $perPage = 10)
    {
        return Campaign::where('user_id', $userId)
            ->withCount('events')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getCampaignDetails(int $campaignId, int $userId)
    {
        $campaign = Campaign::where('id', $campaignId)
            ->where('user_id', $userId)
            ->with([
                'events' => function ($query) {
                    // Use the configured limit or default
                    $query->orderBy('opened_at', 'desc')->limit(50);
                }
            ])
            ->first();

        if ($campaign) {
            // Decrypt key for display
            try {
                $campaign->key = Crypt::decryptString($campaign->encrypted_key);
            } catch (\Exception $e) {
                $campaign->key = 'Error decrypting key';
            }
        }

        return $campaign;
    }

    public function getUserCampaignSummary(int $userId): array
    {
        $totalCampaigns = Campaign::where('user_id', $userId)->count();
        $totalEvents = Event::whereHas('campaign', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        return [
            'total_campaigns' => $totalCampaigns,
            'total_events' => $totalEvents,
            'average_reads' => $totalCampaigns > 0 ? round($totalEvents / $totalCampaigns, 1) : 0,
        ];
    }
}
