<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-display font-bold text-slate-900">Mes Reçus</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $recus->count() }} reçu(s) au total</p>
            </div>
            <a href="{{ route('recus.create') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau reçu
            </a>
        </div>

        @forelse($recus as $recu)
            @php
                $statusClasses = [
                    'en_attente' => 'badge-warning',
                    'traite' => 'badge-success',
                    'echoue' => 'badge-danger',
                ];
                $statusLabels = [
                    'en_attente' => 'En attente',
                    'traite' => 'Traité',
                    'echoue' => 'Échoué',
                ];
            @endphp

            <div class="card p-5 mb-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <h2 class="text-lg font-display font-bold text-slate-900">{{ $recu->title }}</h2>
                            <span class="text-xs text-slate-400 font-medium">#{{ $recu->id }}</span>
                            <span class="{{ $statusClasses[$recu->statut->value] ?? 'badge-neutral' }}">
                                {{ $statusLabels[$recu->statut->value] ?? $recu->statut->value }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 text-sm text-slate-500">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ $recu->depenses_count }} dépense(s)
                            </span>

                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $recu->created_at->format('d/m/Y') }}
                            </span>

                            @if ($recu->estimated_total)
                                <span class="flex items-center gap-1.5 font-semibold text-slate-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ number_format($recu->estimated_total, 2) }} {{ $recu->currency ?? 'MAD' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('recus.show', $recu) }}" class="btn-secondary !py-1.5 !px-3 !text-xs">
                            Voir
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('recus.destroy', $recu) }}" class="inline" onsubmit="return confirm('Supprimer ce reçu ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-lg font-display font-bold text-slate-900 mb-1">Aucun reçu pour le moment</p>
                <p class="text-sm text-slate-500 mb-5">Créez votre premier reçu pour commencer.</p>
                <a href="{{ route('recus.create') }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau reçu
                </a>
            </div>
        @endforelse

    </div>
</x-app-layout>
