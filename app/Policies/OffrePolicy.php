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
        if (! $user->isEntreprise()) {
            return false;
        }

        $companyIds = $user->companyProfileIds()->toArray();
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
