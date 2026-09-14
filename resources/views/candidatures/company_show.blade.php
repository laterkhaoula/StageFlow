@extends('layouts.app')

@section('content')
<div class="page-container max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('candidatures.company.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
            &larr; Retour à la liste des candidatures
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info mb-6">{{ session('info') }}</div>
    @endif

    @if(!$profile)
        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-600 shadow-sm">
            Profil du candidat introuvable.
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">{{ $profile->user->name ?? 'Candidat' }}</h1>
                    <p class="text-base text-slate-600 mt-1">{{ $profile->user->email ?? '—' }}</p>
                </div>
                <div>
                    @if($candidature->statut === 'acceptee')
                        <span class="badge badge-success text-sm px-4 py-1.5">Candidature acceptée</span>
                    @elseif($candidature->statut === 'refusee')
                        <span class="badge badge-danger text-sm px-4 py-1.5">Candidature refusée</span>
                    @else
                        <span class="badge badge-pending text-sm px-4 py-1.5">En attente de traitement</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 my-6 p-6 bg-slate-50 rounded-xl border border-slate-100">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Téléphone</span>
                    <span class="text-sm font-bold text-slate-900">{{ $profile->phone ?? 'Non renseigné' }}</span>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Adresse</span>
                    <span class="text-sm font-bold text-slate-900">{{ $profile->address ?? 'Non renseignée' }}</span>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Domaine de formation</span>
                    <span class="text-sm font-bold text-slate-900">{{ $profile->training_domain ?? 'Non spécifié' }}</span>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Date de dépôt</span>
                    <span class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</span>
                </div>
            </div>

            @if($profile->skills)
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Compétences</h3>
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 text-sm whitespace-pre-wrap leading-relaxed">
                        {{ $profile->skills }}
                    </div>
                </div>
            @endif

            <div class="mb-6">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Message de motivation</h3>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 text-sm whitespace-pre-wrap leading-relaxed">
                    {{ $candidature->message_motivation ?? 'Aucun message de motivation joint.' }}
                </div>
            </div>

            <!-- Actions sur la candidature -->
            <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-4">
                @if(!empty($profile->cv_path))
                    <a href="{{ route('candidatures.company.cv', $candidature->id) }}" class="btn btn-primary flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Télécharger le CV du candidat
                    </a>
                @endif

                @if($candidature->statut !== 'acceptee')
                    <form action="{{ route('candidatures.company.accept', $candidature->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Accepter la candidature</button>
                    </form>
                @endif

                @if($candidature->statut !== 'refusee')
                    <form action="{{ route('candidatures.company.refuse', $candidature->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Refuser la candidature</button>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection