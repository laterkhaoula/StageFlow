@extends('layouts.app')

@section('content')
<div class="page-container max-w-4xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="page-title">Mon profil étudiant</h1>
            <p class="page-subtitle">Ces informations et votre CV sont présentés aux recruteurs lors de vos candidatures.</p>
        </div>
        <a href="{{ route('student-profile.edit') }}" class="btn btn-secondary flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Modifier mes informations
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    <!-- Zone Mon CV -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm mb-8">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900">Mon CV</h2>
            </div>
            @if(!empty($profile->cv_path))
                <span class="badge badge-success">CV à jour</span>
            @else
                <span class="badge badge-pending">Aucun CV joint</span>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            @if(!empty($profile->cv_path))
                <p class="text-sm text-slate-600">Un CV est actuellement enregistré sur votre profil et sera joint à vos candidatures.</p>
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('student-profile.cv') }}" target="_blank" rel="noopener" class="btn btn-primary flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Télécharger le CV
                    </a>
                    <a href="{{ route('student-profile.edit') }}" class="btn btn-secondary">
                        Modifier le CV
                    </a>
                </div>
            @else
                <p class="text-sm text-slate-600">Vous n'avez pas encore ajouté de CV. Un CV professionnel augmente considérablement vos chances de recrutement.</p>
                <a href="{{ route('student-profile.edit') }}" class="btn btn-primary whitespace-nowrap">
                    + Ajouter mon CV
                </a>
            @endif
        </div>
    </div>

    <!-- Informations Personnelles -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 pb-6 border-b border-slate-100 mb-6">Informations personnelles & formation</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Nom complet</span>
                <span class="text-base font-bold text-slate-900">{{ $profile->user->name ?? '—' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Adresse Email</span>
                <span class="text-base font-bold text-slate-900">{{ $profile->user->email ?? '—' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Numéro de téléphone</span>
                <span class="text-base text-slate-800 font-medium">{{ $profile->phone ?? 'Non renseigné' }}</span>
            </div>

            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Adresse postale</span>
                <span class="text-base text-slate-800 font-medium">{{ $profile->address ?? 'Non renseignée' }}</span>
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-1">Domaine de formation</span>
                <span class="text-base text-slate-900 font-bold">{{ $profile->training_domain ?? 'Non renseigné' }}</span>
            </div>

            <div class="sm:col-span-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 block mb-2">Compétences & savoir-faire</span>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-slate-800 text-sm whitespace-pre-wrap leading-relaxed">
                    {{ $profile->skills ?? 'Aucune compétence renseignée pour le moment.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection