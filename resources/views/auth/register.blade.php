<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Créer votre compte StageFlow</h1>
        <p class="mt-1 text-sm text-slate-600">Rejoignez la plateforme en tant qu'étudiant ou entreprise.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="name" value="Nom complet ou nom de l'entreprise" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Votre nom" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="exemple@domaine.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Rôle -->
        <div>
            <x-input-label for="role" value="Vous êtes ?" />
            <select id="role" class="form-select mt-1" name="role" required>
                <option value="">Sélectionnez votre profil</option>
                <option value="etudiant" {{ old('role') === 'etudiant' ? 'selected' : '' }}>Étudiant (À la recherche d'un stage)</option>
                <option value="entreprise" {{ old('role') === 'entreprise' ? 'selected' : '' }}>Entreprise / Recruteur (Publication d'offres)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation du mot de passe -->
        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            placeholder="••••••••"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn btn-primary w-full h-11 text-base">
                Créer mon compte
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-slate-600">
            Vous avez déjà un compte ?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 ml-1">Se connecter</a>
        </div>
    </form>
</x-guest-layout>
