<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyProfileRequest;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = $request->user()->companyProfiles()->first();

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil entreprise introuvable.']);
        }

        return view('company-profile.show', compact('profile'));
    }

    public function edit(Request $request)
    {
        $profile = $request->user()->companyProfiles()->first();

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil entreprise introuvable.']);
        }

        return view('company-profile.edit', compact('profile'));
    }

    public function update(UpdateCompanyProfileRequest $request)
    {
        $profile = $request->user()->companyProfiles()->first();

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil entreprise introuvable.']);
        }

        $data = $request->validated();

        $profile->fill($data);
        $profile->save();

        return redirect()->route('company-profile.show')->with('success', 'Profil entreprise mis à jour.');
    }
}
