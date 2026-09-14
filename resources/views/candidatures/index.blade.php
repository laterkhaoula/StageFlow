@extends('layouts.app')

@section('content')
<div class="page-container max-w-4xl">
    <div class="mb-8">
        <h1 class="page-title">Mes candidatures</h1>
        <p class="page-subtitle">Suivez l'état et l'évolution de l'ensemble de vos candidatures déposées.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <div class="space-y-6">
        @forelse($candidatures as $candidature)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="badge {{ $candidature->statut === 'acceptee' ? 'badge-success' : ($candidature->statut === 'refusee' ? 'badge-danger' : 'badge-pending') }}">
                                {{ $candidature->statut === 'acceptee' ? 'Candidature acceptée' : ($candidature->statut === 'refusee' ? 'Candidature refusée' : 'En attente de réponse') }}
                            </span>
                            @if(optional($candidature->offre)->domaine)
                                <span class="badge badge-neutral">{{ $candidature->offre->domaine }}</span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-slate-900 leading-snug">
                            @if($candidature->offre)
                                <a href="{{ route('offres.show', $candidature->offre->id) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $candidature->offre->titre }}
                                </a>
                            @else
                                Offre supprimée
                            @endif
                        </h2>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $candidature->offre?->companyProfile?->nom_entreprise ?? 'Entreprise confidentielle' }}
                            @if(optional($candidature->offre)->localisation)
                                • {{ $candidature->offre->localisation }}
                            @endif
                        </p>
                    </div>

                    <div class="text-xs text-slate-500 font-medium shrink-0">
                        Déposée le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}
                    </div>
                </div>

                @if($candidature->message_motivation)
                    <div class="mt-6">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Message de motivation</span>
                        <p class="text-sm text-slate-700 bg-slate-50 rounded-xl p-4 border border-slate-100 whitespace-pre-wrap leading-relaxed">{{ $candidature->message_motivation }}</p>
                    </div>
                @endif

                @if($candidature->histories->isNotEmpty())
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-2">Historique</span>
                        <div class="flex flex-wrap items-center gap-3">
                            @foreach($candidature->histories as $history)
                                <div class="inline-flex items-center gap-2 text-xs bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg">
                                    <span class="font-bold text-slate-700">
                                        {{ $history->nouveau_statut === 'acceptee' ? 'Acceptée' : ($history->nouveau_statut === 'refusee' ? 'Refusée' : ucfirst($history->nouveau_statut)) }}
                                    </span>
                                    @if($history->date_changement)
                                        <span class="text-slate-400">• {{ \Carbon\Carbon::parse($history->date_changement)->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($candidature->offre)
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('offres.show', $candidature->offre->id) }}" class="btn btn-secondary btn-sm">
                            Voir la fiche de l'offre &rarr;
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                <div class="mx-auto inline-flex items-center justify-center h-14 w-14 rounded-full bg-slate-100 text-slate-400 mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Aucune candidature envoyée</h3>
                <p class="text-slate-500 mt-1">Vous n'avez pas encore postulé à une offre de stage.</p>
                <a href="{{ route('offres.index') }}" class="btn btn-primary mt-4">Consulter les offres disponibles</a>
            </div>
        @endforelse
    </div>

    @if($candidatures->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $candidatures->links() }}
        </div>
    @endif
</div>
@endsection