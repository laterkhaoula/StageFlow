@extends('layouts.app')

@section('content')
<div class="page-container max-w-4xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="page-title">Informations de l'entreprise</h1>
            <p class="page-subtitle">Gérez les détails publics de votre entreprise présentés aux candidats.</p>
        </div>
        <a href="{{ route('company-profile.edit') }}" class="btn btn-secondary flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Modifier les informations
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 pb-6 border-b border-slate-100 mb-6">Profil recruteur</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Nom de l'entreprise</span>
                <span class="text-lg font-bold text-slate-900">{{ $profile->nom_entreprise ?? 'Non renseigné' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Secteur d'activité</span>
                <span class="text-lg font-bold text-blue-600">{{ $profile->secteur ?? 'Non renseigné' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Contact & Coordonnées</span>
                <span class="text-base text-slate-800 font-medium">{{ $profile->contact ?? 'Non renseigné' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Adresse Email du compte</span>
                <span class="text-base text-slate-800 font-medium">{{ optional($profile->user)->email ?? '—' }}</span>
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-2">Description de l'entreprise</span>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 text-sm whitespace-pre-wrap leading-relaxed">
                    {{ $profile->description ?? 'Aucune description rédigée pour le moment.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection