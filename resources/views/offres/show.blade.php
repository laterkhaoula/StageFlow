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

    @auth
    <div class="container mx-auto py-6 max-w-2xl">
        <h2 class="text-xl font-semibold mb-3">Postuler à cette offre</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('candidatures.store') }}" method="POST" class="bg-white border rounded p-4 shadow-sm">
            @csrf

            <input type="hidden" name="offre_id" value="{{ $offre->id }}" />

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Message de motivation</label>
                <textarea name="message_motivation" rows="5" class="w-full border rounded px-3 py-2">{{ old('message_motivation') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Envoyer la candidature</button>
            </div>
        </form>
    </div>
    @endauth
</div>
@endsection
