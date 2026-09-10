@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-4">Modifier l'offre</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offres.update', $offre) }}" method="POST" class="space-y-4 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Titre</label>
            <input type="text" name="titre" value="{{ old('titre', $offre->titre) }}" class="w-full border rounded px-3 py-2" />
            @if($errors->has('titre'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('titre') }}</div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $offre->description) }}</textarea>
            @if($errors->has('description'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Domaine</label>
            <input type="text" name="domaine" value="{{ old('domaine', $offre->domaine) }}" class="w-full border rounded px-3 py-2" />
            @if($errors->has('domaine'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('domaine') }}</div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Localisation</label>
            <input type="text" name="localisation" value="{{ old('localisation', $offre->localisation) }}" class="w-full border rounded px-3 py-2" />
            @if($errors->has('localisation'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('localisation') }}</div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Date de publication</label>
            <input type="date" name="date_publication" value="{{ old('date_publication', $offre->date_publication) }}" class="w-full border rounded px-3 py-2" />
            @if($errors->has('date_publication'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('date_publication') }}</div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Statut</label>
            <input type="text" name="statut" value="{{ old('statut', $offre->statut) }}" class="w-full border rounded px-3 py-2" />
            @if($errors->has('statut'))
                <div class="text-red-600 text-sm mt-1">{{ $errors->first('statut') }}</div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
            <a href="{{ route('offres.index') }}" class="text-sm text-gray-600">Retour aux offres</a>
        </div>
    </form>
</div>
@endsection
