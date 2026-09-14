<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffreRequest;
use App\Http\Requests\UpdateOffreRequest;
use App\Models\Candidature;
use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $domaine = $request->query('domaine');
        $localisation = $request->query('localisation');

        $query = Offre::with('companyProfile')
            ->where('statut', 'ouverte')
            ->latest();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('titre', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($domaine) {
            $query->where('domaine', $domaine);
        }

        if ($localisation) {
            $query->where('localisation', $localisation);
        }

        $offres = $query->paginate(10)->withQueryString();

        $domaines = Offre::where('statut', 'ouverte')
            ->distinct()
            ->orderBy('domaine')
            ->pluck('domaine');

        $user = $request->user();
        $ownedCompanyProfileIds = $user && $user->isEntreprise()
            ? $user->companyProfileIds()
            : collect();

        return view('offres.index', compact('offres', 'domaines', 'ownedCompanyProfileIds'));
    }

    public function companyIndex(Request $request)
    {
        $user = $request->user();

        $offres = Offre::with('companyProfile')
            ->whereIn('profil_entreprise_id', $user->companyProfileIds())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('offres.company_index', compact('offres'));
    }

    public function create()
    {
        return view('offres.create');
    }

    public function store(StoreOffreRequest $request)
    {
        $validated = $request->validated();

        $companyProfile = $request->user()->companyProfiles()->first();

        if (! $companyProfile) {
            return back()->withErrors(['error' => 'Profil entreprise introuvable.']);
        }

        $validated['profil_entreprise_id'] = $companyProfile->id;

        Offre::create($validated);

        return redirect()
            ->route('offres.company.index')
            ->with('success', 'Offre créée avec succès.');
    }

    public function show(Request $request, Offre $offre)
    {
        $offre->load('companyProfile');

        $user = $request->user();
        $alreadyApplied = false;
        $isOwner = false;

        if ($user) {
            if ($user->studentProfile) {
                $alreadyApplied = Candidature::where('profil_etudiant_id', $user->studentProfile->id)
                    ->where('offre_id', $offre->id)
                    ->exists();
            }

            if ($user->isEntreprise()) {
                $isOwner = $user->companyProfileIds()->contains($offre->profil_entreprise_id);
            }
        }

        return view('offres.show', compact('offre', 'alreadyApplied', 'isOwner'));
    }

    public function edit(Offre $offre)
    {
        $this->authorize('update', $offre);

        return view('offres.edit', compact('offre'));
    }

    public function update(UpdateOffreRequest $request, Offre $offre)
    {
        $this->authorize('update', $offre);
        $validated = $request->validated();
        $offre->update($validated);

        return redirect()
            ->route('offres.company.index')
            ->with('success', 'Offre modifiée avec succès.');
    }

    public function destroy(Offre $offre)
    {
        $this->authorize('delete', $offre);
        $offre->delete();

        return redirect()
            ->route('offres.company.index')
            ->with('success', 'Offre supprimée avec succès.');
    }

    public function toggleStatus(Request $request, Offre $offre)
    {
        $this->authorize('update', $offre);

        $offre->statut = $offre->statut === 'fermee' ? 'ouverte' : 'fermee';
        $offre->save();

        $message = $offre->statut === 'ouverte'
            ? 'L\'offre a été activée.'
            : 'L\'offre a été désactivée.';

        return redirect()->route('offres.company.index')->with('success', $message);
    }
}
