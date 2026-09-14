<nav x-data="{ open: false }">
    @php
        $user = auth()->user();
        $dashboardRoute = $user?->dashboardRoute() ?? 'dashboard';
    @endphp

    <!-- ================= HEADER (blanc) ================= -->
    <header class="sticky top-0 z-40 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Logo (toujours vers /) -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
                <span class="text-blue-600"><x-application-logo class="block h-8 w-auto" /></span>
                <span class="text-xl font-bold tracking-tight text-gray-900">StageFlow</span>
            </a>

            <!-- Navigation centrale -->
            <nav class="hidden lg:flex items-center gap-1">
                <x-nav-link :href="url('/')" :active="request()->is('/')">
                    {{ __('Accueil') }}
                </x-nav-link>

                <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs('dashboard', 'company.dashboard', 'admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>

                @if($user && $user->isEtudiant())
                    <x-nav-link :href="route('offres.index')" :active="request()->routeIs('offres.*')">
                        {{ __('Offres') }}
                    </x-nav-link>
                    <x-nav-link :href="route('candidatures.index')" :active="request()->routeIs('candidatures.index')">
                        {{ __('Mes candidatures') }}
                    </x-nav-link>
                    <x-nav-link :href="route('student-profile.show')" :active="request()->routeIs('student-profile.*')">
                        {{ __('Mon profil') }}
                    </x-nav-link>
                @elseif($user && $user->isEntreprise())
                    <x-nav-link :href="route('offres.company.index')" :active="request()->routeIs('offres.company.*')">
                        {{ __('Mes offres') }}
                    </x-nav-link>
                    <x-nav-link :href="route('candidatures.company.index')" :active="request()->routeIs('candidatures.company.index')">
                        {{ __('Candidatures reçues') }}
                    </x-nav-link>
                    <x-nav-link :href="route('company-profile.show')" :active="request()->routeIs('company-profile.*')">
                        {{ __('Mon profil') }}
                    </x-nav-link>
                @elseif($user && $user->isAdministrateur())
                    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                        {{ __('Utilisateurs') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.offres')" :active="request()->routeIs('admin.offres')">
                        {{ __('Offres') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.candidatures')" :active="request()->routeIs('admin.candidatures')">
                        {{ __('Candidatures') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.dashboard')">
                        {{ __('Statistiques') }}
                    </x-nav-link>
                @endif

                <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                    {{ __('Notifications') }}
                </x-nav-link>
            </nav>

            <!-- Actions à droite -->
            <div class="flex items-center gap-3">
                @if($user && $user->isEntreprise())
                    <a href="{{ route('offres.company.create') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors shadow-sm">
                        + Nouvelle offre
                    </a>
                @endif

                <div class="hidden sm:flex">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2.5 px-3 py-1.5 text-sm leading-5 font-medium rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 focus:outline-none transition ease-in-out duration-150">
                                <span class="flex items-center justify-center h-7 w-7 rounded-full bg-blue-600 text-xs font-bold text-white">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                                <div class="hidden md:block font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Mon profil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none sm:ms-1 lg:hidden">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- ================= MENU MOBILE ================= -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-white border-b border-slate-200">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                {{ __('Accueil') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs('dashboard', 'company.dashboard', 'admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if($user && $user->isEtudiant())
                <x-responsive-nav-link :href="route('offres.index')" :active="request()->routeIs('offres.*')">
                    {{ __('Offres') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('candidatures.index')" :active="request()->routeIs('candidatures.index')">
                    {{ __('Mes candidatures') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('student-profile.show')" :active="request()->routeIs('student-profile.*')">
                    {{ __('Mon profil') }}
                </x-responsive-nav-link>
            @elseif($user && $user->isEntreprise())
                <x-responsive-nav-link :href="route('offres.company.index')" :active="request()->routeIs('offres.company.*')">
                    {{ __('Mes offres') }}
                </x-responsive-nav-link>
                <div class="px-3 pt-2">
                    <a href="{{ route('offres.company.create') }}" class="inline-flex w-full items-center justify-center h-10 px-4 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                        {{ __('+ Nouvelle offre') }}
                    </a>
                </div>
                <x-responsive-nav-link :href="route('candidatures.company.index')" :active="request()->routeIs('candidatures.company.index')">
                    {{ __('Candidatures reçues') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('company-profile.show')" :active="request()->routeIs('company-profile.*')">
                    {{ __('Mon profil') }}
                </x-responsive-nav-link>
            @elseif($user && $user->isAdministrateur())
                <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                    {{ __('Utilisateurs') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.offres')" :active="request()->routeIs('admin.offres')">
                    {{ __('Offres') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.candidatures')" :active="request()->routeIs('admin.candidatures')">
                    {{ __('Candidatures') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.dashboard')">
                    {{ __('Statistiques') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                {{ __('Notifications') }}
            </x-responsive-nav-link>
        </div>

        <!-- Options utilisateur (mobile) -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mon profil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>