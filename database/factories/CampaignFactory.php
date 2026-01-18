<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = Str::random(20);
        return [
            'name' => fake()->words(3, true) . ' Campaign',
            'key_hash' => hash('sha256', $key),
            'encrypted_key' => \Illuminate\Support\Facades\Crypt::encryptString($key),
            'user_id' => User::factory(),
        ];
    }
}



