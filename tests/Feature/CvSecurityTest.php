<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CvSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LaratrustSeeder::class);
    }

    private function createStudentWithCv(): array
    {
        $role = Role::where('name', 'etudiant')->first();
        $user = User::factory()->create();
        $user->addRole($role);
        $profile = StudentProfile::factory()->create(['user_id' => $user->id]);

        Storage::fake('local');
        Storage::disk('local')->put('cvs/cv.pdf', 'contenu du CV');
        $profile->update(['cv_path' => 'cvs/cv.pdf']);

        return [$user, $profile];
    }

    public function test_unauthenticated_user_cannot_download_student_cv(): void
    {
        $this->get(route('student-profile.cv'))->assertRedirect(route('login'));
    }

    public function test_entreprise_cannot_access_student_cv_route(): void
    {
        $role = Role::where('name', 'entreprise')->first();
        $company = User::factory()->create(['role' => 'entreprise']);
        $company->addRole($role);

        $this->actingAs($company)->get(route('student-profile.cv'))->assertStatus(403);
    }

    public function test_student_can_download_own_cv(): void
    {
        [$student] = $this->createStudentWithCv();

        $this->actingAs($student)->get(route('student-profile.cv'))->assertOk();
    }

    public function test_student_profile_uses_protected_cv_route_not_public_url(): void
    {
        [$student] = $this->createStudentWithCv();

        $response = $this->actingAs($student)->get(route('student-profile.show'));

        $response->assertOk();
        $response->assertSee(route('student-profile.cv'));
        $response->assertDontSee('/storage/cvs/');
    }
}