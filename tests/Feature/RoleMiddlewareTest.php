<?php

namespace Tests\Feature;

use App\Models\CompanyProfile;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LaratrustSeeder::class);
    }

    public function test_unauthenticated_user_cannot_access_protected_route(): void
    {
        $response = $this->get(route('test.etudiant'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_etudiant_can_access_etudiant_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'etudiant')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.etudiant'));

        $response->assertStatus(200);
        $response->assertSee('Accès étudiant autorisé');
    }

    public function test_entreprise_cannot_access_etudiant_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'entreprise')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.etudiant'));

        $response->assertStatus(403);
    }

    public function test_administrateur_cannot_access_etudiant_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'administrateur')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.etudiant'));

        $response->assertStatus(403);
    }

    public function test_entreprise_can_access_entreprise_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'entreprise')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.entreprise'));

        $response->assertStatus(200);
        $response->assertSee('Accès entreprise autorisé');
    }

    public function test_etudiant_cannot_access_entreprise_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'etudiant')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.entreprise'));

        $response->assertStatus(403);
    }

    public function test_administrateur_cannot_access_entreprise_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'administrateur')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.entreprise'));

        $response->assertStatus(403);
    }

    public function test_administrateur_can_access_administrateur_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'administrateur')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.administrateur'));

        $response->assertStatus(200);
        $response->assertSee('Accès administrateur autorisé');
    }

    public function test_etudiant_cannot_access_administrateur_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'etudiant')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.administrateur'));

        $response->assertStatus(403);
    }

    public function test_entreprise_cannot_access_administrateur_route(): void
    {
        $user = User::factory()->create();
        $role = Role::where('name', 'entreprise')->first();
        $user->addRole($role);

        $response = $this->actingAs($user)->get(route('test.administrateur'));

        $response->assertStatus(403);
    }

    public function test_student_profile_route_requires_student_role(): void
    {
        $student = User::factory()->create();
        $studentRole = Role::where('name', 'etudiant')->first();
        $student->addRole($studentRole);
        StudentProfile::factory()->create(['user_id' => $student->id]);

        $studentResponse = $this->actingAs($student)->get(route('student-profile.show'));
        $studentResponse->assertStatus(200);

        $company = User::factory()->create();
        $companyRole = Role::where('name', 'entreprise')->first();
        $company->addRole($companyRole);

        $companyResponse = $this->actingAs($company)->get(route('student-profile.show'));
        $companyResponse->assertStatus(403);
    }

    public function test_company_profile_route_requires_company_role(): void
    {
        $company = User::factory()->create();
        $companyRole = Role::where('name', 'entreprise')->first();
        $company->addRole($companyRole);
        CompanyProfile::factory()->create(['user_id' => $company->id]);

        $companyResponse = $this->actingAs($company)->get(route('company-profile.show'));
        $companyResponse->assertStatus(200);

        $student = User::factory()->create();
        $studentRole = Role::where('name', 'etudiant')->first();
        $student->addRole($studentRole);

        $studentResponse = $this->actingAs($student)->get(route('company-profile.show'));
        $studentResponse->assertStatus(403);
    }
}