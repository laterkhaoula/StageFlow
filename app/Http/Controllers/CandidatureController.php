<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre;
use App\Models\Candidature;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the authenticated student's candidatures.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $profile = $user->studentProfile ?? null;
        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        $candidatures = Candidature::with(['offre' => function ($q) {
            $q->select('id', 'titre', 'domaine', 'localisation');
        }])
            ->where('profil_etudiant_id', $profile->id)
            ->orderByDesc('date_candidature')
            ->get();

        return view('candidatures.index', compact('candidatures'));
    }
    /**
     * Store a newly created candidature for an offer by the authenticated student.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // validate input
        $data = $request->validate([
            'offre_id' => ['required', 'integer', 'exists:offres,id'],
            'message_motivation' => ['required', 'string'],
        ]);

        // find the offer
        $offre = Offre::find($data['offre_id']);
        if (!$offre) {
            return back()->withErrors(['offre' => 'Offre introuvable.']);
        }

        // get student profile
        $profile = $user->studentProfile ?? null;
        if (!$profile) {
            return back()->withErrors(['profile' => 'Profil étudiant introuvable.']);
        }

        // Prevent applications to inactive/closed offers
        // Project uses French status values (see OffreFactory): 'ouverte' / 'fermee'
        if ((string) $offre->statut === 'fermee') {
            return back()->withErrors(['offre' => "Impossible de postuler : l'offre est inactive."]);
        }

        // Prevent duplicate candidature for the same offer by this student
        $already = Candidature::where('profil_etudiant_id', $profile->id)
            ->where('offre_id', $offre->id)
            ->exists();

        if ($already) {
            return back()->withErrors(['candidature' => 'Vous avez déjà postulé à cette offre.']);
        }

        // create candidature
        $candidature = Candidature::create([
            'profil_etudiant_id' => $profile->id,
            'offre_id' => $offre->id,
            'message_motivation' => $data['message_motivation'],
            'date_candidature' => now()->toDateString(),
            'statut' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Candidature envoyée.');
    }
}
