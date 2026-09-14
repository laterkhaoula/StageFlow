<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Nouveau mot de passe</h1>
        <p class="mt-1 text-sm text-slate-600">Choisissez votre nouveau mot de passe pour sécuriser votre compte StageFlow.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Nouveau mot de passe -->
        <div>
            <x-input-label for="password" value="Nouveau mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation -->
        <div>
            <x-input-label for="password_confirmation" value="Confirmer le nouveau mot de passe" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn btn-primary w-full h-11 text-base">
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>
</x-guest-layout>
