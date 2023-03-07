<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sources = ['BBC NEWS', 'GUARDIAN_NEWS', 'NEW_YORK_TIMES'];
        return [
            'name' => $this->faker->randomElement($sources),
            'description' => $this->faker->sentence
        ];
    }
}
