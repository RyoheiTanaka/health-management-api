<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FitbitFatLog>
 */
class FitbitFatLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fat' => $this->faker->randomFloat(2, 0, 100),
            'date' => $this->faker->date(),
        ];
    }
}
