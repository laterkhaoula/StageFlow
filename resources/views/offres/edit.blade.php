@extends('layouts.app')

@section('content')
<div class="page-container max-w-3xl">
    <div class="mb-8">
        <h1 class="page-title">Modifier l'offre de stage</h1>
        <p class="page-subtitle">Mettez à jour les informations de votre offre de stage.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error mb-6">
            <p class="font-bold">Veuillez corriger les erreurs ci-dessous :</p>
            <ul class="list-disc pl-5 mt-1 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offres.company.update', $offre) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="form-label" for="titre">Titre du poste ou de l'offre</label>
            <input type="text" id="titre" name="titre" value="{{ old('titre', $offre->titre) }}" class="form-input" />
            @if($errors->has('titre'))
                <p class="text-red-600 text-xs mt-1 font-medium">{{ $errors->first('titre') }}</p>
            @endif
        </div>

        <div>
            <label class="form-label" for="description">Description détaillée du stage</label>
            <textarea id="description" name="description" rows="6" class="form-textarea">{{ old('description', $offre->description) }}</textarea>
            @if($errors->has('description'))
                <p class="text-red-600 text-xs mt-1 font-medium">{{ $errors->first('description') }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="form-label" for="domaine">Domaine d'activité</label>
                <input type="text" id="domaine" name="domaine" value="{{ old('domaine', $offre->domaine) }}" class="form-input" />
                @if($errors->has('domaine'))
                    <p class="text-red-600 text-xs mt-1 font-medium">{{ $errors->first('domaine') }}</p>
                @endif
            </div>

            <div>
                <label class="form-label" for="localisation">Localisation</label>
                <input type="text" id="localisation" name="localisation" value="{{ old('localisation', $offre->localisation) }}" class="form-input" />
                @if($errors->has('localisation'))
                    <p class="text-red-600 text-xs mt-1 font-medium">{{ $errors->first('localisation') }}</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="form-label" for="date_publication">Date de publication</label>
                <input type="date" id="date_publication" name="date_publication" value="{{ old('date_publication', $offre->date_publication) }}" class="form-input" />
                @if($errors->has('date_publication'))
                    <p class="text-red-600 text-xs mt-1 font-medium">{{ $errors->first('date_publication') }}</p>
                @endif
            </div>

            <div>
                <label class="form-label" for="statut">Statut de l'offre</label>
                <select id="statut" name="statut" class="form-select">
                    <option value="ouverte" {{ old('statut', $offre->statut) === 'ouverte' ? 'selected' : '' }}>Offre active (ouverte)</option>
                    <option value="fermee" {{ old('statut', $offre->statut) === 'fermee' ? 'selected' : '' }}>Offre inactive (masquée)</option>
                </select>
                @if($errors->has('statut'))
                    <p class="text-red-600 text-xs mt-1 font-medium">{{ $errors->first('statut') }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="btn btn-primary">
                Enregistrer les modifications
            </button>
            <a href="{{ route('offres.company.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection