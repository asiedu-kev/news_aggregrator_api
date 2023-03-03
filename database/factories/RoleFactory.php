<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            'Super Admin',
            'User'
        ];

        $key = array_rand($roles, 1);

        return [
            'name' => $this->faker->unique()->randomElement($roles),
            'description' => 'A role for '.$roles[$key],
        ];
    }
}
