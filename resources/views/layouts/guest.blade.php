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
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-5">
            <!-- Colonne gauche : Formulaire & Branding (60%) -->
            <div class="flex flex-col justify-center bg-white px-6 py-12 sm:px-12 lg:col-span-3 lg:px-16 xl:px-24">
                <div class="w-full max-w-lg mx-auto">
                    <a href="/" class="flex items-center gap-2.5">
                        <span class="text-blue-600"><x-application-logo class="block h-8 w-auto" /></span>
                        <span class="text-2xl font-bold tracking-tight text-slate-900">StageFlow</span>
                    </a>

                    <div class="mt-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Image students-work.jpg (40%) -->
            <div class="relative overflow-hidden bg-slate-900 min-h-60 sm:min-h-80 lg:min-h-0 lg:col-span-2">
                <img src="{{ asset('images/students-work.jpg') }}" alt="Recherche de stage StageFlow" class="absolute inset-0 h-full w-full object-cover object-center" />
                <div class="absolute inset-0 bg-slate-900/30"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-10 lg:p-12 text-white bg-gradient-to-t from-slate-950/80 via-slate-950/40 to-transparent">
                    <h2 class="text-2xl font-extrabold tracking-tight">Trouvez votre prochain stage avec StageFlow</h2>
                    <p class="mt-2 text-sm text-slate-200 leading-relaxed">Accédez à des centaines d'offres exclusives et suivez vos candidatures en temps réel.</p>
                </div>
            </div>
        </div>
    </body>
</html>