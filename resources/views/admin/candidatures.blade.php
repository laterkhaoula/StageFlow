<x-app-layout>
    <div class="page-container">
        <div class="mb-8">
            <h1 class="page-title">Supervision des candidatures</h1>
            <p class="page-subtitle">Suivre l'historique global des candidatures déposées par les étudiants.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($candidatures->isEmpty())
                <div class="p-12 text-center text-slate-600">Aucune candidature enregistrée pour le moment.</div>
            @else
                <div class="table-wrap border-0">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Candidat</th>
                                <th>Offre visée</th>
                                <th>Entreprise</th>
                                <th>Statut actuel</th>
                                <th class="text-right">Date de dépôt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidatures as $candidature)
                                <tr>
                                    <td class="font-bold text-slate-900">
                                        {{ $candidature->studentProfile?->user?->name ?? 'Candidat inconnu' }}
                                    </td>
                                    <td class="text-slate-800 font-medium">
                                        {{ $candidature->offre?->titre ?? 'Offre introuvable' }}
                                    </td>
                                    <td class="text-slate-700">
                                        {{ $candidature->offre?->companyProfile?->nom_entreprise ?? 'Confidentielle' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $candidature->statut === 'acceptee' ? 'badge-success' : ($candidature->statut === 'refusee' ? 'badge-danger' : 'badge-pending') }}">
                                            {{ $candidature->statut === 'acceptee' ? 'Acceptée' : ($candidature->statut === 'refusee' ? 'Refusée' : 'En attente') }}
                                        </span>
                                    </td>
                                    <td class="text-right text-xs text-slate-500 font-medium whitespace-nowrap">
                                        {{ $candidature->created_at ? $candidature->created_at->format('d/m/Y à H:i') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if($candidatures->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $candidatures->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>