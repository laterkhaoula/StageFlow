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
}
