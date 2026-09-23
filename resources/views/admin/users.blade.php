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
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="font-bold text-slate-900">
                                        {{ $user->name }}
                                        @if(! $user->is_active)
                                            <span class="badge badge-danger ml-2">Bloqué</span>
                                        @endif
                                    </td>
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
                                    <td class="text-center whitespace-nowrap">
                                        @if($user->id !== auth()->id())
                                            <div class="flex items-center justify-center gap-2">
                                                @if($user->is_active)
                                                    <form method="POST" action="{{ route('admin.users.toggle-block', $user) }}" class="inline-flex" onsubmit="return confirm('Bloquer le compte « {{ $user->name }} » ({{ $user->email }}) ? Il ne pourra plus se connecter.')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm bg-amber-500 text-white hover:bg-amber-600 focus:ring-amber-400">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8m-8 0a2 2 0 01-2-2V6a6 6 0 1112 0v2a2 2 0 01-2 2m-8 0V8h8v2M6 10v10a2 2 0 002 2h8a2 2 0 002-2V10" />
                                                            </svg>
                                                            Bloquer
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('admin.users.toggle-block', $user) }}" class="inline-flex" onsubmit="return confirm('Débloquer le compte « {{ $user->name }} » ({{ $user->email }}) ?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm bg-[#22C55E] text-white hover:bg-emerald-600 focus:ring-emerald-400">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4-1v2m-6 2h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2z" />
                                                            </svg>
                                                            Débloquer
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-flex" onsubmit="return confirm('Supprimer définitivement le compte « {{ $user->name }} » ({{ $user->email }}) ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="badge badge-neutral">Vous</span>
                                        @endif
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