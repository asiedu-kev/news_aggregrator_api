<?php

namespace Database\Seeders;

use App\Models\AccountRoleUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountRoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (AccountRoleUser::count() == 0) {
            AccountRoleUser::factory()
                ->count(1)
                ->create();
        }
    }
}
