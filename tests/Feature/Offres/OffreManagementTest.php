<?php

namespace Tests\Feature\Offres;

use App\Models\CompanyProfile;
use App\Models\Offre;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OffreManagementTest extends TestCase
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

    public function test_entreprise_can_create_an_offre(): void
    {
        [$user, $profile] = $this->createCompanyUser();

        $response = $this->actingAs($user)->post(route('offres.company.store'), [
            'titre' => 'Stage développeur Laravel',
            'description' => 'Développement d\'applications web.',
            'domaine' => 'Informatique',
            'localisation' => 'Paris',
            'date_publication' => now()->toDateString(),
            'statut' => 'ouverte',
        ]);

        $response->assertRedirect(route('offres.company.index'));

        $this->assertDatabaseHas('offres', [
            'titre' => 'Stage développeur Laravel',
            'profil_entreprise_id' => $profile->id,
            'statut' => 'ouverte',
        ]);
    }

    public function test_offre_statut_must_be_ouverte_or_fermee(): void
    {
        [$user] = $this->createCompanyUser();

        $response = $this->actingAs($user)->post(route('offres.company.store'), [
            'titre' => 'Stage',
            'description' => 'Description.',
            'domaine' => 'Informatique',
            'localisation' => 'Lyon',
            'date_publication' => now()->toDateString(),
            'statut' => 'invalide',
        ]);

        $response->assertSessionHasErrors('statut');
        $this->assertDatabaseCount('offres', 0);
    }

    public function test_entreprise_can_update_own_offre(): void
    {
        [$user, $profile] = $this->createCompanyUser();
        $offre = Offre::factory()->create(['profil_entreprise_id' => $profile->id, 'statut' => 'ouverte']);

        $response = $this->actingAs($user)->put(route('offres.company.update', $offre), [
            'titre' => 'Nouveau titre',
            'description' => 'Nouvelle description.',
            'domaine' => 'Finance',
            'localisation' => 'Marseille',
            'date_publication' => $offre->date_publication,
            'statut' => 'fermee',
        ]);

        $response->assertRedirect(route('offres.company.index'));

        $this->assertDatabaseHas('offres', [
            'id' => $offre->id,
            'titre' => 'Nouveau titre',
            'statut' => 'fermee',
        ]);
    }

    public function test_entreprise_can_toggle_offre_status(): void
    {
        [$user, $profile] = $this->createCompanyUser();
        $offre = Offre::factory()->create(['profil_entreprise_id' => $profile->id, 'statut' => 'ouverte']);

        $response = $this->actingAs($user)->put(route('offres.company.toggle', $offre));

        $response->assertRedirect(route('offres.company.index'));
        $this->assertDatabaseHas('offres', ['id' => $offre->id, 'statut' => 'fermee']);

        $this->actingAs($user)->put(route('offres.company.toggle', $offre));
        $this->assertDatabaseHas('offres', ['id' => $offre->id, 'statut' => 'ouverte']);
    }

    public function test_entreprise_can_delete_own_offre(): void
    {
        [$user, $profile] = $this->createCompanyUser();
        $offre = Offre::factory()->create(['profil_entreprise_id' => $profile->id]);

        $response = $this->actingAs($user)->delete(route('offres.company.destroy', $offre));

        $response->assertRedirect(route('offres.company.index'));
        $this->assertDatabaseMissing('offres', ['id' => $offre->id]);
    }

    public function test_entreprise_cannot_modify_another_companys_offre(): void
    {
        [$owner, $ownerProfile] = $this->createCompanyUser();
        [$other] = $this->createCompanyUser();

        $offre = Offre::factory()->create(['profil_entreprise_id' => $ownerProfile->id]);

        $editResponse = $this->actingAs($other)->get(route('offres.company.edit', $offre));
        $editResponse->assertStatus(403);

        $updateResponse = $this->actingAs($other)->put(route('offres.company.update', $offre), [
            'titre' => 'Offre volée',
            'description' => 'Description.',
            'domaine' => 'Finance',
            'localisation' => 'Paris',
            'date_publication' => $offre->date_publication,
            'statut' => 'ouverte',
        ]);
        $updateResponse->assertStatus(403);

        $deleteResponse = $this->actingAs($other)->delete(route('offres.company.destroy', $offre));
        $deleteResponse->assertStatus(403);

        $this->assertDatabaseHas('offres', ['id' => $offre->id, 'titre' => $offre->titre]);
    }

    public function test_etudiant_cannot_access_company_offre_routes(): void
    {
        $role = Role::where('name', 'etudiant')->first();
        $student = User::factory()->create();
        $student->addRole($role);

        $this->actingAs($student)->get(route('offres.company.index'))->assertStatus(403);
        $this->actingAs($student)->get(route('offres.company.create'))->assertStatus(403);
        $this->actingAs($student)->post(route('offres.company.store'), [])->assertStatus(403);
    }

    public function test_unauthenticated_user_is_redirected_on_company_offre_routes(): void
    {
        $this->get(route('offres.company.index'))->assertRedirect(route('login'));
    }
}