<x-app-layout>
    <div class="page-container">
        <div class="mb-8">
            <h1 class="page-title">Gestion des utilisateurs</h1>
            <p class="page-subtitle">Consulter et superviser l'ensemble des comptes de la plateforme.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($users->isEmpty())
                <div class="p-12 text-center text-slate-600">Aucun utilisateur enregistré pour le moment.</div>
            @else
                <div class="table-wrap border-0">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nom complet</th>
                                <th>Adresse email</th>
                                <th>Rôle attribué</th>
                                <th class="text-right">Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="font-bold text-slate-900">{{ $user->name }}</td>
                                    <td class="text-slate-600 font-medium">{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $roleName = $user->roles->first()?->name ?? ($user->role ?? 'etudiant');
                                        @endphp
                                        <span class="badge {{ $roleName === 'administrateur' ? 'badge-danger' : ($roleName === 'entreprise' ? 'badge-success' : 'badge-neutral') }}">
                                            {{ ucfirst($roleName) }}
                                        </span>
                                    </td>
                                    <td class="text-right text-xs text-slate-500 font-medium whitespace-nowrap">
                                        {{ $user->created_at ? $user->created_at->format('d/m/Y à H:i') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if($users->hasPages())
                <div class="p-4 border-t border-slate-100 flex justify-center">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>