<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'etudiant',
        ]);

        Role::firstOrCreate([
            'name' => 'entreprise',
        ]);

        Role::firstOrCreate([
            'name' => 'administrateur',
        ]);
    }
}