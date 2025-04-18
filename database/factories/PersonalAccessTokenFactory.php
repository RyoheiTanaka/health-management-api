<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalAccessToken>
 */
class PersonalAccessTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tokenable_type' => $this->faker->word(),
            'tokenable_id' => fn() => User::factory()->create()->id,
            'name' => $this->faker->word(),
            'token' => hash('sha256', $this->faker->word()),
            'abilities' => '["*"]',
            'last_used_at' => $this->faker->dateTime(),
        ];
    }
}
