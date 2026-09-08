<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nom_entreprise' => fake()->company(),
            'secteur' => fake()->randomElement([
                'Informatique',
                'Finance',
                'Marketing',
                'Commerce',
                'Industrie',
            ]),
            'contact' => fake()->phoneNumber(),
            'description' => fake()->paragraph(),
        ];
    }
}