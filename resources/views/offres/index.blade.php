@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-semibold mb-4">Offres</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    @if($offres->isEmpty())
        <p>Aucune offre trouvée.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Titre</th>
                        <th class="px-4 py-2 border">Domaine</th>
                        <th class="px-4 py-2 border">Localisation</th>
                        <th class="px-4 py-2 border">Date publication</th>
                        <th class="px-4 py-2 border">Statut</th>
                        <th class="px-4 py-2 border">Entreprise</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offres as $offre)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $offre->titre }}</td>
                            <td class="px-4 py-2 border">{{ $offre->domaine }}</td>
                            <td class="px-4 py-2 border">{{ $offre->localisation }}</td>
                            <td class="px-4 py-2 border">{{ $offre->date_publication }}</td>
                            <td class="px-4 py-2 border">{{ $offre->statut }}</td>
                            <td class="px-4 py-2 border">
                                {{ optional($offre->companyProfile)->name ?? optional($offre->companyProfile)->nom ?? '—' }}
                            </td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('offres.show', $offre) }}" class="inline-block px-2 py-1 text-sm text-blue-600">Voir</a>
                                <a href="{{ route('offres.edit', $offre) }}" class="inline-block px-2 py-1 text-sm text-yellow-600">Modifier</a>

                                <form action="{{ route('offres.destroy', $offre) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-sm text-red-600">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
