<?php

namespace Tests\Feature\Candidatures;

use App\Models\Candidature;
use App\Models\CompanyProfile;
use App\Models\Offre;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidatureSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LaratrustSeeder::class);
    }

    private function createFullContext(): array
    {
        $etudiantRole = Role::where('name', 'etudiant')->first();
        $entrepriseRole = Role::where('name', 'entreprise')->first();

        $student = User::factory()->create();
        $student->addRole($etudiantRole);
        $studentProfile = StudentProfile::factory()->create(['user_id' => $student->id]);

        $companyUser = User::factory()->create(['role' => 'entreprise']);
        $companyUser->addRole($entrepriseRole);
        $companyProfile = CompanyProfile::factory()->create(['user_id' => $companyUser->id]);

        $offre = Offre::factory()->create([
            'profil_entreprise_id' => $companyProfile->id,
            'statut' => 'ouverte',
        ]);

        return [$student, $studentProfile, $companyUser, $companyProfile, $offre];
    }

    public function test_student_can_submit_a_candidature(): void
    {
        [$student, $studentProfile, $companyUser, , $offre] = $this->createFullContext();

        $response = $this->actingAs($student)->post(route('candidatures.store'), [
            'offre_id' => $offre->id,
            'message_motivation' => 'Je suis très motivé pour ce stage.',
        ]);

        $response->assertRedirect(route('offres.show', $offre));

        $this->assertDatabaseHas('candidatures', [
            'profil_etudiant_id' => $studentProfile->id,
            'offre_id' => $offre->id,
            'statut' => 'en_attente',
        ]);
    }

    public function test_student_cannot_submit_two_candidatures_to_same_offre(): void
    {
        [$student, $studentProfile, $companyUser, , $offre] = $this->createFullContext();

        Candidature::factory()->create([
            'profil_etudiant_id' => $studentProfile->id,
            'offre_id' => $offre->id,
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($student)->post(route('candidatures.store'), [
            'offre_id' => $offre->id,
            'message_motivation' => 'Deuxième tentative.',
        ]);

        $response->assertSessionHasErrors('candidature');
        $this->assertDatabaseCount('candidatures', 1);
    }

    public function test_student_cannot_submit_to_an_inactive_offre(): void
    {
        [$student, $studentProfile, $companyUser, , $offre] = $this->createFullContext();
        $offre->update(['statut' => 'fermee']);

        $response = $this->actingAs($student)->post(route('candidatures.store'), [
            'offre_id' => $offre->id,
            'message_motivation' => 'Je postule quand même.',
        ]);

        $response->assertSessionHasErrors('offre');
        $this->assertDatabaseCount('candidatures', 0);
    }

    public function test_entreprise_user_cannot_submit_candidature(): void
    {
        [$student, $studentProfile, $companyUser, $companyProfile, $offre] = $this->createFullContext();

        $response = $this->actingAs($companyUser)->post(route('candidatures.store'), [
            'offre_id' => $offre->id,
            'message_motivation' => 'Test.',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseCount('candidatures', 0);
    }

    public function test_unauthenticated_user_cannot_submit_candidature(): void
    {
        [$student, $studentProfile, $companyUser, , $offre] = $this->createFullContext();

        $response = $this->post(route('candidatures.store'), [
            'offre_id' => $offre->id,
            'message_motivation' => 'Test.',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('candidatures', 0);
    }

    public function test_submission_notifies_the_company_user(): void
    {
        [$student, $studentProfile, $companyUser, , $offre] = $this->createFullContext();

        $this->actingAs($student)->post(route('candidatures.store'), [
            'offre_id' => $offre->id,
            'message_motivation' => 'Je postule.',
        ]);

        $this->assertSame(1, $companyUser->notifications()->count());
        $notification = $companyUser->notifications()->first();
        $this->assertSame('App\Notifications\NewCandidatureNotification', $notification->type);
    }
}