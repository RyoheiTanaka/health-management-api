<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FitbitBadgeLog>
 */
class FitbitBadgeLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->word(),
            'badge_type' => $this->faker->word(),
            'name' => $this->faker->word(),
            'short_name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'image300px' => $this->faker->imageUrl(),
            'image125px' => $this->faker->imageUrl(),
            'date_time' => $this->faker->dateTime(),
            'times_achieved' => $this->faker->randomNumber(),
        ];
    }
}
