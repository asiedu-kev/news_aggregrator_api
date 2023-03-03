<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_not_login_without_validation()
    {
        $this->postJson('api/auth/login', [
            'email' => '',
            'password' => ''
        ])
            ->assertStatus(422);
    }

    public function test_user_can_login()
    {
        list($user) = $this->getTestData();
        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ])
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('access_token')
                ->has('token_type')
                ->etc()
            );
    }

    public function test_user_can_not_login_with_invalid_password_or_email()
    {
        list($user) = $this->getTestData();
        $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => '12344567'
        ])
            ->assertStatus(422);
    }

//    public function test_user_can_not_register_without_invalid_inputs()
//    {
//        $user = [
//            "first_name" => "Kenyatta",
//            "last_name" => "Lynch",
//            "password" => "123456789",
//        ];
//        $this->postJson('api/auth/register', $user)->assertStatus(422)
//            ->assertJson(fn(AssertableJson $json) => $json->has('data')
//                ->has('message')
//                ->has('data', 2)->where('data.0', 'Le champ email est obligatoire.')
//                ->etc()
//            );
//    }

//    public function test_user_can_register()
//    {
//        $user = [
//            "first_name" => "Kenyatta",
//            "last_name" => "Lynch",
//            "password" => "123456789",
//            "email" => "test@ourvoice.com",
//            "phone" => "22997979979"
//        ];
//        $this->postJson('api/auth/register', $user)
//            ->assertStatus(201);
//    }

}
