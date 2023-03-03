<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all();
        return [
            'owner_id' => $user->random()->id,
            'name' => 'Default Company',
            'status' => 'active',
            'timezone' => 'UTC+1',
            'country' => 'Benin'
        ];
    }
}
