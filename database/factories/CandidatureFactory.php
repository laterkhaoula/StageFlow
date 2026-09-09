<?php

namespace Database\Factories;

use App\Models\Offre;
use App\Models\StudentProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidature>
 */
class CandidatureFactory extends Factory
{
    public function definition(): array
    {
        return [
            'profil_etudiant_id' => StudentProfile::factory(),
            'offre_id' => Offre::factory(),
            'message_motivation' => fake()->paragraph(),
            'date_candidature' => fake()->date(),
            'statut' => fake()->randomElement([
                'en_attente',
                'acceptee',
                'refusee',
            ]),
        ];
    }
}