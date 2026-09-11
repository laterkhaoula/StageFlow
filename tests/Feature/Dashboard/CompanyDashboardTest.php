<?php

namespace Tests\Feature\Dashboard;

use App\Models\Candidature;
use App\Models\CompanyProfile;
use App\Models\Offre;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_dashboard_shows_only_own_statistics(): void
    {
        $this->seed(LaratrustSeeder::class);

        $companyRole = Role::where('name', 'entreprise')->first();

        $companyUser = User::factory()->create([
            'email_verified_at' => now(),
            'role' => 'entreprise',
        ]);
        $companyUser->addRole($companyRole);

        $otherCompanyUser = User::factory()->create([
            'email_verified_at' => now(),
            'role' => 'entreprise',
        ]);
        $otherCompanyUser->addRole($companyRole);

        $companyProfile = CompanyProfile::factory()->create(['user_id' => $companyUser->id]);
        $otherCompanyProfile = CompanyProfile::factory()->create(['user_id' => $otherCompanyUser->id]);

        $offer1 = Offre::factory()->create(['profil_entreprise_id' => $companyProfile->id, 'statut' => 'ouverte']);
        $offer2 = Offre::factory()->create(['profil_entreprise_id' => $companyProfile->id, 'statut' => 'fermee']);
        $offer3 = Offre::factory()->create([
            'profil_entreprise_id' => $otherCompanyProfile->id,
            'titre' => 'Offre concurrente',
            'statut' => 'ouverte',
        ]);

        Candidature::factory()->count(2)->create(['offre_id' => $offer1->id, 'statut' => 'en_attente']);
        Candidature::factory()->count(1)->create(['offre_id' => $offer1->id, 'statut' => 'acceptee']);
        Candidature::factory()->count(1)->create(['offre_id' => $offer2->id, 'statut' => 'refusee']);
        Candidature::factory()->count(5)->create(['offre_id' => $offer3->id, 'statut' => 'en_attente']);

        $response = $this->actingAs($companyUser)->get(route('company.dashboard'));

        $response->assertOk();
        $response->assertSee('2');
        $response->assertSee('1');
        $response->assertSee('1');
        $response->assertSee('4');
        $response->assertSee('2');
        $response->assertSee('1');
        $response->assertDontSee('Offre concurrente');
    }
}
