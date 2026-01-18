<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessTrackingEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data Event data to be stored
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $event = Event::create($this->data);

            // Dispatch Sales Signal if it's not a proxy
            // Strategy: "Signal without action is noise."
            if (empty($this->data['is_proxy']) || $this->data['is_proxy'] === false) {
                \App\Events\SalesSignalDetected::dispatch([
                    'campaign_id' => $event->campaign_id,
                    'event_id' => $event->id,
                    'occurred_at' => $event->opened_at,
                    'confidence' => 'high', // Validated unique open
                    // Add other payload data as needed
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to process tracking event', [
                'error' => $e->getMessage(),
                'data' => $this->data
            ]);
            // Optionally release the job back to the queue
            // $this->release(10);
        }
    }
}
