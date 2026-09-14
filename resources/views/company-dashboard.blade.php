<x-app-layout>
    <div class="page-container">
        <!-- Dashboard Header -->
        <div class="mb-8 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">
                    Tableau de bord entreprise
                </h1>
                <p class="mt-2 text-base text-slate-600">
                    Gérez vos offres de stage et traitez les candidatures des étudiants.
                </p>
            </div>
            <a href="{{ route('offres.company.create') }}" class="btn btn-primary whitespace-nowrap self-start sm:self-auto">
                + Publier une offre
            </a>
        </div>

        <!-- Stat Cards Recruteur -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-10">
            <div class="stat-card">
                <div class="stat-label">Offres publiées</div>
                <div class="stat-value text-slate-900">{{ $totalOffres }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Offres actives</div>
                <div class="stat-value text-emerald-600">{{ $offresActives }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Candidatures reçues</div>
                <div class="stat-value text-blue-600">{{ $totalCandidatures }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">En attente de traitement</div>
                <div class="stat-value text-amber-600">{{ $candidaturesEnAttente }}</div>
            </div>
        </div>

        <!-- Section Navigation Accès Rapide Recruteur -->
        <h2 class="text-xl font-bold text-slate-900 mb-4">Gestion des recrutements</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('offres.company.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 group-hover:translate-x-1 transition-transform">Gérer &rarr;</span>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Mes offres de stage</h3>
                <p class="mt-1 text-sm text-slate-600">Consulter, modifier ou désactiver vos {{ $totalOffres }} offres publiées.</p>
            </a>

            <a href="{{ route('candidatures.company.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 group-hover:translate-x-1 transition-transform">Consulter &rarr;</span>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Candidatures reçues</h3>
                <p class="mt-1 text-sm text-slate-600">Traiter et répondre aux {{ $totalCandidatures }} candidatures déposées par les étudiants.</p>
            </a>

            <a href="{{ route('company-profile.show') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="h-10 w-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 group-hover:translate-x-1 transition-transform">Éditer &rarr;</span>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Profil Entreprise</h3>
                <p class="mt-1 text-sm text-slate-600">Présentez votre entreprise, votre secteur d'activité et vos coordonnées.</p>
            </a>
        </div>
    </div>
</x-app-layout>