@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-4">Profil entreprise</h1>

    <div class="bg-white border rounded p-6 shadow-sm">
        <div class="mb-4">
            <div class="font-medium text-sm text-gray-500">Nom de l'entreprise</div>
            <div class="text-gray-800">{{ $profile->nom_entreprise ?? '—' }}</div>
        </div>

        <div class="mb-4">
            <div class="font-medium text-sm text-gray-500">Secteur</div>
            <div class="text-gray-800">{{ $profile->secteur ?? '—' }}</div>
        </div>

        <div class="mb-4">
            <div class="font-medium text-sm text-gray-500">Contact</div>
            <div class="text-gray-800">{{ $profile->contact ?? '—' }}</div>
        </div>

        <div class="mb-4">
            <div class="font-medium text-sm text-gray-500">Description</div>
            <div class="text-gray-800 whitespace-pre-wrap">{{ $profile->description ?? '—' }}</div>
        </div>

        <div class="mb-6">
            <div class="font-medium text-sm text-gray-500">Email</div>
            <div class="text-gray-800">{{ optional($profile->user)->email ?? '—' }}</div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('company-profile.edit') ?? url('/company-profile/edit') }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifier</a>
        </div>
    </div>
</div>
@endsection
