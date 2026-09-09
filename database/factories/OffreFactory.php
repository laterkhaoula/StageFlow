<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offre>
 */
class OffreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'profil_entreprise_id' => CompanyProfile::factory(),
            'titre' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'domaine' => fake()->randomElement([
                'Informatique',
                'Finance',
                'Marketing',
                'Commerce',
                'Industrie',
            ]),
            'localisation' => fake()->city(),
            'date_publication' => fake()->date(),
            'statut' => fake()->randomElement([
                'ouverte',
                'fermee',
            ]),
        ];
    }
}