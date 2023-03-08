<?php

namespace Tests;

use App\Models\Account;
use App\Models\AccountRoleUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function authenticate($user = null)
    {
        if ($user === null) {
            list($user) = $this->getTestData();
        }

        // $this->actingAs($user, 'api');

        Sanctum::actingAs(
            $user,
            ['*']
        );

        return $this;
    }

    protected function getTestData()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create([
            'name' => 'Super Admin',
            'description' => 'Admin of the account'
        ]);
        $account = Account::factory()->create([
            'owner_id' => $user->id,
            'name' => 'Account ' . $user->email,
        ]);
        AccountRoleUser::factory()->create([
            'role_id' => $role->id,
            'account_id' => $account->id,
            'user_id' => $user->id,
        ]);
        return [$user];
    }
}
