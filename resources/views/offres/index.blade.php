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

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

        <!-- ================= SIDEBAR DE FILTRES (gauche) ================= -->
        <aside class="lg:col-span-1 lg:sticky lg:top-24">
            <form action="{{ route('offres.index') }}" method="GET" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-extrabold uppercase tracking-wide text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#2563EB]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Filtres
                    </h2>
                    @if(request()->hasAny(['keyword','domaine','localisation']))
                        <a href="{{ route('offres.index') }}" class="text-xs font-bold text-[#2563EB] hover:text-blue-700">Réinitialiser</a>
                    @endif
                </div>

                <div>
                    <label for="keyword" class="form-label">Recherche</label>
                    <input id="keyword" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Intitulé du poste, compétence…" class="form-input" />
                </div>

                <div>
                    <label for="domaine" class="form-label">Domaine</label>
                    <select id="domaine" name="domaine" class="form-select">
                        <option value="">Tous les domaines</option>
                        @foreach($domaines as $d)
                            <option value="{{ $d }}" @selected(request('domaine') === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="localisation" class="form-label">Localisation</label>
                    <input id="localisation" type="text" name="localisation" value="{{ request('localisation') }}" placeholder="Ville, région…" class="form-input" />
                </div>

                <button type="submit" class="btn btn-primary w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher
                </button>
            </form>

            <!-- Infos aide -->
            <div class="mt-6 bg-[#2563EB] rounded-2xl p-6 text-white shadow-sm">
                <h3 class="text-sm font-extrabold uppercase tracking-wide">Besoin d'aide ?</h3>
                <p class="mt-2 text-xs text-blue-100 leading-relaxed">Un conseiller StageFlow t'accompagne dans ta recherche et ton profil.</p>
                <a href="{{ route('notifications.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-white hover:text-[#F59E0B] transition-colors">
                    Contacter le support
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </aside>

        <!-- ================= RÉSULTATS (droite) ================= -->
        <div class="lg:col-span-3 min-w-0">
            <!-- En-tête résultats -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <p class="text-sm font-semibold text-slate-700">
                    <span class="text-[#2563EB] font-black text-lg">{{ $offres->total() }}</span>
                    offre{{ $offres->total() > 1 ? 's' : '' }} trouvée{{ $offres->total() > 1 ? 's' : '' }}
                </p>
                <form action="{{ route('offres.index') }}" method="GET" class="w-full sm:w-72">
                    @if(request('domaine'))
                        <input type="hidden" name="domaine" value="{{ request('domaine') }}" />
                    @endif
                    @if(request('localisation'))
                        <input type="hidden" name="localisation" value="{{ request('localisation') }}" />
                    @endif
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Rechercher dans les offres…" class="form-input !pl-10" />
                    </div>
                </form>
            </div>

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
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex flex-col sm:flex-row gap-5 sm:items-center">
                            <!-- Logo / initiatiale entreprise -->
                            <div class="hidden sm:flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB] font-black text-xl">
                                {{ mb_strtoupper(mb_substr($offre->companyProfile?->nom_entreprise ?? 'S', 0, 1)) }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                    <span class="badge bg-blue-50 text-[#2563EB] border border-blue-100">{{ $offre->domaine }}</span>
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

                                <h2 class="text-lg font-bold text-slate-900 leading-snug">
                                    <a href="{{ route('offres.show', $offre) }}" class="hover:text-[#2563EB] transition-colors">{{ $offre->titre }}</a>
                                </h2>

                                <p class="mt-1 text-sm font-semibold text-[#2563EB]">
                                    {{ $offre->companyProfile?->nom_entreprise ?? 'Entreprise confidentielle' }}
                                </p>

                                <div class="mt-2 flex items-center gap-4 text-xs text-slate-500">
                                    <span class="inline-flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Publié le {{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}
                                    </span>
                                    <span class="badge badge-success">Active</span>
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

                @if($offres->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $offres->appends(request()->only(['keyword','domaine','localisation']))->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection