<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Display the authenticated company's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->companyProfiles()->first() ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil entreprise introuvable.']);
        }

        return view('company_profiles.show', compact('profile'));
    }

    /**
     * Show the form for editing the authenticated company's profile.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->companyProfiles()->first() ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil entreprise introuvable.']);
        }

        return view('company_profiles.edit', compact('profile'));
    }

    /**
     * Update the authenticated company's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->companyProfiles()->first() ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil entreprise introuvable.']);
        }

        $data = $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'secteur' => ['nullable', 'string', 'max:255'],
            'contact' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $profile->fill($data);
        $profile->save();

        return redirect('/company-profile')->with('success', 'Profil entreprise mis à jour.');
    }
}
