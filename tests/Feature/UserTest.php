<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'savanosr',
            'password' => 'rahasiabanget',
            'name' => 'vano'
        ])->assertStatus(201)
        ->assertJson([
            'data'=> [
                'username' => 'savanosr',
                'name' => 'vano'
            ]
        ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/users', [
            'username' => 'savanosr',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
        ->assertJson([
            'errors'=> [
                'password' => [
                    'The password field is required.'
                ],
                'name' => [
                    'The name field is required.'
                ]
            ]
        ]);
    }

    public function testRegisterUsernameAlreadyExist()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'savanosr',
            'password' => 'rahasiabanget',
            'name' => 'vano'
        ])->assertStatus(400)
        ->assertJson([
            'errors'=> [
                'username' => ['Username telah terdaftar'],
            ]
        ]);
    }

    public function testUserLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'test',
        ])->assertStatus(200);
        $user = User::where('username', 'test')->first();
        assertNotNull($user->token);
    }

    public function testUserLoginFailedUsernameNotFound()
    {
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'test',
        ])->assertStatus(401)
        ->assertJson([
            'errors'=> [
                'message' => ['username atau password salah'],
            ]
        ]);
    }
    public function testUserLoginFailedPasswordNotFound()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'salah',
        ])->assertStatus(401)
        ->assertJson([
            'errors'=> [
                'message' => ['username atau password salah'],
            ]
        ]);
    }

    public function testUserGetSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/current', [
            'Authorization' => 'test'
        ])->assertStatus(200)
        ->assertJson([
            'data'=> [
                'username' => 'test',
                'name' => 'test',
            ]
        ]);
    }
    public function testUserInvalidToken()
    {}
    public function testUserGetUnauthorized()
    {}
}
