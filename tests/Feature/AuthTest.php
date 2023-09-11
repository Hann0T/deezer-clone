<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_register_user_with_valid_data(): void
    {
        $password = 'password';
        $user = User::factory()->make([
            'password' => $password
        ]);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'confirm' => $password,
            'country' => $user->country->name,
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(202);
        $this->assertEquals(User::get()->count(), 1);
    }

    public function test_cannot_register_user_with_invalid_data(): void
    {
        $data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm' => '',
            'country' => '',
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 0);
    }

    public function test_cannot_register_user_with_password_less_than_8_characters(): void
    {
        $password = '123';
        $user = User::factory()->make([
            'password' => $password
        ]);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'confirm' => $password,
            'country' => $user->country->name,
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 0);
    }

    public function test_cannot_register_user_with_existing_email(): void
    {
        $firstUser = User::factory()->create();
        $password = 'password';
        $user = User::factory()->make([
            'email' => $firstUser->email,
            'password' => $password
        ]);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'confirm' => $password,
            'country' => $user->country->name,
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 1);
    }

    public function test_cannot_register_user_without_matching_passwords(): void
    {
        $password = 'password';
        $user = User::factory()->make([
            'password' => $password
        ]);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'confirm' => 'anything',
            'country' => $user->country->name,
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 0);
    }

    public function test_cannot_register_user_without_country(): void
    {
        $password = 'password';
        $user = User::factory()->make([
            'password' => $password
        ]);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'confirm' => 'anything',
            'country' => '',
        ];

        $response = $this->post('/api/register', $data);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 0);
    }

    public function test_user_can_login(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);

        $this->assertEquals($user->tokens()->count(), 0);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertStatus(200);
        $this->assertEquals(User::get()->count(), 1);
        $this->assertEquals($user->tokens()->count(), 1);

        $response = $this->withToken($response->json()['token'])->get('/api/user');
        $response->assertStatus(200);
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);

        $this->assertEquals($user->tokens()->count(), 0);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'something'
        ]);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 1);
        $this->assertEquals($user->tokens()->count(), 0);
    }

    public function test_user_cannot_login_with_incorrect_email(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);

        $this->assertEquals($user->tokens()->count(), 0);

        $response = $this->post('/api/login', [
            'email' => 'something@email.com',
            'password' => $password
        ]);

        $response->assertStatus(422);
        $this->assertEquals(User::get()->count(), 1);
        $this->assertEquals($user->tokens()->count(), 0);
    }

    public function test_auth_user_can_logout(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => $password
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => $password
        ]);

        $token = $response->json()['token'];

        $this->assertEquals($user->tokens()->count(), 1);

        $response = $this->withToken($token)->post('/api/logout');

        $response->assertStatus(200);
        $this->assertEquals($user->tokens()->count(), 0);
    }
}
