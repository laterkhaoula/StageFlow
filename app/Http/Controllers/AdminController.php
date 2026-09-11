<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::query()
            ->select('id', 'name', 'email', 'role', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function offres()
    {
        $offres = Offre::query()
            ->with('companyProfile')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.offres', compact('offres'));
    }

    public function candidatures()
    {
        $candidatures = Candidature::query()
            ->with(['studentProfile.user', 'offre.companyProfile'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.candidatures', compact('candidatures'));
    }
}
