@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-4">Détails de l'offre</h1>

    <div class="bg-white border rounded p-6 shadow-sm">
        <div class="mb-4">
            <h2 class="text-xl font-bold">{{ $offre->titre }}</h2>
            <div class="text-sm text-gray-600">{{ $offre->domaine }} — {{ $offre->localisation }}</div>
        </div>

        <div class="mb-4">
            <h3 class="font-medium">Description</h3>
            <p class="mt-2 text-gray-800">{{ $offre->description }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 mb-4">
            <div>
                <div class="font-medium">Date de publication</div>
                <div>{{ $offre->date_publication }}</div>
            </div>
            <div>
                <div class="font-medium">Statut</div>
                <div>{{ $offre->statut }}</div>
            </div>
        </div>

        <div class="mb-6 text-sm text-gray-700">
            <div class="font-medium">Entreprise</div>
            <div>{{ optional($offre->companyProfile)->nom_entreprise ?? '—' }}</div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('offres.edit', $offre) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifier</a>
            <a href="{{ route('offres.index') }}" class="text-sm text-gray-600">Retour aux offres</a>
        </div>
    </div>
</div>
@endsection
