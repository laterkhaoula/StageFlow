<?php

namespace App\Policies;

use App\Models\Candidature;
use App\Models\User;

class CandidaturePolicy
{
    /**
     * Determine whether the company user can view the candidature.
     */
    public function companyView(User $user, Candidature $candidature): bool
    {
        if (! $user->isEntreprise()) {
            return false;
        }

        $companyIds = $user->companyProfileIds()->toArray();

        $offre = $candidature->offre;
        if (! $offre) {
            return false;
        }

        return in_array($offre->profil_entreprise_id, $companyIds, true);
    }

    /**
     * Determine whether the company user can manage (accept/refuse/download CV) the candidature.
     */
    public function companyManage(User $user, Candidature $candidature): bool
    {
        return $this->companyView($user, $candidature);
    }
}
