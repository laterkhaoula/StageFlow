<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateStudentProfileRequest;

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

        // Handle CV upload if present
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $path = $file->store('cvs', 'public'); // stores in storage/app/public/cvs
            $validated['cv_path'] = $path;
        }

        $profile->fill($validated);
        $profile->save();

        return redirect()->back()->with('success', 'Profil étudiant mis à jour.');
    }
}
