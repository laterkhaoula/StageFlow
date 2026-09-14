@extends('layouts.app')

@section('content')
<div class="page-container max-w-3xl">
    <div class="mb-8">
        <h1 class="page-title">Modifier mon profil étudiant</h1>
        <p class="page-subtitle">Mettez à jour vos coordonnées, votre domaine de formation, vos compétences et votre CV.</p>
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

    <form method="POST" action="{{ route('student-profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="form-label">Numéro de téléphone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $profile->phone) }}" placeholder="+212 600-000000" class="form-input" />
            </div>

            <div>
                <label for="address" class="form-label">Adresse postale</label>
                <input id="address" type="text" name="address" value="{{ old('address', $profile->address) }}" placeholder="Ville, Pays" class="form-input" />
            </div>
        </div>

        <div>
            <label for="training_domain" class="form-label">Domaine de formation</label>
            <input id="training_domain" type="text" name="training_domain" value="{{ old('training_domain', $profile->training_domain) }}" placeholder="ex: Génie Informatique, Marketing Digital, Finance..." class="form-input" />
        </div>

        <div>
            <label for="skills" class="form-label">Compétences principales</label>
            <textarea id="skills" name="skills" rows="4" class="form-textarea" placeholder="Listez vos compétences clés, langages de programmation, outils maîtrisés...">{{ old('skills', $profile->skills) }}</textarea>
        </div>

        <!-- Section Fichier CV -->
        <div class="pt-4 border-t border-slate-100">
            <label for="cv" class="form-label">Document CV (Format PDF uniquement)</label>
            <input id="cv" type="file" name="cv" accept="application/pdf" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-200 rounded-xl p-2" />
            @error('cv')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
            @if($profile->cv_path)
                <p class="mt-2 text-xs text-slate-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Un CV est déjà enregistré. Choisir un nouveau fichier le remplacera.
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('student-profile.show') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection