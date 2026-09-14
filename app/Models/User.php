<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laratrust\Traits\HasRolesAndPermissions;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRolesAndPermissions, Notifiable;

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function companyProfiles(): HasMany
    {
        return $this->hasMany(CompanyProfile::class);
    }

    public function companyProfileIds(): Collection
    {
        return $this->companyProfiles()->pluck('id');
    }

    public function candidatures(): HasManyThrough
    {
        return $this->hasManyThrough(
            Candidature::class,
            StudentProfile::class,
            'user_id', // Foreign key on student_profiles table...
            'profil_etudiant_id', // Foreign key on candidatures table...
            'id', // Local key on users table
            'id' // Local key on student_profiles table
        );
    }

    public function dashboardRoute(): string
    {
        if ($this->isEntreprise()) {
            return 'company.dashboard';
        }

        if ($this->isAdministrateur()) {
            return 'admin.dashboard';
        }

        return 'dashboard';
    }

    public function isEtudiant(): bool
    {
        return $this->hasRole('etudiant') || $this->role === 'etudiant';
    }

    public function isEntreprise(): bool
    {
        return $this->hasRole('entreprise') || $this->role === 'entreprise';
    }

    public function isAdministrateur(): bool
    {
        return $this->hasRole('administrateur') || $this->role === 'administrateur';
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
