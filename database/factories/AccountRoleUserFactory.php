<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountRoleUser>
 */
class AccountRoleUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        $accounts = Account::all();
        $roles = Role::all();
        $userId = $users->random()->id;
        $accountId = $accounts->random()->id;
        User::find($userId)->update(['current_account_id' => $accountId]);
        return [
            'user_id' => $userId,
            'account_id' => $accountId,
            'role_id' => $roles->random()->id,
        ];
    }
}
