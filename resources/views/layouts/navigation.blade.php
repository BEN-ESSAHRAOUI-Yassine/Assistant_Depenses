<nav x-data="{ mobileOpen: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                    <div class="w-8 h-8 bg-primary-700 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="font-display font-bold text-lg text-slate-900 hidden sm:block">Assistant Dépenses</span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Tableau de bord
                    </a>
                    <a href="{{ route('recus.index') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('recus.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Mes Reçus
                    </a>
                    <a href="{{ route('depenses.index') }}"
                       class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('depenses.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                        Dépenses
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                            <div class="w-8 h-8 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-semibold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Mon profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="mobileOpen = ! mobileOpen"
                        class="p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="sm:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Tableau de bord
            </a>
            <a href="{{ route('recus.index') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('recus.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Mes Reçus
            </a>
            <a href="{{ route('depenses.index') }}"
               class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('depenses.*') ? 'bg-primary-50 text-primary-700' : 'text-slate-600 hover:bg-slate-50' }}">
                Dépenses
            </a>
        </div>

        <div class="border-t border-slate-100 px-4 py-3">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-semibold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors duration-200">
                    Mon profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors duration-200">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
