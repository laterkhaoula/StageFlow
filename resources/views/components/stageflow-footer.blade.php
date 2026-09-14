@php
    $user = auth()->user();
    $dashboard = $user ? route($user->dashboardRoute()) : route('login');
@endphp

<footer class="bg-slate-900 text-slate-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Marque -->
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#2563EB] text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-5-5z" />
                            <path d="M14 2v5h5" />
                            <path d="M9 13h6" />
                            <path d="M9 17h4" />
                        </svg>
                    </span>
                    <span class="text-xl font-bold tracking-tight text-white">StageFlow</span>
                </a>
                <p class="mt-4 text-sm leading-relaxed text-slate-400">
                    La plateforme qui connecte les étudiants aux meilleures entreprises pour trouver un stage qui construit leur carrière.
                </p>

                <!-- Réseaux sociaux -->
                <div class="mt-5 flex items-center gap-3">
                    <a href="#" aria-label="Facebook" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-300 hover:bg-[#2563EB] hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-300 hover:bg-[#2563EB] hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" aria-label="LinkedIn" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-300 hover:bg-[#2563EB] hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5C4.98 4.881 3.87 6 2.5 6S0 4.881 0 3.5C0 2.12 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.24 9h4.52v14.5H.24V9zm7.4 0h4.33v1.98h.06c.6-1.14 2.07-2.34 4.27-2.34 4.56 0 5.4 3 5.4 6.91V23.5h-4.51v-6.79c0-1.62-.03-3.7-2.26-3.7-2.26 0-2.6 1.76-2.6 3.58v6.91H7.64V9z"/></svg>
                    </a>
                    <a href="#" aria-label="X / Twitter" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-300 hover:bg-[#2563EB] hover:text-white transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>

            <!-- À propos -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">À propos</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-[#F59E0B] transition-colors">StageFlow</a></li>
                    <li><a href="{{ url('/#comment-ca-marche') }}" class="hover:text-[#F59E0B] transition-colors">Comment ça marche</a></li>
                    <li><a href="{{ url('/#tarifs') }}" class="hover:text-[#F59E0B] transition-colors">Nos tarifs</a></li>
                    <li><a href="{{ route('offres.index') }}" class="hover:text-[#F59E0B] transition-colors">Offres de stage</a></li>
                    <li><a href="{{ route('notifications.index') }}" class="hover:text-[#F59E0B] transition-colors">Support & Alertes</a></li>
                </ul>
            </div>

            <!-- Stagiaire -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Stagiaire</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    @auth
                        <li><a href="{{ $dashboard }}" class="hover:text-[#F59E0B] transition-colors">Mon espace</a></li>
                    @else
                        <li><a href="{{ route('register') }}" class="hover:text-[#F59E0B] transition-colors">Créer un compte</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#F59E0B] transition-colors">Se connecter</a></li>
                    @endauth
                    <li><a href="{{ route('offres.index') }}" class="hover:text-[#F59E0B] transition-colors">Rechercher un stage</a></li>
                    <li><a href="{{ route('candidatures.index') }}" class="hover:text-[#F59E0B] transition-colors">Mes candidatures</a></li>
                    <li><a href="{{ route('student-profile.show') }}" class="hover:text-[#F59E0B] transition-colors">Déposer mon CV</a></li>
                </ul>
            </div>

            <!-- Recruteur -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-white">Recruteur</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('offres.company.create') }}" class="hover:text-[#F59E0B] transition-colors">Publier une offre</a></li>
                    <li><a href="{{ route('offres.company.index') }}" class="hover:text-[#F59E0B] transition-colors">Mes offres de stage</a></li>
                    <li><a href="{{ route('candidatures.company.index') }}" class="hover:text-[#F59E0B] transition-colors">Candidatures reçues</a></li>
                    <li><a href="{{ route('company-profile.show') }}" class="hover:text-[#F59E0B] transition-colors">Profil entreprise</a></li>
                </ul>
            </div>
        </div>

        <!-- Contact / Barre basse -->
        <div class="mt-12 pt-8 border-t border-white/10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#22C55E]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </span>
                    <a href="tel:+212600000000" class="text-sm font-semibold text-white hover:text-[#F59E0B] transition-colors">06 00 00 00 00</a>
                </div>

                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#22C55E]/15 text-[#22C55E]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </span>
                    <a href="https://wa.me/212600000000" target="_blank" rel="noopener" class="text-sm font-semibold text-white hover:text-[#F59E0B] transition-colors">WhatsApp</a>
                </div>

                <div class="text-sm text-slate-400 md:text-right">
                    <a href="mailto:contact@stageflow.ma" class="text-white font-semibold hover:text-[#F59E0B] transition-colors">contact@stageflow.ma</a>
                    <p class="mt-1">Casablanca, Maroc</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} StageFlow. Tous droits réservés.</p>
                <p>StageFlow — Trouve ton stage et lance ta carrière.</p>
            </div>
        </div>
    </div>
</footer>