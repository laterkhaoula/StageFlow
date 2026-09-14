<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Confirmation de sécurité</h1>
        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
            Zone sécurisée de l'application. Veuillez confirmer votre mot de passe pour continuer.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Mot de passe" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn btn-primary w-full h-11 text-base">
                Confirmer le mot de passe
            </button>
        </div>
    </form>
</x-guest-layout>
