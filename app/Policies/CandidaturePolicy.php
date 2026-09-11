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
        if (! method_exists($user, 'hasRole') || ! $user->hasRole('entreprise')) {
            return false;
        }

        $companyIds = $user->companyProfiles()->pluck('id')->toArray();

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
