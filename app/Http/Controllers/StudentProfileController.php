<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateStudentProfileRequest;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    

    /**
     * Display the authenticated student's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->studentProfile ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        return view('student_profiles.show', compact('profile'));
    }

    /**
     * Show the form for editing the authenticated student's profile.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->studentProfile ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        return view('student_profiles.edit', compact('profile'));
    }

    /**
     * Update the authenticated student's profile.
     */
    public function update(UpdateStudentProfileRequest $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->studentProfile ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        $validated = $request->validated();

        // Handle CV upload if present: store new file, remove old file, update path
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            // store new file on private local disk
            $newPath = $file->store('cvs', 'local'); // storage/app/private/cvs

            // remove previous file if present (try both public and local)
            if (!empty($profile->cv_path)) {
                if (Storage::disk('public')->exists($profile->cv_path)) {
                    Storage::disk('public')->delete($profile->cv_path);
                }
                if (Storage::disk('local')->exists($profile->cv_path)) {
                    Storage::disk('local')->delete($profile->cv_path);
                }
            }

            $validated['cv_path'] = $newPath;
        }

        $profile->fill($validated);
        $profile->save();

        return redirect()->back()->with('success', 'Profil étudiant mis à jour.');
    }

    /**
     * Download the authenticated student's CV.
     */
    public function downloadCv(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->studentProfile ?? null;
        }

        if (!$profile || empty($profile->cv_path)) {
            return response()->json(['message' => "CV introuvable."], 404);
        }

        $path = $profile->cv_path;

        if (!Storage::disk('local')->exists($path)) {
            return response()->json(['message' => "Fichier CV non trouvé sur le serveur."], 404);
        }

        return Storage::disk('local')->download($path, basename($path));
    }
}
