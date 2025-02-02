<?php

namespace tests\unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('loginView');
    }

    /** @test */
    public function authenticated_user_is_redirected_from_login_form()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        $response = $this->get('/login');
        $response->assertRedirect("/EmployeeController/getUserRequests/{$user->id}");
    }

    /** @test */
    public function manager_is_redirected_to_manager_dashboard_after_login()
    {
        $user = User::factory()->create(['role' => 'manager']);
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password', // Ensure this matches the factory's default password
        ]);
        $response->assertRedirect('/ManagerController/getAllUsers');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_is_redirected_to_employee_dashboard_after_login()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password', // Ensure this matches the factory's default password
        ]);
        $response->assertRedirect("/EmployeeController/getUserRequests/{$user->id}");
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('loginView');
        $response->assertViewHas('error', 'Wrong credentials');
        $this->assertGuest();
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
