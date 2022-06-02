<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_access()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'saymyname'),
        ]);

        $response = $this->post('/submitLogin', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_logout()
    {
        $response = $this->get('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
