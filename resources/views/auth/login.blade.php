<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Connexion à votre compte</h1>
        <p class="mt-1 text-sm text-slate-600">Accédez à votre espace étudiant, recruteur ou administrateur.</p>
    </div>

    <!-- Status de session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="exemple@domaine.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Mot de passe" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-blue-600 hover:text-blue-800" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Se souvenir de moi -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm font-medium text-slate-600">Se souvenir de moi</span>
            </label>
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-full h-11 text-base">
                Se connecter
            </button>
        </div>

        <div class="mt-6 text-center text-sm text-slate-600">
            Vous n'avez pas encore de compte ?
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800 ml-1">Créer un compte</a>
        </div>
    </form>
</x-guest-layout>
