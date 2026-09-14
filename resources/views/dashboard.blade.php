<x-app-layout>
    <div class="min-h-screen dashboard-background">
        <div class="page-container">
        <!-- Dashboard Header -->
        <div class="mb-8 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h1 class="text-3xl font-extrabold text-slate-900">
                Bonjour, {{ auth()->user()->name }} 👋
            </h1>
            <p class="mt-2 text-base text-slate-600">
                Voici un aperçu de vos candidatures et opportunités.
            </p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-10">
            <div class="stat-card">
                <div class="stat-label">Candidatures</div>
                <div class="stat-value text-slate-900">{{ $totalCandidatures }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">En attente</div>
                <div class="stat-value text-amber-600">{{ $candidaturesEnAttente }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Acceptées</div>
                <div class="stat-value text-emerald-600">{{ $candidaturesAcceptees }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Refusées</div>
                <div class="stat-value text-red-600">{{ $candidaturesRefusees }}</div>
            </div>
        </div>

        <!-- Section Navigation Accès Rapide -->
        <h2 class="text-xl font-bold text-slate-900 mb-4">Accès rapide</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('offres.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 group-hover:translate-x-1 transition-transform">Explorer &rarr;</span>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Trouver une offre</h3>
                <p class="mt-1 text-sm text-slate-600">Recherchez un stage parmi {{ $offresActives }} offres actives et déposez votre candidature.</p>
            </a>

            <a href="{{ route('candidatures.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 group-hover:translate-x-1 transition-transform">Voir tout &rarr;</span>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Mes candidatures</h3>
                <p class="mt-1 text-sm text-slate-600">Suivez l'évolution en temps réel de vos {{ $totalCandidatures }} candidatures déposées.</p>
            </a>

            <a href="{{ route('student-profile.show') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="h-10 w-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 group-hover:translate-x-1 transition-transform">Gérer &rarr;</span>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">Mon profil & CV</h3>
                <p class="mt-1 text-sm text-slate-600">Mettez à jour vos compétences, votre formation et téléchargez votre CV.</p>
            </a>
        </div>
        </div>
    </div>
</x-app-layout>