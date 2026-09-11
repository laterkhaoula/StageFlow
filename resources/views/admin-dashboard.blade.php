<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Utilisateurs</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalUtilisateurs }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Étudiants</div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">{{ $totalEtudiants }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Entreprises</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">{{ $totalEntreprises }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Administrateurs</div>
                    <div class="mt-2 text-3xl font-bold text-purple-600">{{ $totalAdministrateurs }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Offres</div>
                    <div class="mt-2 text-3xl font-bold text-indigo-600">{{ $totalOffres }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Offres actives</div>
                    <div class="mt-2 text-3xl font-bold text-emerald-600">{{ $offresActives }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Candidatures</div>
                    <div class="mt-2 text-3xl font-bold text-sky-600">{{ $totalCandidatures }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">En attente</div>
                    <div class="mt-2 text-3xl font-bold text-yellow-600">{{ $candidaturesEnAttente }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Acceptées</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">{{ $candidaturesAcceptees }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Refusées</div>
                    <div class="mt-2 text-3xl font-bold text-red-600">{{ $candidaturesRefusees }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
