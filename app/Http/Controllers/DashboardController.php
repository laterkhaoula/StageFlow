<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function student(Request $request)
    {
        $user = $request->user();
        $studentProfileId = $user->studentProfile?->id;

        if ($studentProfileId) {
            $stats = Candidature::query()
                ->where('profil_etudiant_id', $studentProfileId)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw("SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) as en_attente")
                ->selectRaw("SUM(CASE WHEN statut = 'acceptee' THEN 1 ELSE 0 END) as acceptee")
                ->selectRaw("SUM(CASE WHEN statut = 'refusee' THEN 1 ELSE 0 END) as refusee")
                ->first();

            $totalCandidatures = (int) $stats->total;
            $candidaturesEnAttente = (int) $stats->en_attente;
            $candidaturesAcceptees = (int) $stats->acceptee;
            $candidaturesRefusees = (int) $stats->refusee;
        } else {
            $totalCandidatures = 0;
            $candidaturesEnAttente = 0;
            $candidaturesAcceptees = 0;
            $candidaturesRefusees = 0;
        }

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
        $companyProfileIds = $request->user()->companyProfileIds();

        if ($companyProfileIds->isEmpty()) {
            return view('company-dashboard', [
                'totalOffres' => 0,
                'offresActives' => 0,
                'offresInactives' => 0,
                'totalCandidatures' => 0,
                'candidaturesEnAttente' => 0,
                'candidaturesAcceptees' => 0,
                'candidaturesRefusees' => 0,
            ]);
        }

        $offreStats = Offre::query()
            ->whereIn('profil_entreprise_id', $companyProfileIds)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN statut = 'ouverte' THEN 1 ELSE 0 END) as ouverte")
            ->selectRaw("SUM(CASE WHEN statut = 'fermee' THEN 1 ELSE 0 END) as fermee")
            ->first();

        $offreIds = Offre::whereIn('profil_entreprise_id', $companyProfileIds)->pluck('id');

        $candidatureStats = null;
        if ($offreIds->isNotEmpty()) {
            $candidatureStats = Candidature::query()
                ->whereIn('offre_id', $offreIds)
                ->selectRaw('COUNT(*) as total')
                ->selectRaw("SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) as en_attente")
                ->selectRaw("SUM(CASE WHEN statut = 'acceptee' THEN 1 ELSE 0 END) as acceptee")
                ->selectRaw("SUM(CASE WHEN statut = 'refusee' THEN 1 ELSE 0 END) as refusee")
                ->first();
        }

        return view('company-dashboard', [
            'totalOffres' => (int) ($offreStats->total ?? 0),
            'offresActives' => (int) ($offreStats->ouverte ?? 0),
            'offresInactives' => (int) ($offreStats->fermee ?? 0),
            'totalCandidatures' => (int) ($candidatureStats->total ?? 0),
            'candidaturesEnAttente' => (int) ($candidatureStats->en_attente ?? 0),
            'candidaturesAcceptees' => (int) ($candidatureStats->acceptee ?? 0),
            'candidaturesRefusees' => (int) ($candidatureStats->refusee ?? 0),
        ]);
    }

    public function admin()
    {
        $totalUtilisateurs = User::query()->count();

        $roleStats = User::query()
            ->selectRaw("SUM(CASE WHEN role = 'etudiant' THEN 1 ELSE 0 END) as etudiants")
            ->selectRaw("SUM(CASE WHEN role = 'entreprise' THEN 1 ELSE 0 END) as entreprises")
            ->selectRaw("SUM(CASE WHEN role = 'administrateur' THEN 1 ELSE 0 END) as administrateurs")
            ->first();

        $offreStats = Offre::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN statut = 'ouverte' THEN 1 ELSE 0 END) as ouverte")
            ->first();

        $candidatureStats = Candidature::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN statut = 'en_attente' THEN 1 ELSE 0 END) as en_attente")
            ->selectRaw("SUM(CASE WHEN statut = 'acceptee' THEN 1 ELSE 0 END) as acceptee")
            ->selectRaw("SUM(CASE WHEN statut = 'refusee' THEN 1 ELSE 0 END) as refusee")
            ->first();

        return view('admin-dashboard', [
            'totalUtilisateurs' => (int) $totalUtilisateurs,
            'totalEtudiants' => (int) ($roleStats->etudiants ?? 0),
            'totalEntreprises' => (int) ($roleStats->entreprises ?? 0),
            'totalAdministrateurs' => (int) ($roleStats->administrateurs ?? 0),
            'totalOffres' => (int) ($offreStats->total ?? 0),
            'offresActives' => (int) ($offreStats->ouverte ?? 0),
            'totalCandidatures' => (int) ($candidatureStats->total ?? 0),
            'candidaturesEnAttente' => (int) ($candidatureStats->en_attente ?? 0),
            'candidaturesAcceptees' => (int) ($candidatureStats->acceptee ?? 0),
            'candidaturesRefusees' => (int) ($candidatureStats->refusee ?? 0),
        ]);
    }
}
