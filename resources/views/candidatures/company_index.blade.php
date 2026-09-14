@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="mb-8">
        <h1 class="page-title">Candidatures reçues</h1>
        <p class="page-subtitle">Examinez les profils des candidats et répondez à leurs candidatures.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info mb-6">{{ session('info') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($candidatures->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="mx-auto inline-flex items-center justify-center h-14 w-14 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Aucune candidature</h3>
            <p class="text-slate-500 mt-1">Vous n'avez pas encore reçu de candidature pour vos offres.</p>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="table-wrap border-0">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Candidat</th>
                            <th>Offre visée</th>
                            <th>Date de dépôt</th>
                            <th>Statut actuel</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidatures as $candidature)
                            <tr>
                                <td class="font-bold text-slate-900">
                                    {{ $candidature->studentProfile?->user?->name ?? 'Candidat inconnu' }}
                                </td>
                                <td class="text-slate-800 font-medium">
                                    {{ $candidature->offre?->titre ?? 'Offre introuvable' }}
                                </td>
                                <td class="text-slate-500 text-xs font-medium">
                                    {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if($candidature->statut === 'acceptee')
                                        <span class="badge badge-success">Acceptée</span>
                                    @elseif($candidature->statut === 'refusee')
                                        <span class="badge badge-danger">Refusée</span>
                                    @else
                                        <span class="badge badge-pending">En attente</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('candidatures.company.show', $candidature->id) }}" class="btn btn-secondary btn-sm">Consulter</a>
                                        
                                        @if($candidature->studentProfile?->cv_path)
                                            <a href="{{ route('candidatures.company.cv', $candidature->id) }}" class="btn btn-secondary btn-sm flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                CV
                                            </a>
                                        @endif

                                        @if($candidature->statut !== 'acceptee')
                                            <form action="{{ route('candidatures.company.accept', $candidature->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Accepter</button>
                                            </form>
                                        @endif

                                        @if($candidature->statut !== 'refusee')
                                            <form action="{{ route('candidatures.company.refuse', $candidature->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($candidatures->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $candidatures->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection