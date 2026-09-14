<x-app-layout>
    <div class="page-container">
        <div class="mb-8">
            <h1 class="page-title">Supervision des offres de stage</h1>
            <p class="page-subtitle">Consulter l'ensemble des offres publiées par les entreprises sur StageFlow.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($offres->isEmpty())
                <div class="p-12 text-center text-slate-600">Aucune offre de stage enregistrée pour le moment.</div>
            @else
                <div class="table-wrap border-0">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Titre de l'offre</th>
                                <th>Entreprise</th>
                                <th>Domaine</th>
                                <th>Statut</th>
                                <th>Date création</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offres as $offre)
                                <tr>
                                    <td class="font-bold text-slate-900">{{ $offre->titre }}</td>
                                    <td class="text-slate-700 font-medium">{{ $offre->companyProfile?->nom_entreprise ?? 'Confidentielle' }}</td>
                                    <td><span class="badge badge-neutral">{{ $offre->domaine }}</span></td>
                                    <td>
                                        <span class="badge {{ $offre->statut === 'ouverte' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $offre->statut === 'ouverte' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-xs text-slate-500 font-medium whitespace-nowrap">
                                        {{ $offre->created_at ? $offre->created_at->format('d/m/Y à H:i') : '-' }}
                                    </td>
                                    <td class="text-right whitespace-nowrap">
                                        <a href="{{ route('offres.show', $offre) }}" class="btn btn-secondary btn-sm">Voir l'offre</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if($offres->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $offres->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>