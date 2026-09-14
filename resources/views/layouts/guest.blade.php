<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StageFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-[#F3F6F9]">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-5">
            <!-- Colonne gauche : Formulaire & Branding (60%) -->
            <div class="flex flex-col justify-center bg-[#F3F6F9] px-6 py-12 sm:px-12 lg:col-span-3 lg:px-16 xl:px-24">
                <div class="w-full max-w-xl mx-auto">
                    <a href="/" class="flex items-center gap-2.5">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#2563EB] text-white">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-5-5z" />
                                <path d="M14 2v5h5" />
                                <path d="M9 13h6" />
                                <path d="M9 17h4" />
                            </svg>
                        </span>
                        <span class="text-2xl font-bold tracking-tight text-slate-900">StageFlow</span>
                    </a>

                    <div class="mt-7">
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/60 p-6 sm:p-10">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Image (40%) -->
            <div class="hidden lg:block relative overflow-hidden bg-slate-900">
                <img src="{{ asset('images/login1.jpg') }}" alt="Recherche de stage StageFlow" class="absolute inset-0 h-full w-full object-cover object-center" />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-900/40 to-slate-900/10"></div>

                <div class="absolute inset-x-0 bottom-0 p-10 lg:p-12">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#F59E0B]">
                        StageFlow
                    </span>
                    <h2 class="mt-4 text-2xl font-extrabold tracking-tight text-white leading-snug">Trouve ton stage et lance ta carrière</h2>
                    <p class="mt-2 text-sm text-slate-300 leading-relaxed">Des centaines d'offres vérifiées, des entreprises de confiance et un suivi en temps réel de tes candidatures.</p>

                    <ul class="mt-6 space-y-3 text-sm text-slate-200 font-medium">
                        <li class="flex items-center gap-2.5">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2563EB]/20 text-[#2563EB]">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            Offres de stage vérifiées
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#F59E0B]/20 text-[#F59E0B]">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            Candidatures en un clic
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#22C55E]/20 text-[#22C55E]">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            Accompagnement dans ta recherche
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>