<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidatureRequest;
use App\Models\Candidature;
use App\Models\CandidatureHistory;
use App\Models\Offre;
use App\Notifications\CandidatureStatusUpdatedNotification;
use App\Notifications\NewCandidatureNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $profile = $user->studentProfile ?? null;

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        $candidatures = Candidature::with([
            'offre' => function ($q) {
                $q->select('id', 'titre', 'domaine', 'localisation', 'statut', 'profil_entreprise_id');
            },
            'offre.companyProfile:id,nom_entreprise',
            'histories' => function ($q) {
                $q->orderBy('date_changement');
            },
        ])
            ->where('profil_etudiant_id', $profile->id)
            ->orderByDesc('date_candidature')
            ->paginate(15)
            ->withQueryString();

        return view('candidatures.index', compact('candidatures'));
    }

    public function store(StoreCandidatureRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $offre = Offre::find($data['offre_id']);
        if (! $offre) {
            return back()->withErrors(['offre' => 'Offre introuvable.']);
        }

        $profile = $user->studentProfile ?? null;
        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        if ((string) $offre->statut === 'fermee') {
            return back()->withErrors(['offre' => "Impossible de postuler : l'offre est inactive."]);
        }

        $already = Candidature::where('profil_etudiant_id', $profile->id)
            ->where('offre_id', $offre->id)
            ->exists();

        if ($already) {
            return back()->withErrors(['candidature' => 'Vous avez déjà postulé à cette offre.']);
        }

        $candidature = Candidature::create([
            'profil_etudiant_id' => $profile->id,
            'offre_id' => $offre->id,
            'message_motivation' => $data['message_motivation'],
            'date_candidature' => now()->toDateString(),
            'statut' => 'en_attente',
        ]);

        try {
            $companyUser = $offre->companyProfile->user ?? null;
            if ($companyUser) {
                $companyUser->notify(new NewCandidatureNotification($candidature));
            }
        } catch (\Throwable $e) {
            // notification errors should not break candidature creation
        }

        return redirect()->route('offres.show', $offre)->with('success', 'Candidature envoyée.');
    }

    public function companyIndex(Request $request)
    {
        $user = $request->user();
        $companyProfileIds = $user->companyProfileIds()->toArray();

        if (empty($companyProfileIds)) {
            return back()->withErrors(['company' => 'Profil entreprise introuvable.']);
        }

        $offreIds = Offre::whereIn('profil_entreprise_id', $companyProfileIds)->pluck('id')->toArray();

        $candidatures = Candidature::with(['offre' => function ($q) {
            $q->select('id', 'titre', 'domaine', 'localisation', 'profil_entreprise_id');
        }, 'studentProfile.user'])
            ->whereIn('offre_id', $offreIds)
            ->orderByDesc('date_candidature')
            ->paginate(15)
            ->withQueryString();

        return view('candidatures.company_index', compact('candidatures'));
    }

    public function companyShow(Request $request, $candidatureId)
    {
        $candidature = Candidature::with(['offre', 'studentProfile.user'])->find($candidatureId);

        if (! $candidature) {
            abort(404);
        }

        $this->authorize('companyView', $candidature);

        $profile = $candidature->studentProfile;

        return view('candidatures.company_show', compact('candidature', 'profile'));
    }

    public function companyDownloadCv(Request $request, $candidatureId)
    {
        $candidature = Candidature::with('studentProfile')->find($candidatureId);

        if (! $candidature) {
            abort(404);
        }

        $this->authorize('companyManage', $candidature);

        $profile = $candidature->studentProfile;
        if (! $profile || empty($profile->cv_path)) {
            return back()->withErrors(['cv' => 'CV non disponible.']);
        }

        $path = $profile->cv_path;

        if (! Storage::disk('local')->exists($path)) {
            return back()->withErrors(['cv' => 'Fichier introuvable.']);
        }

        return Storage::disk('local')->download($path, basename($path));
    }

    public function companyAccept(Request $request, $candidatureId)
    {
        $candidature = Candidature::with('offre')->find($candidatureId);

        if (! $candidature) {
            abort(404);
        }

        $this->authorize('companyManage', $candidature);

        $ancien = $candidature->statut;
        if ($ancien === 'acceptee') {
            return redirect()->back()->with('info', 'Candidature déjà acceptée.');
        }

        $candidature->statut = 'acceptee';
        $candidature->save();

        CandidatureHistory::create([
            'candidature_id' => $candidature->id,
            'ancien_statut' => $ancien,
            'nouveau_statut' => 'acceptee',
            'date_changement' => now(),
        ]);

        $studentUser = $candidature->studentProfile?->user;
        if ($studentUser) {
            $studentUser->notify(new CandidatureStatusUpdatedNotification($candidature, 'acceptee'));
        }

        return redirect()->back()->with('success', 'Candidature acceptée.');
    }

    public function companyRefuse(Request $request, $candidatureId)
    {
        $candidature = Candidature::with('offre')->find($candidatureId);

        if (! $candidature) {
            abort(404);
        }

        $this->authorize('companyManage', $candidature);

        $ancien = $candidature->statut;
        if ($ancien === 'refusee') {
            return redirect()->back()->with('info', 'Candidature déjà refusée.');
        }

        $candidature->statut = 'refusee';
        $candidature->save();

        CandidatureHistory::create([
            'candidature_id' => $candidature->id,
            'ancien_statut' => $ancien,
            'nouveau_statut' => 'refusee',
            'date_changement' => now(),
        ]);

        $studentUser = $candidature->studentProfile?->user;
        if ($studentUser) {
            $studentUser->notify(new CandidatureStatusUpdatedNotification($candidature, 'refusee'));
        }

        return redirect()->back()->with('success', 'Candidature refusée.');
    }
}
