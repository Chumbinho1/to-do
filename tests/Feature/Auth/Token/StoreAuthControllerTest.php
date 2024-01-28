<?php

namespace Tests\Feature\Auth\Token;

use App\Models\User;
use Tests\TestCase;

class StoreAuthControllerTest extends TestCase
{
    private string $prefix = '/api/auth/token';

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function tearDown(): void
    {
        $this->user->delete();
        parent::tearDown();
    }

    public function test_store_auth_token_route()
    {
        $response = $this->postJson($this->prefix, [
            'username' => $this->user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

    public function test_store_auth_token_json_structure()
    {
        $response = $this->postJson($this->prefix, [
            'username' => $this->user->email,
            'password' => 'password',
        ]);
        $response->assertJsonStructure([
            'data' => [
                'token',
            ],
        ]);
    }

    public function test_store_auth_token_with_invalid_credentials()
    {
        $response = $this->postJson($this->prefix, [
            'username' => $this->user->email,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(401);
    }
}
