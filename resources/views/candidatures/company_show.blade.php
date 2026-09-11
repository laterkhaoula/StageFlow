@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-3xl">
    <h1 class="text-2xl font-semibold mb-6">Profil du candidat</h1>

    @if(!$profile)
        <div class="bg-white border rounded p-4 text-gray-600">Profil introuvable.</div>
    @else
        <div class="bg-white border rounded p-6 shadow-sm">
            <div class="mb-4">
                <h2 class="text-xl font-medium">{{ $profile->user->name ?? '—' }}</h2>
                <div class="text-sm text-gray-500">{{ $profile->user->email ?? '—' }}</div>
            </div>

            <div class="grid grid-cols-1 gap-3 text-gray-700">
                <div><strong>Téléphone :</strong> {{ $profile->phone ?? '—' }}</div>
                <div><strong>Adresse :</strong> {{ $profile->address ?? '—' }}</div>
                <div><strong>Domaine de formation :</strong> {{ $profile->training_domain ?? '—' }}</div>
                <div><strong>Compétences :</strong> <div class="mt-1 whitespace-pre-wrap">{{ $profile->skills ?? '—' }}</div></div>
            </div>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ url()->previous() }}" class="text-blue-600">&larr; Retour</a>
    </div>
</div>
@endsection
