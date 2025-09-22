<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CampaignSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_campaign_index_displays_global_totals_across_paginated_results(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $expectedTotalEvents = 0;
        $usedKeys = [];

        for ($i = 0; $i < 15; $i++) {
            do {
                $key = Str::random(20);
            } while (in_array($key, $usedKeys, true));

            $usedKeys[] = $key;

            $campaign = Campaign::create([
                'name' => 'Campaign ' . $i,
                'key' => $key,
                'user_id' => $user->id,
            ]);

            $eventCount = ($i % 2) + 1;
            for ($j = 0; $j < $eventCount; $j++) {
                Event::create([
                    'campaign_id' => $campaign->id,
                    'user_agent' => 'Test Agent',
                    'ip_address' => '127.0.0.' . $j,
                    'user_email' => null,
                    'opened_at' => now()->subDays($j),
                ]);
            }

            $expectedTotalEvents += $eventCount;
        }

        $foreignCampaign = Campaign::create([
            'name' => 'Foreign Campaign',
            'key' => Str::random(20),
            'user_id' => $otherUser->id,
        ]);

        Event::create([
            'campaign_id' => $foreignCampaign->id,
            'user_agent' => 'Other Agent',
            'ip_address' => '192.168.0.1',
            'user_email' => null,
            'opened_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('campaigns.index'));

        $response->assertStatus(200);

        $response->assertViewHas('summary', function ($summary) use ($expectedTotalEvents) {
            return $summary['total_campaigns'] === 15
                && $summary['total_events'] === $expectedTotalEvents
                && (float) $summary['average_reads'] === round($expectedTotalEvents / 15, 1);
        });

        $campaigns = $response->viewData('campaigns');

        $this->assertSame(15, $campaigns->total());
        $this->assertSame(10, $campaigns->perPage());
    }
}
