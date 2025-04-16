<?php
// tests/Feature/User/UpdateProfileTest.php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication()
    {
        $response = $this->putJson('/api/user/profile', []);
        $response->assertStatus(401);
    }

    /** @test */
    public function it_requires_all_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->putJson('/api/user/profile', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'date_of_birth', 'phone']);
    }

    /** @test */
    public function it_updates_profile_with_valid_data()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/user/profile', [
            'name' => 'Updated Name',
            'email' => 'new@example.com',
            'date_of_birth' => '2000-01-01',
            'phone' => '0123456789',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Profile updated successfully.']);
    }
}


?>