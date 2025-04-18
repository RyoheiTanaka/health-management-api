<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FitbitSleepLog>
 */
class FitbitSleepLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'duration' => $this->faker->randomNumber(),
            'efficiency' => $this->faker->randomNumber(),
            'info_code' => $this->faker->randomNumber(),
            'date_of_sleep' => $this->faker->date(),
            'end_time' => $this->faker->dateTime(),
        ];
    }
}
