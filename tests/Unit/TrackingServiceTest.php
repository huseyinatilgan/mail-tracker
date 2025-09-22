<?php

namespace Tests\Unit;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\User;
use App\Services\TrackingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TrackingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_campaign_stats_returns_aggregated_counts(): void
    {
        Carbon::setTestNow('2024-02-01 12:00:00');

        try {
            $user = User::factory()->create();
            $campaign = Campaign::create([
                'name' => 'Stats Campaign',
                'key' => Str::random(20),
                'user_id' => $user->id,
            ]);

            Event::create([
                'campaign_id' => $campaign->id,
                'user_agent' => 'Browser',
                'ip_address' => '10.0.0.1',
                'user_email' => null,
                'opened_at' => now()->subHours(2),
            ]);

            Event::create([
                'campaign_id' => $campaign->id,
                'user_agent' => 'Browser',
                'ip_address' => '10.0.0.2',
                'user_email' => null,
                'opened_at' => now()->subDays(3),
            ]);

            Event::create([
                'campaign_id' => $campaign->id,
                'user_agent' => 'Browser',
                'ip_address' => '10.0.0.3',
                'user_email' => null,
                'opened_at' => now()->subWeeks(2),
            ]);

            Event::create([
                'campaign_id' => $campaign->id,
                'user_agent' => 'Browser',
                'ip_address' => '10.0.0.4',
                'user_email' => null,
                'opened_at' => now()->subMonths(2),
            ]);

            $service = app(TrackingService::class);

            $stats = $service->getCampaignStats($campaign->id);

            $this->assertSame(4, $stats['total']);
            $this->assertSame(1, $stats['today']);
            $this->assertSame(2, $stats['week']);
            $this->assertSame(3, $stats['month']);
        } finally {
            Carbon::setTestNow();
        }
    }

    public function test_get_dashboard_stats_summarises_events_for_user(): void
    {
        Carbon::setTestNow('2024-02-01 12:00:00');

        try {
            $user = User::factory()->create();
            $otherUser = User::factory()->create();

            $firstCampaign = Campaign::create([
                'name' => 'First Campaign',
                'key' => Str::random(20),
                'user_id' => $user->id,
            ]);

            $secondCampaign = Campaign::create([
                'name' => 'Second Campaign',
                'key' => Str::random(20),
                'user_id' => $user->id,
            ]);

            $foreignCampaign = Campaign::create([
                'name' => 'Foreign Campaign',
                'key' => Str::random(20),
                'user_id' => $otherUser->id,
            ]);

            Event::create([
                'campaign_id' => $firstCampaign->id,
                'user_agent' => 'Agent',
                'ip_address' => '10.0.0.1',
                'user_email' => null,
                'opened_at' => now()->subHours(3),
            ]);

            Event::create([
                'campaign_id' => $firstCampaign->id,
                'user_agent' => 'Agent',
                'ip_address' => '10.0.0.2',
                'user_email' => null,
                'opened_at' => now()->subDays(2),
            ]);

            Event::create([
                'campaign_id' => $secondCampaign->id,
                'user_agent' => 'Agent',
                'ip_address' => '10.0.0.3',
                'user_email' => null,
                'opened_at' => now()->subDays(9),
            ]);

            Event::create([
                'campaign_id' => $secondCampaign->id,
                'user_agent' => 'Agent',
                'ip_address' => '10.0.0.4',
                'user_email' => null,
                'opened_at' => now()->subDays(40),
            ]);

            Event::create([
                'campaign_id' => $foreignCampaign->id,
                'user_agent' => 'Other Agent',
                'ip_address' => '10.0.1.1',
                'user_email' => null,
                'opened_at' => now()->subHours(1),
            ]);

            $service = app(TrackingService::class);

            $stats = $service->getDashboardStats($user->id);

            $this->assertSame(2, $stats['total_campaigns']);
            $this->assertSame(4, $stats['total_events']);
            $this->assertSame(1, $stats['today_events']);
            $this->assertSame(2, $stats['week_events']);
        } finally {
            Carbon::setTestNow();
        }
    }
}
