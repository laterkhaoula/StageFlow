@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="page-title">Mes offres de stage</h1>
            <p class="page-subtitle">Gérez la publication et le statut de vos offres de stage.</p>
        </div>
        <a href="{{ route('offres.company.create') }}" class="btn btn-primary whitespace-nowrap">
            + Publier une offre
        </a>
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

    @if($offres->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="mx-auto inline-flex items-center justify-center h-14 w-14 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Aucune offre publiée</h3>
            <p class="text-slate-500 mt-1">Vous n'avez pas encore créé d'offre de stage pour les étudiants.</p>
            <a href="{{ route('offres.company.create') }}" class="btn btn-primary mt-4">+ Publier votre première offre</a>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="table-wrap border-0">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Titre de l'offre</th>
                            <th>Domaine</th>
                            <th>Localisation</th>
                            <th>Publication</th>
                            <th>Statut</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offres as $offre)
                            <tr>
                                <td class="font-bold text-slate-900">
                                    <a href="{{ route('offres.show', $offre) }}" class="hover:text-blue-600 transition-colors">
                                        {{ $offre->titre }}
                                    </a>
                                </td>
                                <td><span class="badge badge-neutral">{{ $offre->domaine }}</span></td>
                                <td class="text-slate-600">{{ $offre->localisation ?? 'Non spécifiée' }}</td>
                                <td class="text-slate-500 text-xs">{{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</td>
                                <td>
                                    @if($offre->statut === 'ouverte')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('offres.show', $offre) }}" class="btn btn-secondary btn-sm">Voir</a>
                                        <a href="{{ route('offres.company.edit', $offre) }}" class="btn btn-secondary btn-sm">Modifier</a>

                                        <form action="{{ route('offres.company.toggle', $offre) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm {{ $offre->statut === 'ouverte' ? 'btn-secondary text-amber-700 hover:bg-amber-50' : 'btn-success' }}">
                                                {{ $offre->statut === 'ouverte' ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('offres.company.destroy', $offre) }}" method="POST" onsubmit="return confirm('Confirmer la suppression de cette offre ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($offres->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $offres->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection