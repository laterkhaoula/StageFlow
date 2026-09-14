@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="page-container max-w-4xl">
    <!-- Navigation fil d'ariane / retour -->
    <div class="mb-6">
        <a href="{{ route('offres.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour aux offres
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Carte principale de l'offre -->
    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm mb-8">
        <div class="flex flex-wrap items-start justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="badge badge-neutral">{{ $offre->domaine }}</span>
                    <span class="badge {{ $offre->statut === 'ouverte' ? 'badge-success' : 'badge-danger' }}">
                        {{ $offre->statut === 'ouverte' ? 'Offre active' : 'Offre inactive' }}
                    </span>
                </div>

                <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">{{ $offre->titre }}</h1>
                <p class="mt-2 text-lg font-semibold text-blue-600">{{ $offre->companyProfile?->nom_entreprise ?? 'Entreprise confidentielle' }}</p>
            </div>
        </div>

        <!-- Informations importantes en grille -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 py-6 border-b border-slate-100 bg-slate-50/50 rounded-xl p-4 my-6">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Localisation</span>
                <span class="text-sm font-bold text-slate-900 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $offre->localisation ?? 'Non spécifiée' }}
                </span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Domaine</span>
                <span class="text-sm font-bold text-slate-900">{{ $offre->domaine }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Date de publication</span>
                <span class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</span>
            </div>
        </div>

        <!-- Description de l'offre -->
        <div class="mt-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Description de l'offre</h2>
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed whitespace-pre-wrap text-base">
                {{ $offre->description }}
            </div>
        </div>
    </div>

    @auth
        @if($isOwner)
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('offres.company.edit', $offre) }}" class="btn btn-primary">Modifier l'offre</a>
                <a href="{{ route('offres.company.index') }}" class="btn btn-secondary">Gestion de mes offres</a>
            </div>
        @endif
    @endauth

    <!-- Section Postuler pour Étudiant -->
    @auth
        @if($user->isEtudiant())
            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Postuler à cette offre</h2>
                <p class="text-slate-600 mb-6 text-sm">Transmettez votre candidature à l'entreprise accompagnée d'un message de motivation.</p>

                @if($errors->any())
                    <div class="alert alert-error mb-6">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($offre->statut !== 'ouverte')
                    <div class="alert alert-info">Cette offre n'est plus active. Vous ne pouvez plus y postuler.</div>
                @elseif($alreadyApplied)
                    <div class="alert alert-success">
                        Vous avez déjà postulé à cette offre. Suivez son évolution depuis
                        <a href="{{ route('candidatures.index') }}" class="font-bold underline ml-1">vos candidatures</a>.
                    </div>
                @else
                    <form action="{{ route('candidatures.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="offre_id" value="{{ $offre->id }}" />

                        <div>
                            <label for="message_motivation" class="form-label">Message de motivation</label>
                            <textarea id="message_motivation" name="message_motivation" rows="5" class="form-textarea" placeholder="Expliquez brièvement pourquoi ce stage vous intéresse et correspond à vos compétences...">{{ old('message_motivation') }}</textarea>
                            @error('message_motivation')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="btn btn-success text-base px-8 py-3">
                                Postuler maintenant
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @endif
    @endauth
</div>
@endsection