@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-4">Modifier le profil entreprise</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('company-profile.update') }}" method="POST" class="space-y-4 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nom de l'entreprise</label>
            <input type="text" name="nom_entreprise" value="{{ old('nom_entreprise', $profile->nom_entreprise) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Secteur</label>
            <input type="text" name="secteur" value="{{ old('secteur', $profile->secteur) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Contact</label>
            <input type="text" name="contact" value="{{ old('contact', $profile->contact) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
            <a href="{{ route('company-profile.show') }}" class="text-sm text-gray-600">Retour</a>
        </div>
    </form>
</div>
@endsection
