<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function users()
    
    {
        $users = User::query()
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function offres()
    {
        $offres = Offre::query()
            ->with('companyProfile')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.offres', compact('offres'));
    }

    public function candidatures()
    {
        $candidatures = Candidature::query()
            ->with(['studentProfile.user', 'offre.companyProfile'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.candidatures', compact('candidatures'));
    }

    /**
     * Basculer le statut bloqué / actif d'un utilisateur.
     * L'administrateur ne peut jamais bloquer son propre compte.
     */
    public function toggleBlock(Request $request, User $user): RedirectResponse
    {
        abort_if($user->id === $request->user()->id, 403, 'Vous ne pouvez pas bloquer votre propre compte.');

        $user->update(['is_active' => ! (bool) $user->is_active]);

        $statut = $user->is_active ? 'débloqué' : 'bloqué';

        return redirect()->route('admin.users')
            ->with('success', "Le compte « {$user->email} » a été {$statut}.");
    }

    /**
     * Supprimer le compte d'un utilisateur.
     * L'administrateur ne peut jamais supprimer son propre compte.
     */
    public function destroyUser(Request $request, User $user): RedirectResponse
    {
        abort_if($user->id === $request->user()->id, 403, 'Vous ne pouvez pas supprimer votre propre compte.');

        DB::transaction(function () use ($user) {
            $user->roles()->detach();

            DB::table('notifications')
                ->where('notifiable_type', User::class)
                ->where('notifiable_id', $user->id)
                ->delete();

            $user->delete();
        });

        return redirect()->route('admin.users')
            ->with('success', "Le compte « {$user->email} » a été supprimé.");
    }

    /**
     * Basculer le statut d'une offre (ouverte ↔ fermée).
     */
    public function toggleOffreStatus(Offre $offre): RedirectResponse
    {
        $offre->update(['statut' => $offre->statut === 'fermee' ? 'ouverte' : 'fermee']);

        $message = $offre->statut === 'ouverte'
            ? 'L\'offre a été réactivée.'
            : 'L\'offre a été désactivée.';

        return redirect()->route('admin.offres')
            ->with('success', $message);
    }

    /**
     * Supprimer définitivement une offre (les candidatures sont supprimées en cascade).
     */
    public function destroyOffre(Offre $offre): RedirectResponse
    {
        $offre->delete();

        return redirect()->route('admin.offres')
            ->with('success', "L'offre « {$offre->titre} » a été supprimée.");
    }
}
