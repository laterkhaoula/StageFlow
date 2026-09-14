<?php

namespace Tests\Feature\Offres;

use App\Models\CompanyProfile;
use App\Models\Offre;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\LaratrustSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OffreBrowseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LaratrustSeeder::class);
    }

    private function createStudentUser(): User
    {
        $role = Role::where('name', 'etudiant')->first();
        $user = User::factory()->create();
        $user->addRole($role);

        return $user;
    }

    public function test_student_sees_only_active_offres(): void
    {
        $student = $this->createStudentUser();

        $active = Offre::factory()->count(3)->create(['statut' => 'ouverte']);
        $closed = Offre::factory()->count(2)->create(['statut' => 'fermee']);

        $response = $this->actingAs($student)->get(route('offres.index'));

        $response->assertOk();

        foreach ($active as $offre) {
            $response->assertSee($offre->titre);
        }

        foreach ($closed as $offre) {
            $response->assertDontSee($offre->titre);
        }
    }

    public function test_student_can_filter_offres_by_domaine(): void
    {
        $student = $this->createStudentUser();

        Offre::factory()->create(['domaine' => 'Informatique', 'statut' => 'ouverte', 'titre' => 'Stage dev']);
        Offre::factory()->create(['domaine' => 'Finance', 'statut' => 'ouverte', 'titre' => 'Stage finance']);

        $response = $this->actingAs($student)->get(route('offres.index', ['domaine' => 'Finance']));

        $response->assertOk();
        $response->assertSee('Stage finance');
        $response->assertDontSee('Stage dev');
    }

    public function test_student_can_filter_offres_by_keyword(): void
    {
        $student = $this->createStudentUser();

        Offre::factory()->create(['titre' => 'Stage développeur web', 'statut' => 'ouverte']);
        Offre::factory()->create(['titre' => 'Stage commercial', 'statut' => 'ouverte']);

        $response = $this->actingAs($student)->get(route('offres.index', ['keyword' => 'développeur']));

        $response->assertOk();
        $response->assertSee('Stage développeur web');
        $response->assertDontSee('Stage commercial');
    }

    public function test_student_cannot_access_offre_edit_actions(): void
    {
        $student = $this->createStudentUser();
        Offre::factory()->create(['statut' => 'ouverte', 'titre' => 'Offre publique']);

        $response = $this->actingAs($student)->get(route('offres.index'));

        $response->assertOk();
        $response->assertDontSee('Supprimer');
    }

    public function test_unauthenticated_user_is_redirected_from_offres_listing(): void
    {
        $this->get(route('offres.index'))->assertRedirect(route('login'));
    }
}