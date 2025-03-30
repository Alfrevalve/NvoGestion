<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // Create a user
        $user = \App\Models\User::factory()->create([
            'nombre' => 'Jasen',
            'apellidos' => 'Dickinson',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Attempt to log in
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Assert the user is redirected to the dashboard
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        // Attempt to log in with invalid credentials
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // Assert the user is redirected back to the login page
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }
}
