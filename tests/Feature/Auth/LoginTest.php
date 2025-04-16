<?php
// tests/Feature/Auth/LoginTest.php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_email_and_password()
    {
        $response = $this->postJson('/api/login', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function it_requires_valid_email_format()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid-email',
            'password' => 'secret123'
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_rejects_wrong_credentials()
    {
        User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('correctpass'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@test.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401)
                 ->assertJsonFragment(['message' => 'Invalid email or password']);
    }

    /** @test */
    public function it_logs_user_in_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@test.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'User', 'Token']);
    }
    
}

?>