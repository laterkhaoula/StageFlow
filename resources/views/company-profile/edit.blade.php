@extends('layouts.app')

@section('content')
<div class="page-container max-w-3xl">
    <div class="mb-8">
        <h1 class="page-title">Modifier le profil entreprise</h1>
        <p class="page-subtitle">Renseignez le nom, secteur d'activité, contact et description de votre entreprise.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('company-profile.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="form-label" for="nom_entreprise">Nom de l'entreprise</label>
                <input type="text" id="nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise', $profile->nom_entreprise) }}" placeholder="Nom officiel..." class="form-input" />
            </div>

            <div>
                <label class="form-label" for="secteur">Secteur d'activité</label>
                <input type="text" id="secteur" name="secteur" value="{{ old('secteur', $profile->secteur) }}" placeholder="ex: Informatique, Banque, BTP..." class="form-input" />
            </div>
        </div>

        <div>
            <label class="form-label" for="contact">Contact & Coordonnées</label>
            <input type="text" id="contact" name="contact" value="{{ old('contact', $profile->contact) }}" placeholder="Téléphone, email de contact, site web..." class="form-input" />
        </div>

        <div>
            <label class="form-label" for="description">Description de l'entreprise</label>
            <textarea id="description" name="description" rows="5" class="form-textarea" placeholder="Présentez les activités de votre entreprise, vos valeurs et votre environnement de travail...">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="btn btn-primary">
                Enregistrer les modifications
            </button>
            <a href="{{ route('company-profile.show') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection