<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TrackingPixelTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_pixel_disables_caching_and_records_each_request(): void
    {
        $user = User::factory()->create();

        $campaign = Campaign::create([
            'name' => 'Pixel Campaign',
            'key' => Str::random(20),
            'user_id' => $user->id,
        ]);

        $url = route('tracking.pixel', ['key' => $campaign->key]);

        $firstResponse = $this->withServerVariables([
            'REMOTE_ADDR' => '10.0.0.1',
        ])->get($url);

        $firstResponse->assertOk();
        $firstResponse->assertHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $firstResponse->assertHeader('Pragma', 'no-cache');
        $firstResponse->assertHeader('Expires', '0');
        $firstResponse->assertHeader('Content-Type', 'image/png');

        $this->assertDatabaseCount('events', 1);

        $secondResponse = $this->withServerVariables([
            'REMOTE_ADDR' => '10.0.0.2',
        ])->get($url);

        $secondResponse->assertOk();
        $this->assertDatabaseCount('events', 2);
    }
}
