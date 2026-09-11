<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard entreprise') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-7 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Offres publiées</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalOffres }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Offres actives</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">{{ $offresActives }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Offres inactives</div>
                    <div class="mt-2 text-3xl font-bold text-red-600">{{ $offresInactives }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Candidatures reçues</div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">{{ $totalCandidatures }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">En attente</div>
                    <div class="mt-2 text-3xl font-bold text-yellow-600">{{ $candidaturesEnAttente }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Acceptées</div>
                    <div class="mt-2 text-3xl font-bold text-emerald-600">{{ $candidaturesAcceptees }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Refusées</div>
                    <div class="mt-2 text-3xl font-bold text-rose-600">{{ $candidaturesRefusees }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
