@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-4">Modifier le profil étudiant</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="student-profile-form" action="{{ url('/student-profile') }}" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Adresse</label>
            <input type="text" name="address" value="{{ old('address', $profile->address) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Domaine de formation</label>
            <input type="text" name="training_domain" value="{{ old('training_domain', $profile->training_domain) }}" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Compétences</label>
            <textarea name="skills" rows="3" class="w-full border rounded px-3 py-2">{{ old('skills', $profile->skills) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">CV (PDF seulement)</label>
            <input type="file" name="cv" form="student-profile-form" accept="application/pdf" class="w-full" />
            @if($profile->cv_path)
                <div class="text-sm text-gray-600 mt-1">CV actuel : {{ $profile->cv_path }}</div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Enregistrer</button>
            <a href="{{ route('student-profile.show') ?? url('/student-profile') }}" class="text-sm text-gray-600">Retour</a>
        </div>
    </form>
</div>
@endsection
