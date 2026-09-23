<x-app-layout>
    <div class="page-container">
        <!-- Dashboard Header -->
        <div class="mb-8 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h1 class="text-3xl font-extrabold text-slate-900">
                Administration
            </h1>
            <p class="mt-2 text-base text-slate-600">
                Vue d'ensemble et supervision globale de la plateforme StageFlow.
            </p>
        </div>

        <!-- Global Platform Metrics -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 sm:gap-6 mb-10">
            <div class="stat-card">
                <div class="stat-label">Utilisateurs</div>
                <div class="stat-value text-slate-900">{{ $totalUtilisateurs }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Étudiants</div>
                <div class="stat-value text-blue-600">{{ $totalEtudiants }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Entreprises</div>
                <div class="stat-value text-purple-600">{{ $totalEntreprises }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Offres</div>
                <div class="stat-value text-emerald-600">{{ $totalOffres }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Candidatures</div>
                <div class="stat-value text-amber-600">{{ $totalCandidatures }}</div>
            </div>
        </div>

        <!-- Section Administration Modules -->
        <h2 class="text-xl font-bold text-slate-900 mb-4">Supervision et gestion</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('admin.users') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Utilisateurs</h3>
                <p class="mt-1 text-sm text-slate-600">Gérer les comptes étudiants, entreprises et administrateurs.</p>
            </a>

            <a href="{{ route('admin.offres') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="h-10 w-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 132.883v-4.883a2 2 0 00-2-2H5a2 2 0 00-2 2v4.883" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Offres de stage</h3>
                <p class="mt-1 text-sm text-slate-600">Superviser et valider les {{ $totalOffres }} offres de la plateforme.</p>
            </a>

            <a href="{{ route('admin.candidatures') }}" class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition-all">
                <div class="h-10 w-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Candidatures</h3>
                <p class="mt-1 text-sm text-slate-600">Suivre l'historique complet des {{ $totalCandidatures }} candidatures.</p>
            </a>
        </div>
    </div>
</x-app-layout>