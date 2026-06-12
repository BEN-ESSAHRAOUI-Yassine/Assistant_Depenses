<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Assistant Dépenses') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
                body{font-family:'Inter',system-ui,sans-serif;background:#f8fafc;color:#0f172a;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px}
            </style>
        @endif
    </head>
    <body class="bg-slate-50 text-slate-900 antialiased">

        <div class="w-full max-w-5xl">
            <header class="flex items-center justify-end gap-4 mb-12">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                            Connexion
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary !py-2 !px-4 !text-sm">
                                Inscription
                            </a>
                        @endif
                    @endauth
                @endif
            </header>

            <main class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-50 text-primary-700 rounded-full text-xs font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Propulsé par l'IA
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-display font-extrabold text-slate-900 leading-tight mb-4">
                        Gérez vos dépenses<br>
                        <span class="text-primary-700">en toute simplicité.</span>
                    </h1>

                    <p class="text-lg text-slate-500 mb-8 leading-relaxed max-w-lg">
                        Collez le texte de vos reçus, laissez l'IA extraire les dépenses automatiquement, et gardez le contrôle de votre budget.
                    </p>

                    <div class="space-y-4 mb-10">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Collez le texte de votre reçu</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">L'IA extrait automatiquement les dépenses</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Suivez vos dépenses par catégorie</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('recus.index') }}" class="btn-primary">
                                Mes reçus
                            </a>
                            <a href="{{ route('recus.create') }}" class="btn-secondary">
                                Nouveau reçu
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary">
                                Commencer
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-secondary">
                                    Inscription gratuite
                                </a>
                            @endif
                        @endauth
                    </div>

                    <p class="mt-8 text-xs text-slate-400">v{{ app()->version() }}</p>
                </div>

                <div class="relative">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-primary-700 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-display font-bold text-slate-900">Courses Carrefour</p>
                                <p class="text-xs text-slate-500">10 Juin 2026</p>
                            </div>
                            <span class="ml-auto badge-success">Traité</span>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between py-2 border-t border-slate-100">
                                <span class="text-sm text-slate-600">Lait</span>
                                <span class="text-sm font-semibold text-slate-900">18,90 MAD</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-t border-slate-100">
                                <span class="text-sm text-slate-600">Pain</span>
                                <span class="text-sm font-semibold text-slate-900">6,50 MAD</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-t border-slate-100">
                                <span class="text-sm text-slate-600">Oeufs (x12)</span>
                                <span class="text-sm font-semibold text-slate-900">22,00 MAD</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                            <span class="text-sm font-semibold text-slate-500">Total</span>
                            <span class="text-lg font-display font-bold text-primary-700">47,40 MAD</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-primary-100 rounded-2xl -z-10 opacity-60"></div>
                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-amber-100 rounded-2xl -z-10 opacity-60"></div>
                </div>
            </main>
        </div>

    </body>
</html>
