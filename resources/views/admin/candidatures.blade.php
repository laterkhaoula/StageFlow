<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidatures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Candidat</th>
                                <th class="px-4 py-2 text-left">Offre</th>
                                <th class="px-4 py-2 text-left">Entreprise</th>
                                <th class="px-4 py-2 text-left">Statut</th>
                                <th class="px-4 py-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidatures as $candidature)
                                <tr>
                                    <td class="px-4 py-2">{{ $candidature->studentProfile?->user?->name ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $candidature->offre?->titre ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $candidature->offre?->companyProfile?->nom_entreprise ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $candidature->statut }}</td>
                                    <td class="px-4 py-2">{{ $candidature->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
