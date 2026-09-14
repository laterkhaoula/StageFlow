<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Réinitialisation du mot de passe</h1>
        <p class="mt-2 text-sm text-slate-600 leading-relaxed">Saisissez votre adresse e-mail. Nous vous enverrons un lien de réinitialisation pour créer un nouveau mot de passe.</p>
    </div>

    <!-- Status de session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="exemple@domaine.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-full h-11 text-base">
                Envoyer le lien de réinitialisation
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-slate-600">
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800">&larr; Retour à la connexion</a>
        </div>
    </form>
</x-guest-layout>
