@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-4xl">
    <h1 class="text-2xl font-semibold mb-6">Mes candidatures</h1>

    @forelse($candidatures as $candidature)
        <div class="bg-white border rounded p-4 mb-4 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-800">{{ optional($candidature->offre)->titre ?? '—' }}</h2>
                    <div class="text-sm text-gray-500">{{ optional($candidature->offre)->domaine ?? '—' }} — {{ optional($candidature->offre)->localisation ?? '—' }}</div>
                </div>
                <div class="text-sm text-gray-600">
                    <div>Date : {{ $candidature->date_candidature }}</div>
                    <div>Statut : <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $candidature->statut)) }}</span></div>
                </div>
            </div>

            <div class="mt-3 text-sm text-gray-700">
                <div class="font-medium">Message de motivation</div>
                <p class="mt-1 whitespace-pre-wrap">{{ $candidature->message_motivation }}</p>
            </div>
        </div>
    @empty
        <div class="bg-white border rounded p-4 text-gray-600">Vous n'avez soumis aucune candidature.</div>
    @endforelse
</div>
@endsection
