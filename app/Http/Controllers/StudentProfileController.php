<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStudentProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        return view('student_profiles.show', compact('profile'));
    }

    public function edit(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        return view('student_profiles.edit', compact('profile'));
    }

    public function update(UpdateStudentProfileRequest $request)
    {
        $profile = $request->user()->studentProfile;

        if (! $profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        $validated = $request->validated();

        if ($request->hasFile('cv')) {
            $newPath = $request->file('cv')->store('cvs', 'local');

            if (! empty($profile->cv_path)) {
                Storage::disk('local')->delete($profile->cv_path);
            }

            $validated['cv_path'] = $newPath;
        }

        $profile->fill($validated);
        $profile->save();

        return redirect()->route('student-profile.show')->with('success', 'Profil étudiant mis à jour.');
    }

    public function downloadCv(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (! $profile || empty($profile->cv_path)) {
            return back()->withErrors(['cv' => 'CV introuvable.']);
        }

        $path = $profile->cv_path;

        if (! Storage::disk('local')->exists($path)) {
            return back()->withErrors(['cv' => 'Fichier CV non trouvé sur le serveur.']);
        }

        return Storage::disk('local')->download($path, basename($path));
    }
}
