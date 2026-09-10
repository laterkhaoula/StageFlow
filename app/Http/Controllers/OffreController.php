<?php
namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index()
    {
        $offres = Offre::with('companyProfile')
            ->latest()
            ->get();

        return view('offres.index', compact('offres'));
    }

    public function create()
    {
        return view('offres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'domaine' => ['required', 'string', 'max:255'],
            'localisation' => ['required', 'string', 'max:255'],
            'date_publication' => ['required', 'date'],
            'statut' => ['required', 'string', 'max:255'],
        ]);

        // Ila kanet l-relation f-User model smiyatah companyProfile (singular)
        $companyProfile = $request->user()->companyProfile;

        if (!$companyProfile) {
            return back()->withErrors(['error' => 'Profil entreprise introuvable.']);
        }

        $validated['profil_entreprise_id'] = $companyProfile->id;

        Offre::create($validated);

        return redirect()
            ->route('offres.index')
            ->with('success', 'Offre créée avec succès.');
    }

    public function show(Offre $offre)
    {
        $offre->load('companyProfile');

        return view('offres.show', compact('offre'));
    }

    public function edit(Offre $offre)
    {
        return view('offres.edit', compact('offre'));
    }

    public function update(Request $request, Offre $offre)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'domaine' => ['required', 'string', 'max:255'],
            'localisation' => ['required', 'string', 'max:255'],
            'date_publication' => ['required', 'date'],
            'statut' => ['required', 'string', 'max:255'],
        ]);

        $offre->update($validated);

        return redirect()
            ->route('offres.index')
            ->with('success', 'Offre modifiée avec succès.');
    }

    public function destroy(Offre $offre)
    {
        $offre->delete();

        return redirect()
            ->route('offres.index')
            ->with('success', 'Offre supprimée avec succès.');
    }
}
