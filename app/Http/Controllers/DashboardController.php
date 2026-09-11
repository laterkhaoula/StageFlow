<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function student(Request $request)
    {
        $user = $request->user();

        $totalCandidatures = $user->candidatures()->count();
        $candidaturesEnAttente = $user->candidatures()->where('statut', 'en_attente')->count();
        $candidaturesAcceptees = $user->candidatures()->where('statut', 'acceptee')->count();
        $candidaturesRefusees = $user->candidatures()->where('statut', 'refusee')->count();
        $offresActives = Offre::query()->where('statut', 'ouverte')->count();

        return view('dashboard', compact(
            'totalCandidatures',
            'candidaturesEnAttente',
            'candidaturesAcceptees',
            'candidaturesRefusees',
            'offresActives'
        ));
    }

    public function company(Request $request)
    {
        $user = $request->user();

        $companyProfileIds = $user->companyProfiles()->pluck('id');

        $offres = Offre::query()
            ->whereIn('profil_entreprise_id', $companyProfileIds)
            ->with('candidatures')
            ->get();

        $totalOffres = $offres->count();
        $offresActives = $offres->where('statut', 'ouverte')->count();
        $offresInactives = $offres->where('statut', 'fermee')->count();

        $totalCandidatures = $offres->sum(fn ($offre) => $offre->candidatures->count());
        $candidaturesEnAttente = $offres->sum(fn ($offre) => $offre->candidatures->where('statut', 'en_attente')->count());
        $candidaturesAcceptees = $offres->sum(fn ($offre) => $offre->candidatures->where('statut', 'acceptee')->count());
        $candidaturesRefusees = $offres->sum(fn ($offre) => $offre->candidatures->where('statut', 'refusee')->count());

        return view('company-dashboard', compact(
            'totalOffres',
            'offresActives',
            'offresInactives',
            'totalCandidatures',
            'candidaturesEnAttente',
            'candidaturesAcceptees',
            'candidaturesRefusees'
        ));
    }
}
