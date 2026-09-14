@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="mb-8">
        <h1 class="page-title">Trouvez votre stage</h1>
        <p class="page-subtitle">Découvrez et filtrez les opportunités de stage adaptées à votre profil.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Zone de recherche -->
    <form action="{{ route('offres.index') }}" method="GET" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4">
            <div class="sm:col-span-2 lg:col-span-4">
                <label for="keyword" class="form-label">Mot-clé</label>
                <input id="keyword" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Intitulé du poste, compétence…" class="form-input" />
            </div>

            <div class="lg:col-span-3">
                <label for="domaine" class="form-label">Domaine</label>
                <select id="domaine" name="domaine" class="form-select">
                    <option value="">Tous les domaines</option>
                    @foreach($domaines as $d)
                        <option value="{{ $d }}" @selected(request('domaine') === $d)>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-3">
                <label for="localisation" class="form-label">Localisation</label>
                <input id="localisation" type="text" name="localisation" value="{{ request('localisation') }}" placeholder="Ville, région…" class="form-input" />
            </div>

            <div class="flex items-end lg:col-span-2">
                <button type="submit" class="btn btn-primary w-full h-[42px]">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher
                </button>
            </div>
        </div>

        @if(request()->hasAny(['keyword','domaine','localisation']))
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                <span class="text-slate-500">Filtres actifs</span>
                <a href="{{ route('offres.index') }}" class="btn-link">Réinitialiser les filtres</a>
            </div>
        @endif
    </form>

    <!-- Liste des offres -->
    @if($offres->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="mx-auto inline-flex items-center justify-center h-14 w-14 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Aucune offre trouvée</h3>
            <p class="text-slate-500 mt-1">Aucune offre ne correspond à vos critères de recherche actuels.</p>
            @if(request()->hasAny(['keyword','domaine','localisation']))
                <a href="{{ route('offres.index') }}" class="btn btn-secondary mt-4">Réinitialiser les filtres</a>
            @endif
        </div>
    @else
        <div class="space-y-4">
            @foreach($offres as $offre)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row gap-6 sm:items-center hover:border-slate-300 hover:shadow-md transition-all">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="badge badge-neutral">{{ $offre->domaine }}</span>
                            @if($offre->localisation)
                                <span class="inline-flex items-center text-xs font-medium text-slate-500">
                                    <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $offre->localisation }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-slate-900 leading-snug">
                            <a href="{{ route('offres.show', $offre) }}" class="hover:text-blue-600 transition-colors">{{ $offre->titre }}</a>
                        </h2>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $offre->companyProfile?->nom_entreprise ?? 'Entreprise confidentielle' }}
                        </p>

                        <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                            <span>Publié le {{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                        <a href="{{ route('offres.show', $offre) }}" class="btn btn-primary">
                            Voir l'offre
                        </a>
                        @if($ownedCompanyProfileIds->contains($offre->profil_entreprise_id))
                            <a href="{{ route('offres.company.edit', $offre) }}" class="btn btn-secondary">Modifier</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $offres->appends(request()->only(['keyword','domaine','localisation']))->links() }}
        </div>
    @endif
</div>
@endsection