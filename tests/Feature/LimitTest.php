<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use App\Services\CampaignService;
use App\Services\TrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_campaign_limit_per_seat()
    {
        $user = User::factory()->create();
        $service = new CampaignService();

        // Create 50 campaigns
        Campaign::factory()->count(50)->create(['user_id' => $user->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Campaign limit reached');

        $service->createCampaign(['name' => 'Overflow Campaign'], $user->id);
    }

    public function test_event_limit_per_seat()
    {
        $user = User::factory()->create();
        $campaign = Campaign::factory()->create(['user_id' => $user->id]);
        $service = new TrackingService();
        $request = Request::create('/track/' . $campaign->key);

        // Mock Cache to simulate 1000 events already
        $today = now()->format('Y-m-d');
        $seatLimitKey = "seat_limit:{$user->id}:{$today}";
        Cache::put($seatLimitKey, 1000, 60);

        $result = $service->trackEvent($campaign->key, $request);

        $this->assertFalse($result);
        // Log::shouldReceive('warning')->with('Seat limit exceeded', ...); // Can verify log if needed
    }

    public function test_event_under_limit_increments_cache()
    {
        $user = User::factory()->create();
        $campaign = Campaign::factory()->create(['user_id' => $user->id]);
        $service = new TrackingService();
        $request = Request::create('/track/' . $campaign->key);

        $today = now()->format('Y-m-d');
        $seatLimitKey = "seat_limit:{$user->id}:{$today}";
        Cache::forget($seatLimitKey);

        $result = $service->trackEvent($campaign->key, $request);

        $this->assertTrue($result);
        $this->assertEquals(1, Cache::get($seatLimitKey));
    }
}
