<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'user_agent' => fake()->userAgent(),
            'ip_address' => fake()->ipv4(),
            'user_email' => fake()->optional()->safeEmail(),
            'opened_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}



