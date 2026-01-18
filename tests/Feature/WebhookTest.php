<?php

namespace Tests\Feature;

use App\Events\SalesSignalDetected;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_webhook()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('webhooks.store'), [
            'url' => 'https://example.com/webhook',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('webhooks', [
            'user_id' => $user->id,
            'url' => 'https://example.com/webhook',
        ]);
    }

    public function test_sales_signal_dispatches_webhook()
    {
        Event::fake([SalesSignalDetected::class]);
        Http::fake();

        $user = User::factory()->create();
        $webhook = Webhook::create([
            'user_id' => $user->id,
            'url' => 'https://example.com/webhook',
            'events' => ['sales_signal_detected'],
        ]);

        $campaign = Campaign::factory()->create(['user_id' => $user->id]);

        // Manually trigger the listener logic (or integration test via job)
        // Here we test the Listener directly for unit logic
        $listener = new \App\Listeners\SendWebhooks();
        $event = new SalesSignalDetected([
            'campaign_id' => $campaign->id,
            'confidence' => 'high'
        ]);

        $listener->handle($event);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://example.com/webhook' &&
                $request['confidence'] == 'high';
        });
    }

    public function test_proxy_does_not_dispatch_signal()
    {
        Event::fake();

        $user = User::factory()->create();
        $campaign = Campaign::factory()->create(['user_id' => $user->id]);

        // Dispatch Job with proxy=true
        $job = new \App\Jobs\ProcessTrackingEvent([
            'campaign_id' => $campaign->id,
            'is_proxy' => true,
            'opened_at' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'GoogleImageProxy'
        ]);
        $job->handle();

        Event::assertNotDispatched(SalesSignalDetected::class);
    }

    public function test_real_open_dispatches_signal()
    {
        Event::fake();

        $user = User::factory()->create();
        $campaign = Campaign::factory()->create(['user_id' => $user->id]);

        // Dispatch Job with proxy=false
        $job = new \App\Jobs\ProcessTrackingEvent([
            'campaign_id' => $campaign->id,
            'is_proxy' => false,
            'opened_at' => now(),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0'
        ]);
        $job->handle();

        Event::assertDispatched(SalesSignalDetected::class);
    }
}
