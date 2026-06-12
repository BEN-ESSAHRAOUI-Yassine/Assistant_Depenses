<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Connexion — {{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 antialiased">

        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
            <a href="/" class="flex items-center gap-2.5 mb-8">
                <div class="w-10 h-10 bg-primary-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="font-display font-bold text-xl text-slate-900">Assistant Dépenses</span>
            </a>

            <div class="w-full max-w-md">
                <div class="card p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-display font-bold text-slate-900">Connexion</h1>
                        <p class="text-sm text-slate-500 mt-1">Connectez-vous à votre compte</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" value="Mot de passe" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500" name="remember">
                                <span class="text-sm text-slate-600">Se souvenir de moi</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-primary-700 hover:text-primary-800 transition-colors" href="{{ route('password.request') }}">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                        <x-primary-button class="w-full justify-center">
                            Se connecter
                        </x-primary-button>
                    </form>
                </div>

                <p class="text-center text-sm text-slate-500 mt-6">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="font-semibold text-primary-700 hover:text-primary-800 transition-colors">
                        Inscription
                    </a>
                </p>
            </div>
        </div>

    </body>
</html>
