<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Preference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accounts = Account::all();
        return [
            'account_id' => $accounts->random()->id,
        ];
    }
}
