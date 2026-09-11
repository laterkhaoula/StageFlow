<?php

namespace Tests\Feature\Dashboard;

use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_shows_only_own_statistics_and_active_offer_count(): void
    {
        $this->seed(LaratrustSeeder::class);

        $studentRole = Role::where('name', 'etudiant')->first();

        $student = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $student->addRole($studentRole);

        $otherStudent = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $otherStudent->addRole($studentRole);

        $studentProfile = StudentProfile::factory()->create(['user_id' => $student->id]);
        $otherStudentProfile = StudentProfile::factory()->create(['user_id' => $otherStudent->id]);

        Candidature::factory()->count(2)->create([
            'profil_etudiant_id' => $studentProfile->id,
            'statut' => 'en_attente',
        ]);
        Candidature::factory()->count(1)->create([
            'profil_etudiant_id' => $studentProfile->id,
            'statut' => 'acceptee',
        ]);
        Candidature::factory()->count(1)->create([
            'profil_etudiant_id' => $studentProfile->id,
            'statut' => 'refusee',
        ]);

        Candidature::factory()->count(3)->create([
            'profil_etudiant_id' => $otherStudentProfile->id,
            'statut' => 'en_attente',
        ]);

        Offre::factory()->count(4)->create(['statut' => 'ouverte']);
        Offre::factory()->count(2)->create(['statut' => 'fermee']);

        $response = $this->actingAs($student)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('4');
        $response->assertSee('2');
        $response->assertSee('1');
        $response->assertSee('1');
        $response->assertSee('4');
    }
}
