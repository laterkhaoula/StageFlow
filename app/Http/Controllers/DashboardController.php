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
}
