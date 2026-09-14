<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'StageFlow') }} — Trouve ton stage et lance ta carrière</title>

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
    @php
        $user = auth()->user();
        $dbReady = false;
        try {
            $dbReady = \Illuminate\Support\Facades\Schema::hasTable('offres')
                && \Illuminate\Support\Facades\Schema::hasTable('company_profiles');
        } catch (\Throwable $e) {
            $dbReady = false;
        }

        $featuredOffres = collect();
        $domainList = collect();
        $statOffres = null;
        $statEntreprises = null;
        $statEtudiants = null;

        if ($dbReady) {
            try {
                $featuredOffres = \App\Models\Offre::with('companyProfile:id,nom_entreprise')
                    ->where('statut', 'ouverte')
                    ->orderByDesc('date_publication')
                    ->take(6)
                    ->get();
            } catch (\Throwable $e) { $featuredOffres = collect(); }

            try {
                $domainList = \App\Models\Offre::where('statut', 'ouverte')
                    ->select('domaine')->distinct()->orderBy('domaine')->pluck('domaine')->take(12);
            } catch (\Throwable $e) { $domainList = collect(); }

            try { $statOffres = \App\Models\Offre::where('statut', 'ouverte')->count(); } catch (\Throwable $e) { $statOffres = null; }
            try { $statEntreprises = \App\Models\CompanyProfile::count(); } catch (\Throwable $e) { $statEntreprises = null; }
            try { $statEtudiants = \App\Models\StudentProfile::count(); } catch (\Throwable $e) { $statEtudiants = null; }
        }
    @endphp
    <body class="font-sans antialiased bg-white text-slate-900">
        <div x-data="{ mobileMenuOpen: false }" class="min-h-screen flex flex-col bg-white">

            <!-- ================= TOPBAR (style Stage.ma) ================= -->
            <div class="bg-slate-900 text-slate-200 text-xs">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-end">
                    <div class="flex items-center gap-4 font-semibold">
                        @auth
                            <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="text-[#F59E0B] hover:text-white transition-colors">Mon espace</a>
                        @else
                            <a href="{{ route('register') }}" class="text-[#F59E0B] hover:text-white transition-colors">Espace recruteur</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- ================= HEADER / NAVBAR ================= -->
            <header class="sticky top-0 z-40 bg-white border-b border-slate-100 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2.5 shrink-0">
                        <span class="relative flex h-9 w-9 items-center justify-center rounded-xl bg-[#2563EB] text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-5-5z" />
                                <path d="M14 2v5h5" />
                                <path d="M9 13h6" />
                                <path d="M9 17h4" />
                            </svg>
                            <span class="absolute -bottom-0.5 -right-0.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-[#F59E0B]">
                                <svg class="h-2 w-2 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        </span>
                        <span class="text-xl font-bold tracking-tight text-slate-900">StageFlow</span>
                    </a>

                    <!-- Navigation (Desktop / Tablet) -->
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="/" class="px-4 py-2 rounded-full text-sm font-semibold text-slate-700 hover:text-[#2563EB] hover:bg-blue-50 transition-colors">Accueil</a>
                        <a href="{{ route('offres.index') }}" class="px-4 py-2 rounded-full text-sm font-semibold text-slate-700 hover:text-[#2563EB] hover:bg-blue-50 transition-colors">Offres de stage</a>
                        <a href="#comment-ca-marche" class="px-4 py-2 rounded-full text-sm font-semibold text-slate-700 hover:text-[#2563EB] hover:bg-blue-50 transition-colors">Comment ça marche ?</a>
                        <a href="#tarifs" class="px-4 py-2 rounded-full text-sm font-semibold text-slate-700 hover:text-[#2563EB] hover:bg-blue-50 transition-colors">Nos tarifs</a>
                    </nav>

                    <!-- Actions à droite (Desktop / Tablet) -->
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <div class="flex items-center gap-3">
                                <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="inline-flex items-center justify-center bg-[#2563EB] text-white px-5 py-2.5 rounded-full font-semibold text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                    Dashboard
                                </a>
                                <span class="hidden lg:flex items-center gap-2 pl-3 border-l border-slate-200">
                                    <span class="flex items-center justify-center h-8 w-8 rounded-full bg-[#2563EB] text-xs font-bold text-white">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</span>
                                </span>
                            </div>
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
                        <a href="{{ route('offres.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Offres de stage</a>
                        <a href="#comment-ca-marche" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Comment ça marche ?</a>
                        <a href="#tarifs" class="block px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Nos tarifs</a>
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

                <!-- HERO (style Stage.ma : fond sombre, gros titre, recherche) -->
                <section class="relative bg-slate-900 overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="{{ asset('images/students-work.jpg') }}" alt="" class="w-full h-full object-cover opacity-20" />
                        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/85 to-slate-900"></div>
                    </div>

                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 lg:pt-24 pb-32 sm:pb-36">
                        <div class="mx-auto max-w-4xl text-center">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#F59E0B]">
                                <span class="inline-block h-1.5 w-1.5 rounded-full bg-[#F59E0B]"></span>
                                Plateforme de stages &amp; carrière
                            </span>

                            <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.08]">
                                TROUVE TON STAGE
                                <span class="block mt-2 text-[#F59E0B]">ET LANCE TA CARRIÈRE</span>
                            </h1>

                            <p class="mt-6 max-w-2xl mx-auto text-slate-300 text-base sm:text-lg leading-relaxed">
                                Rejoins les étudiants et les entreprises qui préparent l'avenir.
                                Dépose ton CV, explore des centaines d'offres de stage et pilote ta carrière depuis un seul endroit.
                            </p>

                            <!-- Boutons d'action -->
                            <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
                                <a href="{{ route('offres.index') }}" class="inline-flex items-center justify-center gap-2.5 bg-[#2563EB] text-white px-8 py-4 rounded-full font-bold text-sm sm:text-base hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/25">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Explorer les offres
                                </a>

                                <a href="{{ auth()->guest() ? route('register') : (auth()->user()->isEtudiant() ? route('student-profile.show') : route(auth()->user()->dashboardRoute())) }}" class="inline-flex items-center justify-center gap-2.5 bg-[#F59E0B] text-slate-900 px-8 py-4 rounded-full font-bold text-sm sm:text-base hover:bg-amber-400 transition-all shadow-lg shadow-amber-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Déposer mon CV
                                </a>
                            </div>

                            <!-- Compteurs -->
                            <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                                <div class="rounded-2xl bg-white/5 border border-white/10 px-6 py-5">
                                    <div class="text-3xl font-black text-white">{{ $statOffres !== null ? $statOffres.'+' : '—' }}</div>
                                    <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Offres de stage actives</div>
                                </div>
                                <div class="rounded-2xl bg-white/5 border border-white/10 px-6 py-5">
                                    <div class="text-3xl font-black text-[#F59E0B]">{{ $statEntreprises !== null ? $statEntreprises.'+' : '—' }}</div>
                                    <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Entreprises partenaires</div>
                                </div>
                                <div class="rounded-2xl bg-white/5 border border-white/10 px-6 py-5">
                                    <div class="text-3xl font-black text-white">{{ $statEtudiants !== null ? $statEtudiants.'+' : '—' }}</div>
                                    <div class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Étudiants inscrits</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ZONE DE RECHERCHE (carte blanche chevauchante) -->
                    <div class="relative z-10 -mt-16 sm:-mt-10 pb-4">
                        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                            <form action="{{ route('offres.index') }}" method="GET" class="bg-white rounded-3xl shadow-2xl border border-slate-100 p-4 sm:p-6">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 items-end">
                                    <div class="md:col-span-4">
                                        <label for="hero-keyword" class="form-label">Mot-clé</label>
                                        <input id="hero-keyword" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Intitulé du poste, compétence…" class="form-input !py-3" />
                                    </div>
                                    <div class="md:col-span-3">
                                        <label for="hero-domaine" class="form-label">Domaine</label>
                                        <select id="hero-domaine" name="domaine" class="form-select !py-3">
                                            <option value="">Tous les domaines</option>
                                            @foreach($domainList as $d)
                                                <option value="{{ $d }}" @selected(request('domaine') === $d)>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="md:col-span-3">
                                        <label for="hero-localisation" class="form-label">Localisation</label>
                                        <input id="hero-localisation" type="text" name="localisation" value="{{ request('localisation') }}" placeholder="Ville, région…" class="form-input !py-3" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-[#2563EB] text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            Rechercher
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-3 text-xs text-slate-500 font-medium text-center md:text-left">
                                    <span class="text-[#F59E0B] font-bold">&bull;</span> Des centaines d'offres vérifiées des meilleures entreprises.
                                </p>
                            </form>
                        </div>
                    </div>
                </section>

                <!-- DOMAINES (pills) -->
                @if($domainList->isNotEmpty())
                <section class="px-6 sm:px-10 lg:px-12 mt-10">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex items-end justify-between gap-4 mb-5">
                            <div>
                                <h2 class="section-title">Parcourir par domaine</h2>
                                <p class="mt-1 text-sm text-slate-600">Trouve les stages qui correspondent à ta filière.</p>
                            </div>
                            <a href="{{ route('offres.index') }}" class="btn-link whitespace-nowrap">Toutes les offres &rarr;</a>
                        </div>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($domainList as $d)
                                <a href="{{ route('offres.index', ['domaine' => $d]) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-[#2563EB] hover:bg-blue-50 hover:text-[#2563EB] transition-colors shadow-sm">
                                    {{ $d }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif

                <!-- DERNIÈRES OFFRES -->
                <section class="px-6 sm:px-10 lg:px-12 mt-12">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex items-end justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Dernières offres de stage</h2>
                                <p class="mt-2 text-sm text-slate-600">Les opportunités les plus récentes publiées par les entreprises partenaires.</p>
                            </div>
                            <a href="{{ route('offres.index') }}" class="hidden sm:inline-flex items-center gap-2 bg-[#2563EB] text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-blue-700 transition-colors shadow-sm">
                                Toutes les offres
                            </a>
                        </div>

                        @if($featuredOffres->isEmpty())
                            <div class="bg-[#F3F6F9] rounded-3xl border border-slate-200 p-12 text-center">
                                <div class="mx-auto inline-flex items-center justify-center h-16 w-16 rounded-full bg-white text-[#2563EB] shadow-sm mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">Les offres arrivent bientôt</h3>
                                <p class="text-slate-500 mt-1">Crée ton profil dès maintenant pour être parmi les premiers à candidater.</p>
                                <a href="{{ route('register') }}" class="btn btn-primary mt-5">Créer mon compte gratuitement</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($featuredOffres as $offre)
                                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col overflow-hidden">
                                        <div class="p-6 flex-1">
                                            <div class="flex items-center justify-between gap-3">
                                                <span class="badge bg-blue-50 text-[#2563EB] border border-blue-100">{{ $offre->domaine }}</span>
                                                <span class="text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</span>
                                            </div>

                                            <h3 class="mt-4 text-lg font-bold text-slate-900 leading-snug line-clamp-2">
                                                <a href="{{ route('offres.show', $offre) }}" class="hover:text-[#2563EB] transition-colors">{{ $offre->titre }}</a>
                                            </h3>

                                            <p class="mt-1 text-sm font-semibold text-[#2563EB]">{{ $offre->companyProfile?->nom_entreprise ?? 'Entreprise' }}</p>

                                            <div class="mt-4 space-y-1.5 text-sm text-slate-600">
                                                <p class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $offre->localisation ?? 'Non spécifiée' }}
                                                </p>
                                                <p class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                    Stage · {{ $offre->type_contrat ?? 'Temps plein' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex items-center justify-between gap-3">
                                            <span class="badge badge-success">Active</span>
                                            <a href="{{ route('offres.show', $offre) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-[#2563EB] hover:text-blue-700 transition-colors">
                                                Voir l'offre
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>

                <!-- COMMENT ÇA MARCHE -->
                <section id="comment-ca-marche" class="px-6 sm:px-10 lg:px-12 mt-16">
                    <div class="max-w-7xl mx-auto">
                        <div class="text-center max-w-2xl mx-auto">
                            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Comment ça marche ?</h2>
                            <p class="mt-2 text-sm sm:text-base text-slate-600">Trouve le stage idéal en trois étapes simples, de la création du profil au suivi de tes candidatures.</p>
                        </div>

                        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                                <span class="absolute top-5 right-6 text-5xl font-black text-blue-50">01</span>
                                <div class="w-12 h-12 rounded-2xl bg-[#2563EB] text-white flex items-center justify-center font-extrabold text-lg shadow-lg shadow-blue-500/25">1</div>
                                <h3 class="mt-5 text-lg font-bold text-slate-900">Créer son profil</h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">Inscris-toi et complète ton profil : compétences, formation et CV.</p>
                            </div>
                            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                                <span class="absolute top-5 right-6 text-5xl font-black text-amber-50">02</span>
                                <div class="w-12 h-12 rounded-2xl bg-[#F59E0B] text-slate-900 flex items-center justify-center font-extrabold text-lg shadow-lg shadow-amber-500/25">2</div>
                                <h3 class="mt-5 text-lg font-bold text-slate-900">Rechercher et postuler</h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">Parcours les offres de stage actives et dépose ta candidature en quelques clics.</p>
                            </div>
                            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                                <span class="absolute top-5 right-6 text-5xl font-black text-emerald-50">03</span>
                                <div class="w-12 h-12 rounded-2xl bg-[#22C55E] text-white flex items-center justify-center font-extrabold text-lg shadow-lg shadow-emerald-500/25">3</div>
                                <h3 class="mt-5 text-lg font-bold text-slate-900">Suivre ses candidatures</h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">Suis l'évolution de tes candidatures et reçois les réponses des entreprises.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- BLOCS AVANTAGES + IMAGES -->
                <section class="px-6 sm:px-10 lg:px-12 mt-16">
                    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-[#F3F6F9] rounded-3xl border border-slate-200 overflow-hidden flex flex-col">
                            <div class="h-56 sm:h-64 overflow-hidden">
                                <img src="{{ asset('images/students-work.jpg') }}" alt="Étudiants et stages" class="w-full h-full object-cover object-center" />
                            </div>
                            <div class="p-8 flex-1">
                                <span class="badge bg-white text-[#2563EB] border border-slate-200 shadow-sm">Flexibilité</span>
                                <h3 class="mt-4 text-xl font-extrabold text-slate-900">Sur place, à distance et hybride</h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">Des stages adaptés à ton mode de vie : en entreprise, en télétravail ou en hybride. Choisis ce qui te convient.</p>
                                <ul class="mt-5 space-y-2.5 text-sm text-slate-700 font-medium">
                                    <li class="flex items-center gap-2.5"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2563EB]/10 text-[#2563EB]"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Offres sur site partout au Maroc</li>
                                    <li class="flex items-center gap-2.5"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2563EB]/10 text-[#2563EB]"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Télétravail et formats hybrides</li>
                                    <li class="flex items-center gap-2.5"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2563EB]/10 text-[#2563EB]"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Postule en ligne, sans papier</li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-[#F3F6F9] rounded-3xl border border-slate-200 overflow-hidden flex flex-col">
                            <div class="h-56 sm:h-64 overflow-hidden">
                                <img src="{{ asset('images/login1.jpg') }}" alt="Entreprises et recrutement" class="w-full h-full object-cover object-center" />
                            </div>
                            <div class="p-8 flex-1">
                                <span class="badge bg-white text-[#2563EB] border border-slate-200 shadow-sm">Types de stage</span>
                                <h3 class="mt-4 text-xl font-extrabold text-slate-900">PFE, pré-embauche et rémunérés</h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">Des missions pour tous les profils : stages de fin d'études, opportunités pré-embauche et missions rémunérées.</p>
                                <ul class="mt-5 space-y-2.5 text-sm text-slate-700 font-medium">
                                    <li class="flex items-center gap-2.5"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#F59E0B]/15 text-[#F59E0B]"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Stages PFE / PFI</li>
                                    <li class="flex items-center gap-2.5"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#F59E0B]/15 text-[#F59E0B]"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Opportunités pré-embauche</li>
                                    <li class="flex items-center gap-2.5"><span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#F59E0B]/15 text-[#F59E0B]"><svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Stages rémunérés</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- TARIFS -->
                <section id="tarifs" class="px-6 sm:px-10 lg:px-12 mt-16 py-14 bg-[#F3F6F9]">
                    <div class="max-w-7xl mx-auto">
                        <div class="text-center max-w-2xl mx-auto">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white border border-slate-200 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#2563EB] shadow-sm">
                                Nos tarifs
                            </span>
                            <h2 class="mt-4 text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Investis dans ta carrière</h2>
                            <p class="mt-2 text-sm sm:text-base text-slate-600">Des formules simples et accessibles pour décrocher le stage qui fait avancer ton projet.</p>
                        </div>

                        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                            <!-- STARTER -->
                            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm flex flex-col">
                                <h3 class="text-lg font-extrabold uppercase tracking-wide text-slate-900">Starter</h3>
                                <p class="mt-1 text-sm text-slate-500">Les bases pour commencer</p>
                                <div class="mt-6 flex items-end gap-1">
                                    <span class="text-4xl font-black text-slate-900">150 DH</span>
                                    <span class="text-sm text-slate-500 font-semibold pb-1">/ 1 mois</span>
                                </div>
                                <ul class="mt-6 space-y-3 text-sm text-slate-700 flex-1">
                                    <li class="flex items-start gap-2.5"><span class="text-[#2563EB] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Accès aux offres de stage</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#2563EB] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Déposer son CV</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#2563EB] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Candidatures illimitées</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#2563EB] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Suivi de ses candidatures</li>
                                </ul>
                                <a href="{{ auth()->guest() ? route('register') : route(auth()->user()->dashboardRoute()) }}" class="mt-8 inline-flex items-center justify-center rounded-full border-2 border-[#2563EB] text-[#2563EB] px-6 py-3 text-sm font-bold hover:bg-blue-50 transition-colors">
                                    Choisir Starter
                                </a>
                            </div>

                            <!-- SERIOUS ( Meilleure vente ) -->
                            <div class="relative bg-slate-900 rounded-3xl border-2 border-[#F59E0B] p-8 shadow-2xl flex flex-col md:-mt-4 md:mb-4">
                                <span class="absolute -top-4 left-1/2 -translate-x-1/2 inline-flex items-center gap-1.5 rounded-full bg-[#F59E0B] text-slate-900 px-4 py-1.5 text-xs font-black uppercase tracking-widest shadow-lg">
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27l6.18 3.73-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73-1.64 7.03z"/></svg>
                                    Meilleure vente
                                </span>
                                <h3 class="text-lg font-extrabold uppercase tracking-wide text-white">Serious</h3>
                                <p class="mt-1 text-sm text-slate-400">Décrocher des stages facilement</p>
                                <div class="mt-6 flex items-end gap-1">
                                    <span class="text-4xl font-black text-[#F59E0B]">190 DH</span>
                                    <span class="text-sm text-slate-400 font-semibold pb-1">/ 2 mois</span>
                                </div>
                                <ul class="mt-6 space-y-3 text-sm text-slate-200 flex-1">
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Tout le pack Starter</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Offres en avant</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Mises en relation entreprise</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Alertes e-mail &amp; notifications</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Support prioritaire</li>
                                </ul>
                                <a href="{{ auth()->guest() ? route('register') : route(auth()->user()->dashboardRoute()) }}" class="mt-8 inline-flex items-center justify-center rounded-full bg-[#F59E0B] text-slate-900 px-6 py-3 text-sm font-black hover:bg-amber-400 transition-colors shadow-lg shadow-amber-500/20">
                                    Choisir Serious
                                </a>
                            </div>

                            <!-- TALENT -->
                            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm flex flex-col">
                                <h3 class="text-lg font-extrabold uppercase tracking-wide text-slate-900">Talent</h3>
                                <p class="mt-1 text-sm text-slate-500">Les meilleurs stages pour toi</p>
                                <div class="mt-6 flex items-end gap-1">
                                    <span class="text-4xl font-black text-slate-900">290 DH</span>
                                    <span class="text-sm text-slate-500 font-semibold pb-1">/ 3 mois</span>
                                </div>
                                <ul class="mt-6 space-y-3 text-sm text-slate-700 flex-1">
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Tout le pack Serious</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> CV mis en avant</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Coaching personnalisé</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Accès TPE, PME &amp; multinationales</li>
                                    <li class="flex items-start gap-2.5"><span class="text-[#F59E0B] mt-0.5"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg></span> Suivi dédié</li>
                                </ul>
                                <a href="{{ auth()->guest() ? route('register') : route(auth()->user()->dashboardRoute()) }}" class="mt-8 inline-flex items-center justify-center rounded-full border-2 border-[#2563EB] text-[#2563EB] px-6 py-3 text-sm font-bold hover:bg-blue-50 transition-colors">
                                    Choisir Talent
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- BANDEAU CTA FINAL -->
                <section class="px-6 sm:px-10 lg:px-12 py-14">
                    <div class="max-w-7xl mx-auto bg-slate-900 rounded-3xl relative overflow-hidden">
                        <div class="absolute inset-0">
                            <img src="{{ asset('images/students-work.jpg') }}" alt="" class="w-full h-full object-cover opacity-15" />
                        </div>
                        <div class="relative px-6 sm:px-12 py-12 sm:py-16 text-center">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Prêt à lancer ta carrière ?</h2>
                            <p class="mt-3 max-w-xl mx-auto text-slate-300 text-sm sm:text-base">Crée ton profil en quelques minutes et accède immédiatement aux offres des meilleures entreprises.</p>
                            <div class="mt-7 flex flex-wrap items-center justify-center gap-4">
                                <a href="{{ auth()->guest() ? route('register') : route(auth()->user()->dashboardRoute()) }}" class="inline-flex items-center gap-2 rounded-full bg-[#F59E0B] text-slate-900 px-8 py-3.5 font-bold text-sm sm:text-base hover:bg-amber-400 transition-colors shadow-lg shadow-amber-500/20">
                                    Créer mon compte gratuitement
                                </a>
                                <a href="{{ route('offres.index') }}" class="inline-flex items-center gap-2 rounded-full border-2 border-white/30 text-white px-8 py-3.5 font-bold text-sm sm:text-base hover:bg-white/10 transition-colors">
                                    Voir les offres
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

            </main>

            <x-stageflow-footer />
        </div>
    </body>
</html>