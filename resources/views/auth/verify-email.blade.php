<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-slate-900">Vérification de l'adresse e-mail</h1>
        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
            Merci de vous être inscrit sur StageFlow ! Veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-6">
            Un nouveau lien de vérification a été envoyé à l'adresse e-mail renseignée lors de votre inscription.
        </div>
    @endif

    <div class="space-y-4 pt-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-full h-11 text-base">
                Renvoyer l'e-mail de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
