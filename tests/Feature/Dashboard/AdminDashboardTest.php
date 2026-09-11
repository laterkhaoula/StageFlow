<?php

namespace Tests\Feature\Dashboard;

use App\Models\Candidature;
use App\Models\CompanyProfile;
use App\Models\Offre;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_platform_statistics(): void
    {
        $this->seed(LaratrustSeeder::class);

        $adminRole = Role::where('name', 'administrateur')->first();
        $studentRole = Role::where('name', 'etudiant')->first();
        $companyRole = Role::where('name', 'entreprise')->first();

        $admin = User::factory()->create(['role' => 'administrateur', 'email_verified_at' => now()]);
        $admin->addRole($adminRole);

        $student = User::factory()->create(['role' => 'etudiant', 'email_verified_at' => now()]);
        $student->addRole($studentRole);

        $company = User::factory()->create(['role' => 'entreprise', 'email_verified_at' => now()]);
        $company->addRole($companyRole);

        StudentProfile::factory()->create(['user_id' => $student->id]);
        $companyProfile = CompanyProfile::factory()->create(['user_id' => $company->id]);

        $offer1 = Offre::factory()->create(['profil_entreprise_id' => $companyProfile->id, 'statut' => 'ouverte']);
        $offer2 = Offre::factory()->create(['profil_entreprise_id' => $companyProfile->id, 'statut' => 'fermee']);

        Candidature::factory()->count(2)->create(['offre_id' => $offer1->id, 'statut' => 'en_attente']);
        Candidature::factory()->count(1)->create(['offre_id' => $offer1->id, 'statut' => 'acceptee']);
        Candidature::factory()->count(1)->create(['offre_id' => $offer2->id, 'statut' => 'refusee']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('3');
        $response->assertSee('1');
        $response->assertSee('1');
        $response->assertSee('2');
        $response->assertSee('1');
        $response->assertSee('4');
        $response->assertSee('2');
    }
}
