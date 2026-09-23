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
                    <table class="data-table table-fixed w-full">
                        <thead>
                            <tr>
                                <th class="px-3 py-3 w-[20%]">Titre de l'offre</th>
                                <th class="px-3 py-3 w-[17%]">Entreprise</th>
                                <th class="px-3 py-3 w-[12%]">Domaine</th>
                                <th class="px-3 py-3 w-[9%]">Statut</th>
                                <th class="px-3 py-3 w-[16%]">Date création</th>
                                <th class="px-3 py-3 w-[26%] text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offres as $offre)
                                <tr>
                                    <td class="px-3 py-3 font-bold text-slate-900">
                                        <div class="truncate" title="{{ $offre->titre }}">{{ $offre->titre }}</div>
                                    </td>
                                    <td class="px-3 py-3 text-slate-700 font-medium">
                                        <div class="truncate" title="{{ $offre->companyProfile?->nom_entreprise ?? 'Confidentielle' }}">{{ $offre->companyProfile?->nom_entreprise ?? 'Confidentielle' }}</div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge badge-neutral max-w-full truncate" title="{{ $offre->domaine }}">{{ $offre->domaine }}</span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge {{ $offre->statut === 'ouverte' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $offre->statut === 'ouverte' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-xs text-slate-500 font-medium whitespace-nowrap">
                                        {{ $offre->created_at ? $offre->created_at->format('d/m/Y à H:i') : '-' }}
                                    </td>
                                    <td class="px-3 py-3 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('offres.show', $offre) }}" class="btn btn-secondary btn-sm px-2.5 py-1.5">Voir</a>

                                            <form method="POST" action="{{ route('admin.offres.toggle-status', $offre) }}" class="inline-flex" onsubmit="return confirm('{{ $offre->statut === 'ouverte' ? 'Désactiver' : 'Activer' }} cette offre « {{ addslashes($offre->titre) }} » ?')">
                                                @csrf
                                                @if($offre->statut === 'ouverte')
                                                    <button type="submit" class="btn btn-sm px-2.5 py-1.5 bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-400">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                        Désactiver
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm px-2.5 py-1.5 bg-[#22C55E] text-white hover:bg-emerald-600 focus:ring-emerald-400">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Activer
                                                    </button>
                                                @endif
                                            </form>

                                            <form method="POST" action="{{ route('admin.offres.destroy', $offre) }}" class="inline-flex" onsubmit="return confirm('Supprimer définitivement cette offre « {{ addslashes($offre->titre) }} » ? Toutes les candidatures associées seront supprimées. Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-2.5 py-1.5">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
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