<?php

namespace App\Listeners;

use App\Events\SalesSignalDetected;
use App\Models\Campaign;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWebhooks implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(SalesSignalDetected $event): void
    {
        $payload = $event->payload;
        $campaignId = $payload['campaign_id'] ?? null;

        if (!$campaignId) {
            return;
        }

        $campaign = Campaign::with('user.webhooks')->find($campaignId);

        if (!$campaign || !$campaign->user) {
            return;
        }

        foreach ($campaign->user->webhooks as $webhook) {
            if (!$webhook->is_active) {
                continue;
            }

            // Verify event type subscription (if implemented, default is all/sales_signal_detected)
            $subscribedEvents = $webhook->events ?? ['sales_signal_detected'];
            if (!in_array('sales_signal_detected', $subscribedEvents)) {
                continue;
            }

            try {
                $response = Http::timeout(5)
                    ->withHeaders([
                        'X-Webhook-Secret' => $webhook->secret,
                        'Content-Type' => 'application/json',
                        'User-Agent' => 'MailTracker-Webhook/1.1',
                    ])
                    ->post($webhook->url, $payload);

                if ($response->failed()) {
                    Log::warning("Webhook failed for URL: {$webhook->url}", ['status' => $response->status()]);
                }
            } catch (\Exception $e) {
                Log::error("Webhook error for URL: {$webhook->url}", ['error' => $e->getMessage()]);
            }
        }
    }
}
