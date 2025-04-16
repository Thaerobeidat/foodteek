<?php 
// tests/Feature/Auth/ResetPasswordTest.php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_email_and_password()
    {
        $response = $this->postJson('/api/reset-password', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function it_requires_valid_email()
    {
        $response = $this->postJson('/api/reset-password', [
            'email' => 'not-an-email',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_requires_password_confirmation()
    {
        $response = $this->postJson('/api/reset-password', [
            'email' => 'user@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'mismatch',
        ]);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_resets_password_for_valid_user()
    {
        $user = User::factory()->create([
            'email' => 'reset@test.com',
            'password' => bcrypt('oldpassword'),
        ]);

        $response = $this->postJson('/api/reset-password', [
            'email' => 'reset@test.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Password reset successful']);
    }
    /** @test */
public function it_returns_error_for_unregistered_email()
{
    $response = $this->postJson('/api/reset-password', [
        'email' => 'nonexistent@example.com',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertStatus(404)
             ->assertJson(['message' => 'User not found']);
}

}

?>