<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($stats['total_recus'] === 0)
                <div class="bg-white border border-gray-200 rounded-xl p-12 shadow-sm text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Bienvenue sur votre espace</h3>
                    <p class="text-gray-500 mb-6">Vous n'avez pas encore de reçus. Commencez par en créer un.</p>
                    <a
                        href="{{ route('recus.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nouveau reçu
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total reçus</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_recus'] }}</p>
                            </div>
                            <div class="p-3 bg-gray-100 rounded-lg">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Traités</p>
                                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['traite'] }}</p>
                            </div>
                            <div class="p-3 bg-emerald-50 rounded-lg">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">En attente</p>
                                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['en_attente'] }}</p>
                            </div>
                            <div class="p-3 bg-amber-50 rounded-lg">
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Échoués</p>
                                <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['echoue'] }}</p>
                            </div>
                            <div class="p-3 bg-red-50 rounded-lg">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total estimé</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_estime'], 0) }} MAD</p>
                            </div>
                            <div class="p-3 bg-indigo-50 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-4">Dépenses par catégorie</h3>
                        @if (count($chartCategories) > 0)
                            <canvas
                                x-data="{}"
                                x-init="new Chart($el, {
                                    type: 'doughnut',
                                    data: {
                                        labels: {{ Js::from($chartCategories) }},
                                        datasets: [{
                                            data: {{ Js::from($chartValues) }},
                                            backgroundColor: ['#f97316', '#3b82f6', '#a855f7', '#14b8a6', '#6b7280'],
                                            borderWidth: 2,
                                            borderColor: '#fff',
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'bottom',
                                            }
                                        }
                                    }
                                })"
                                class="max-h-64"
                            ></canvas>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                </svg>
                                <p class="text-sm">Aucune dépense pour le moment.</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-4">Évolution mensuelle</h3>
                        @if (array_sum($monthCounts) > 0)
                            <canvas
                                x-data="{}"
                                x-init="new Chart($el, {
                                    type: 'line',
                                    data: {
                                        labels: {{ Js::from($months) }},
                                        datasets: [
                                            {
                                                label: 'Reçus',
                                                data: {{ Js::from($monthCounts) }},
                                                borderColor: '#3b82f6',
                                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                                fill: true,
                                                tension: 0.3,
                                            },
                                            {
                                                label: 'Montant (MAD)',
                                                data: {{ Js::from($monthTotals) }},
                                                borderColor: '#f97316',
                                                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                                                fill: true,
                                                tension: 0.3,
                                                yAxisID: 'y1',
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        interaction: {
                                            intersect: false,
                                            mode: 'index',
                                        },
                                        plugins: {
                                            legend: {
                                                position: 'bottom',
                                            }
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                ticks: {
                                                    stepSize: 1,
                                                }
                                            },
                                            y1: {
                                                beginAtZero: true,
                                                position: 'right',
                                                grid: {
                                                    drawOnChartArea: false,
                                                },
                                            }
                                        }
                                    }
                                })"
                                class="max-h-64"
                            ></canvas>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <p class="text-sm">Aucun reçu pour le moment.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Reçus récents</h3>
                        <a
                            href="{{ route('recus.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition"
                        >
                            Voir tout
                        </a>
                    </div>

                    @php
                        $statusLabels = [
                            'en_attente' => 'En attente',
                            'traite' => 'Traité',
                            'echoue' => 'Échoué',
                        ];
                        $statusClasses = [
                            'en_attente' => 'bg-amber-100 text-amber-700',
                            'traite' => 'bg-emerald-100 text-emerald-700',
                            'echoue' => 'bg-red-100 text-red-700',
                        ];
                    @endphp

                    @if ($recentRecus->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-100 text-left text-gray-500">
                                        <th class="pb-3 font-medium">Titre</th>
                                        <th class="pb-3 font-medium">Statut</th>
                                        <th class="pb-3 font-medium">Dépenses</th>
                                        <th class="pb-3 font-medium">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentRecus as $recu)
                                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                            <td class="py-3">
                                                <a
                                                    href="{{ route('recus.show', $recu) }}"
                                                    class="font-medium text-gray-900 hover:text-indigo-600 transition"
                                                >
                                                    {{ $recu->title }}
                                                </a>
                                            </td>
                                            <td class="py-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$recu->statut->value] ?? 'bg-gray-100 text-gray-700' }}">
                                                    {{ $statusLabels[$recu->statut->value] ?? $recu->statut->value }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-gray-600">{{ $recu->depenses_count }}</td>
                                            <td class="py-3 text-gray-600">{{ $recu->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 text-center py-4">Aucun reçu récent.</p>
                    @endif
                </div>

                <div class="flex gap-4">
                    <a
                        href="{{ route('recus.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Voir mes reçus
                    </a>

                    <a
                        href="{{ route('recus.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nouveau reçu
                    </a>

                    <a
                        href="{{ route('depenses.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Voir les dépenses
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
