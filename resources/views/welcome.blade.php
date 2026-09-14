<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'StageFlow') }} — Ton avenir commence avec le bon stage</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
    </head>
    <body class="font-sans antialiased bg-white text-slate-900">
        <div x-data="{ mobileMenuOpen: false }" class="min-h-screen flex flex-col bg-white">

            <!-- ================= HEADER / NAVBAR HORIZONTALE ================= -->
            <header class="sticky top-0 z-40 bg-white border-b border-slate-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                    <!-- Logo StageFlow (CV / Résumé) -->
                    <a href="/" class="flex items-center gap-2.5 shrink-0">
                        <span class="relative flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#2563EB]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-5-5z" />
                                <path d="M14 2v5h5" />
                                <path d="M9 13h6" />
                                <path d="M9 17h4" />
                            </svg>
                            <span class="absolute -bottom-0.5 -right-0.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-[#2563EB] text-white">
                                <svg class="h-2 w-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        </span>
                        <span class="text-xl font-bold tracking-tight text-slate-900">StageFlow</span>
                    </a>

                    <!-- Navigation (Desktop / Tablet) -->
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="/" class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-50 transition-colors">Accueil</a>
                        <a href="#comment-ca-marche" class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-50 transition-colors">Comment ça marche ?</a>
                    </nav>

                    <!-- Actions à droite (Desktop / Tablet) -->
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="inline-flex items-center justify-center bg-[#2563EB] text-white px-5 py-2.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center text-slate-700 hover:text-slate-900 font-semibold text-sm px-3 py-2.5 transition-colors">
                                Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[#2563EB] text-white px-5 py-2.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                S'inscrire
                            </a>
                        @endauth
                    </div>

                    <!-- Hamburger (Mobile) -->
                    <button type="button" @click="mobileMenuOpen = ! mobileMenuOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-label="Ouvrir le menu">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': mobileMenuOpen, 'inline-flex': ! mobileMenuOpen}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! mobileMenuOpen, 'inline-flex': mobileMenuOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Menu mobile -->
                <div :class="{'block': mobileMenuOpen, 'hidden': ! mobileMenuOpen}" class="hidden md:hidden border-t border-slate-100 bg-white">
                    <div class="pt-2 pb-2 space-y-1 px-3">
                        <a href="/" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Accueil</a>
                        <a href="#comment-ca-marche" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Comment ça marche ?</a>
                    </div>
                    <div class="pt-3 pb-4 px-3 border-t border-slate-100 flex flex-col gap-2">
                        @auth
                            <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="inline-flex items-center justify-center bg-[#2563EB] text-white px-4 py-2.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center text-slate-700 font-semibold text-sm px-3 py-2 transition-colors">
                                Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[#2563EB] text-white px-4 py-2.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                S'inscrire
                            </a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- ================= CONTENU PRINCIPAL ================= -->
            <main class="flex-1 flex flex-col min-w-0 bg-white">

                <!-- HERO SECTION (Split 50/50) -->
                <section class="px-6 sm:px-10 lg:px-12 pt-2 pb-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                        
                        <!-- COLONNE GAUCHE (50%) -->
                        <div class="flex flex-col justify-center">
                            <h1 class="text-4xl sm:text-5xl lg:text-[52px] font-bold text-slate-900 leading-[1.12] tracking-tight">
                                Ton avenir<br>
                                commence avec<br>
                                <span class="text-[#2563EB] font-bold">le bon stage</span>
                            </h1>

                            <p class="mt-6 text-slate-600 text-sm sm:text-base leading-relaxed max-w-lg">
                                StageFlow connecte les étudiants aux meilleures entreprises pour trouver des stages, développer leurs compétences et construire leur avenir professionnel.
                            </p>

                            <!-- Petites fonctionnalités avec icônes -->
                            <div class="mt-8 flex flex-wrap items-center gap-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-[#2563EB] flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-700 leading-snug">Offres de stage<br>vérifiées</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-[#2563EB] flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-700 leading-snug">Entreprises<br>de confiance</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-[#2563EB] flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-700 leading-snug">Accompagnement<br>dans ta recherche</span>
                                </div>
                            </div>

                            <!-- Boutons d'action principaux -->
                            <div class="mt-9 flex flex-wrap items-center gap-4">
                                @auth
                                <a href="{{ route('offres.index') }}" class="inline-flex items-center justify-center gap-2.5 bg-[#2563EB] text-white px-7 py-3.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition-all shadow-md shadow-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Explorer les offres
                                </a>
                                @endauth

                                <a href="{{ auth()->guest() ? route('register') : (auth()->user()->isEtudiant() ? route('student-profile.show') : route(auth()->user()->dashboardRoute())) }}" class="inline-flex items-center justify-center gap-2.5 bg-white border border-slate-200 text-slate-700 px-7 py-3.5 rounded-full font-semibold text-sm hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4 text-[#2563EB]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Déposer mon CV
                                </a>
                            </div>
                        </div>

                        <!-- COLONNE DROITE (Image students-work.jpg 50%) -->
                        <div class="w-full h-80 sm:h-[450px] lg:h-[530px] relative overflow-hidden rounded-3xl shadow-sm">
                            <img src="{{ asset('images/students-work.jpg') }}" class="w-full h-full object-cover rounded-3xl" alt="Hero Image">
                        </div>

                    </div>

                    <!-- CARD FLOTTANTE "MON CV" (Overlay en bas de la Hero) -->
                    <div class="relative z-10 -mt-14 lg:-mt-16">
                        <div class="max-w-2xl mx-auto lg:mx-0 lg:ml-12 bg-white rounded-2xl shadow-xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#2563EB] flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-sm sm:text-base">Mon CV</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">Télécharge ton CV et augmente tes chances d'être contacté par les entreprises.</p>
                                </div>
                            </div>

                            <a href="{{ auth()->guest() ? route('register') : (auth()->user()->isEtudiant() ? route('student-profile.show') : route(auth()->user()->dashboardRoute())) }}" class="shrink-0 inline-flex items-center gap-2 bg-[#2563EB] text-white px-5 py-2.5 rounded-full font-semibold text-xs sm:text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Déposer mon CV
                            </a>
                        </div>
                    </div>
                </section>

                <!-- SECTION COMMENT ÇA MARCHE -->
                <section id="comment-ca-marche" class="px-6 sm:px-10 lg:px-12 my-8">
                    <div class="rounded-3xl bg-slate-50/50 p-6 sm:p-8">
                        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900">Comment ça marche ?</h2>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">Trouvez le stage idéal en trois étapes simples, de la création du profil au suivi de vos candidatures.</p>

                        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#2563EB] flex items-center justify-center font-extrabold text-lg">1</div>
                                <h3 class="mt-4 font-bold text-slate-900">Créer son profil</h3>
                                <p class="mt-1 text-sm text-slate-600 leading-relaxed">Inscrivez-vous et complétez votre profil : compétences, formation et CV.</p>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#2563EB] flex items-center justify-center font-extrabold text-lg">2</div>
                                <h3 class="mt-4 font-bold text-slate-900">Rechercher une offre et postuler</h3>
                                <p class="mt-1 text-sm text-slate-600 leading-relaxed">Parcourez les offres de stage actives et déposez votre candidature en quelques clics.</p>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#2563EB] flex items-center justify-center font-extrabold text-lg">3</div>
                                <h3 class="mt-4 font-bold text-slate-900">Suivre ses candidatures</h3>
                                <p class="mt-1 text-sm text-slate-600 leading-relaxed">Suivez l'évolution de vos candidatures et recevez les réponses des entreprises.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- SECTION STATISTIQUES EN BAS (Stats Bar) -->
                <section class="px-6 sm:px-10 lg:px-12 my-8">
                    <div class="rounded-3xl bg-slate-50/50 p-6 sm:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                            
                            <!-- Stat 1 -->
                            <div class="flex items-center gap-4 md:px-6">
                                <div class="w-12 h-12 rounded-xl bg-blue-100/60 text-[#2563EB] flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-extrabold text-slate-900 tracking-tight">500+</div>
                                    <div class="text-xs text-slate-500 font-medium">Entreprises partenaires</div>
                                </div>
                            </div>

                            <!-- Stat 2 -->
                            <div class="flex items-center gap-4 md:px-6 pt-4 md:pt-0">
                                <div class="w-12 h-12 rounded-xl bg-blue-100/60 text-[#2563EB] flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 1321 13.255A2.36 2.36 0 0119 13.06V7a2 2 0 00-2-2H7a2 2 0 00-2 2v6.06A2.36 2.36 0 013 13.255V19a2 2 0 002 2h14a2 2 0 002-2v-5.745zM12 12a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-extrabold text-slate-900 tracking-tight">1000+</div>
                                    <div class="text-xs text-slate-500 font-medium">Offres de stage disponibles</div>
                                </div>
                            </div>

                            <!-- Stat 3 -->
                            <div class="flex items-center gap-4 md:px-6 pt-4 md:pt-0">
                                <div class="w-12 h-12 rounded-xl bg-blue-100/60 text-[#2563EB] flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-extrabold text-slate-900 tracking-tight">10 000+</div>
                                    <div class="text-xs text-slate-500 font-medium">Étudiants inscrits</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </main>
        </div>
    </body>
</html>