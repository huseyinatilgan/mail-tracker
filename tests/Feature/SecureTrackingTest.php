<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessTrackingEvent;
use Tests\TestCase;

class SecureTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Enable tracking features
        config(['mailtracker.track_ip' => true]);
        config(['mailtracker.track_user_agent' => true]);
    }

    public function test_campaign_created_with_hashed_and_encrypted_keys(): void
    {
        $campaign = Campaign::factory()->create();

        $this->assertNotNull($campaign->key_hash);
        $this->assertNotNull($campaign->encrypted_key);
        // Plaintext key should not be in DB attributes (though accessor decrypts it)
        $this->assertArrayNotHasKey('key', $campaign->getAttributes());
    }

    public function test_tracking_deduplication(): void
    {
        $campaign = Campaign::factory()->create();
        $ip = '192.168.1.1';
        $ua = 'TestAgent/1.0';

        // First request: Should track
        $this->withHeaders(['User-Agent' => $ua])
            ->withServerVariables(['REMOTE_ADDR' => $ip])
            ->get(route('tracking.pixel', ['key' => $campaign->key]))
            ->assertStatus(200);

        $this->assertEquals(1, Event::count());

        // Second request (same IP/UA/Time): Should be deduplicated (not tracked)
        $this->withHeaders(['User-Agent' => $ua])
            ->withServerVariables(['REMOTE_ADDR' => $ip])
            ->get(route('tracking.pixel', ['key' => $campaign->key]))
            ->assertStatus(200);

        // Count should still be 1
        $this->assertEquals(1, Event::count());

        // Third request (different IP): Should track
        $this->withHeaders(['User-Agent' => $ua])
            ->withServerVariables(['REMOTE_ADDR' => '192.168.1.2'])
            ->get(route('tracking.pixel', ['key' => $campaign->key]))
            ->assertStatus(200);

        $this->assertEquals(2, Event::count());
    }

    public function test_proxy_detection_gmail(): void
    {
        $campaign = Campaign::factory()->create();
        $ua = 'Mozilla/5.0 (compatible; GoogleImageProxy)';

        $this->withHeaders(['User-Agent' => $ua])
            ->get(route('tracking.pixel', ['key' => $campaign->key]));

        $event = Event::first();
        $this->assertTrue((bool) $event->is_proxy);
        $this->assertEquals('gmail', $event->proxy_type);
    }

    public function test_events_are_queued(): void
    {
        Queue::fake();

        $campaign = Campaign::factory()->create();

        $this->get(route('tracking.pixel', ['key' => $campaign->key]));

        Queue::assertPushed(ProcessTrackingEvent::class);
    }
}
