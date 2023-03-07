<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Business', 'Technology', 'Sports', 'Politics'];
        return [
            'name' => $this->faker->randomElement($categories),
            'description' => $this->faker->sentence
        ];
    }
}
