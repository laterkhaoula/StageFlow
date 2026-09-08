<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LaratrustSeeder::class);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_as_etudiant(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'etudiant',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'student@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('etudiant'));
    }

    public function test_new_users_can_register_as_entreprise(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Company',
            'email' => 'company@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'entreprise',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'company@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('entreprise'));
    }

    public function test_user_cannot_register_as_administrateur(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'administrateur',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();

        $this->assertNull(User::where('email', 'admin@example.com')->first());
    }

    public function test_user_cannot_register_with_invalid_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'superadmin',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();

        $this->assertNull(User::where('email', 'test@example.com')->first());
    }

    public function test_user_cannot_register_without_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();

        $this->assertNull(User::where('email', 'test@example.com')->first());
    }
}
