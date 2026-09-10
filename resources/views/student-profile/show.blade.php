@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-4">Profil étudiant</h1>

    <div class="bg-white border rounded p-6 shadow-sm">
        <div class="mb-4">
            <div class="text-lg font-bold">{{ optional($profile->user)->name ?? '—' }}</div>
            <div class="text-sm text-gray-600">{{ optional($profile->user)->email ?? '—' }}</div>
        </div>

        <div class="grid grid-cols-1 gap-4 text-sm text-gray-700 mb-4">
            <div>
                <div class="font-medium">Téléphone</div>
                <div>{{ $profile->phone ?? '—' }}</div>
            </div>
            <div>
                <div class="font-medium">Adresse</div>
                <div>{{ $profile->address ?? '—' }}</div>
            </div>
            <div>
                <div class="font-medium">Domaine de formation</div>
                <div>{{ $profile->training_domain ?? '—' }}</div>
            </div>
            <div>
                <div class="font-medium">Compétences</div>
                <div>{{ $profile->skills ?? '—' }}</div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="/student-profile/edit" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifier le profil</a>
        </div>
    </div>
</div>
@endsection
