<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function update(Request $request)
    {
        $user = $request->user();

        $profile = null;
        if ($user) {
            $profile = $user->studentProfile ?? null;
        }

        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'training_domain' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string'],
        ]);

        $profile->fill($validated);
        $profile->save();

        return redirect()->back()->with('success', 'Profil étudiant mis à jour.');
    }
}
