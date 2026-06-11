<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Mes Reçus
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $recus->count() }} reçu(s) au total
                </p>
            </div>

            <a
                href="{{ route('recus.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition"
            >
                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau reçu
            </a>
        </div>

        @forelse($recus as $recu)

            <div class="bg-white border border-gray-200 rounded-xl p-5 mb-4 shadow-sm hover:shadow-md transition">

                <div class="flex items-start justify-between">

                    <div class="space-y-2">

                        <div class="flex items-center gap-3">
                            <span class="text-lg font-semibold text-gray-900">
                                {{ $recu->title }}
                            </span>
                            <span class="text-sm text-gray-400">
                                #{{ $recu->id }}
                            </span>

                            @php
                                $statusClasses = [
                                    'en_attente' => 'bg-amber-100 text-amber-700',
                                    'traite' => 'bg-emerald-100 text-emerald-700',
                                    'echoue' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'en_attente' => 'En attente',
                                    'traite' => 'Traité',
                                    'echoue' => 'Échoué',
                                ];
                            @endphp

                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$recu->statut->value] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $statusLabels[$recu->statut->value] ?? $recu->statut->value }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ $recu->depenses_count }} dépense(s)
                            </span>

                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $recu->created_at->format('d/m/Y') }}
                            </span>

                            @if ($recu->estimated_total)
                                <span class="flex items-center gap-1 font-medium text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ number_format($recu->estimated_total, 2) }} {{ $recu->currency ?? 'MAD' }}
                                </span>
                            @endif
                        </div>

                    </div>

                    <div class="flex items-center gap-2">

                        <a
                            href="{{ route('recus.show', $recu) }}"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                        >
                            Voir
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <form
                            method="POST"
                            action="{{ route('recus.destroy', $recu) }}"
                            class="inline"
                            onsubmit="return confirm('Supprimer ce reçu ?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-16 bg-white border border-gray-200 rounded-xl">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg font-medium text-gray-500">
                    Aucun reçu pour le moment
                </p>
                <p class="text-sm text-gray-400 mt-1">
                    Créez votre premier reçu pour commencer.
                </p>
                <a
                    href="{{ route('recus.create') }}"
                    class="inline-flex items-center mt-4 px-4 py-2 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition"
                >
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau reçu
                </a>
            </div>

        @endforelse

    </div>
</x-app-layout>