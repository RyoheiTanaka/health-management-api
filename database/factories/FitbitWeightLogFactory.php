<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FitbitWeightLog>
 */
class FitbitWeightLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weight' => $this->faker->randomFloat(2, 0, 100),
            'bmi' => $this->faker->randomFloat(2, 0, 100),
            'date' => $this->faker->date(),
        ];
    }
}
