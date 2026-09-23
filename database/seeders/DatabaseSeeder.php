<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);

        // Compte Administrateur garanti (créé à la première exécution, mis à jour ensuite).
        // Suit le même schéma que RegisteredUserController : colonne users.role + rôle Laratrust.
        $admin = User::updateOrCreate(
            ['email' => 'admin@stageflow.ma'],
            [
                'name' => 'Administrateur StageFlow',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'administrateur',
            ]
        );

        $adminRole = Role::where('name', 'administrateur')->firstOrFail();
        if (! $admin->hasRole($adminRole)) {
            $admin->addRole($adminRole);
        }

        // Compte de test Breeze (idempotent : aucun doublon, aucune donnée supprimée).
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'etudiant',
            ]
        );
    }
}