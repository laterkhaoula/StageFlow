<?php

namespace App\Policies;

use App\Models\Offre;
use App\Models\User;

class OffrePolicy
{
    /**
     * Determine whether the user can update the offre.
     */
    public function update(User $user, Offre $offre): bool
    {
        if (! method_exists($user, 'hasRole') || ! $user->hasRole('entreprise')) {
            return false;
        }

        $companyIds = $user->companyProfiles()->pluck('id')->toArray();
        return in_array($offre->profil_entreprise_id, $companyIds, true);
    }

    /**
     * Determine whether the user can delete the offre.
     */
    public function delete(User $user, Offre $offre): bool
    {
        return $this->update($user, $offre);
    }
}
