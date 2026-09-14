<?php

namespace Tests\Feature\Candidatures;

use App\Models\Candidature;
use App\Models\CandidatureHistory;
use App\Models\CompanyProfile;
use App\Models\Offre;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidatureCompanyAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LaratrustSeeder::class);
    }

    private function createCompanyUser(): array
    {
        $role = Role::where('name', 'entreprise')->first();
        $user = User::factory()->create(['role' => 'entreprise']);
        $user->addRole($role);
        $profile = CompanyProfile::factory()->create(['user_id' => $user->id]);

        return [$user, $profile];
    }

    private function createStudentUser(): array
    {
        $role = Role::where('name', 'etudiant')->first();
        $user = User::factory()->create();
        $user->addRole($role);
        $profile = StudentProfile::factory()->create(['user_id' => $user->id]);

        return [$user, $profile];
    }

    public function test_company_sees_only_candidatures_of_its_own_offres(): void
    {
        [$companyA, $profileA] = $this->createCompanyUser();
        [$companyB, $profileB] = $this->createCompanyUser();

        $offreA = Offre::factory()->create(['profil_entreprise_id' => $profileA->id]);
        $offreB = Offre::factory()->create(['profil_entreprise_id' => $profileB->id]);

        [$studentA, $profileStudentA] = $this->createStudentUser();
        [$studentB, $profileStudentB] = $this->createStudentUser();

        Candidature::factory()->create(['offre_id' => $offreA->id, 'profil_etudiant_id' => $profileStudentA->id, 'statut' => 'en_attente']);
        Candidature::factory()->create(['offre_id' => $offreB->id, 'profil_etudiant_id' => $profileStudentB->id, 'statut' => 'en_attente']);

        $response = $this->actingAs($companyA)->get(route('candidatures.company.index'));

        $response->assertOk();
        $response->assertSee($studentA->name);
        $response->assertDontSee($studentB->name);
    }

    public function test_company_cannot_view_candidature_of_another_company(): void
    {
        [$companyA, $profileA] = $this->createCompanyUser();
        [$companyB, $profileB] = $this->createCompanyUser();

        $offreB = Offre::factory()->create(['profil_entreprise_id' => $profileB->id]);

        [$student, $sp] = $this->createStudentUser();

        $candidature = Candidature::factory()->create(['offre_id' => $offreB->id, 'profil_etudiant_id' => $sp->id, 'statut' => 'en_attente']);

        $response = $this->actingAs($companyA)->get(route('candidatures.company.show', $candidature->id));

        $response->assertStatus(403);
    }

    public function test_company_can_download_cv_of_its_candidate(): void
    {
        Storage::fake('local');

        [$companyA, $profileA] = $this->createCompanyUser();
        $offre = Offre::factory()->create(['profil_entreprise_id' => $profileA->id]);

        [$student, $studentProfile] = $this->createStudentUser();
        Storage::disk('local')->put('cvs/cv.pdf', 'contenu du CV');
        $studentProfile->update(['cv_path' => 'cvs/cv.pdf']);

        $candidature = Candidature::factory()->create(['offre_id' => $offre->id, 'profil_etudiant_id' => $studentProfile->id, 'statut' => 'en_attente']);

        $response = $this->actingAs($companyA)->get(route('candidatures.company.cv', $candidature->id));

        $response->assertOk();
    }

    public function test_company_cannot_download_cv_of_another_companys_candidate(): void
    {
        Storage::fake('local');

        [$companyA] = $this->createCompanyUser();
        [$companyB, $profileB] = $this->createCompanyUser();

        $offreB = Offre::factory()->create(['profil_entreprise_id' => $profileB->id]);

        [$student, $studentProfile] = $this->createStudentUser();
        Storage::disk('local')->put('cvs/cv2.pdf', 'contenu');
        $studentProfile->update(['cv_path' => 'cvs/cv2.pdf']);

        $candidature = Candidature::factory()->create(['offre_id' => $offreB->id, 'profil_etudiant_id' => $studentProfile->id, 'statut' => 'en_attente']);

        $response = $this->actingAs($companyA)->get(route('candidatures.company.cv', $candidature->id));

        $response->assertStatus(403);
    }

    public function test_company_can_accept_a_candidature(): void
    {
        [$companyA, $profileA] = $this->createCompanyUser();
        $offre = Offre::factory()->create(['profil_entreprise_id' => $profileA->id]);

        [$student, $studentProfile] = $this->createStudentUser();
        $candidature = Candidature::factory()->create([
            'offre_id' => $offre->id,
            'profil_etudiant_id' => $studentProfile->id,
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($companyA)->post(route('candidatures.company.accept', $candidature->id));

        $this->assertDatabaseHas('candidatures', ['id' => $candidature->id, 'statut' => 'acceptee']);

        $this->assertDatabaseHas('candidature_histories', [
            'candidature_id' => $candidature->id,
            'ancien_statut' => 'en_attente',
            'nouveau_statut' => 'acceptee',
        ]);

        $this->assertSame(1, $student->notifications()->count());
        $this->assertSame('App\Notifications\CandidatureStatusUpdatedNotification', $student->notifications()->first()->type);
    }

    public function test_company_can_refuse_a_candidature(): void
    {
        [$companyA, $profileA] = $this->createCompanyUser();
        $offre = Offre::factory()->create(['profil_entreprise_id' => $profileA->id]);

        [$student, $studentProfile] = $this->createStudentUser();
        $candidature = Candidature::factory()->create([
            'offre_id' => $offre->id,
            'profil_etudiant_id' => $studentProfile->id,
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($companyA)->post(route('candidatures.company.refuse', $candidature->id));

        $this->assertDatabaseHas('candidatures', ['id' => $candidature->id, 'statut' => 'refusee']);

        $this->assertDatabaseHas('candidature_histories', [
            'candidature_id' => $candidature->id,
            'ancien_statut' => 'en_attente',
            'nouveau_statut' => 'refusee',
        ]);

        $this->assertSame(1, $student->notifications()->count());
    }

    public function test_company_cannot_accept_candidature_of_another_company(): void
    {
        [$companyA] = $this->createCompanyUser();
        [$companyB, $profileB] = $this->createCompanyUser();
        $offreB = Offre::factory()->create(['profil_entreprise_id' => $profileB->id]);

        [$student, $studentProfile] = $this->createStudentUser();
        $candidature = Candidature::factory()->create([
            'offre_id' => $offreB->id,
            'profil_etudiant_id' => $studentProfile->id,
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($companyA)->post(route('candidatures.company.accept', $candidature->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('candidatures', ['id' => $candidature->id, 'statut' => 'en_attente']);
    }

    public function test_student_index_shows_only_own_candidatures(): void
    {
        [$companyA, $profileA] = $this->createCompanyUser();
        $offreA = Offre::factory()->create(['profil_entreprise_id' => $profileA->id]);

        [$student, $studentProfile] = $this->createStudentUser();
        [$otherStudent, $otherProfile] = $this->createStudentUser();

        Candidature::factory()->create(['offre_id' => $offreA->id, 'profil_etudiant_id' => $studentProfile->id, 'statut' => 'en_attente']);
        Candidature::factory()->create(['offre_id' => $offreA->id, 'profil_etudiant_id' => $otherProfile->id, 'statut' => 'en_attente']);

        $response = $this->actingAs($student)->get(route('candidatures.index'));

        $response->assertOk();
        $this->assertCount(1, $student->candidatures()->get());
        $this->assertCount(1, $otherStudent->candidatures()->get());
    }
}