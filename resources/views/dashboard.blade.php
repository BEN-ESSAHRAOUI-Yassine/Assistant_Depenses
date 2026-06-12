<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-2xl font-display font-bold text-slate-900">Tableau de bord</h1>
            <p class="text-sm text-slate-500 mt-1">Vue d'ensemble de vos reçus et dépenses</p>
        </div>

        @if ($stats['total_recus'] === 0)
            <div class="card p-12 text-center">
                <div class="w-16 h-16 bg-primary-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-display font-bold text-slate-900 mb-2">Bienvenue sur votre espace</h3>
                <p class="text-slate-500 mb-6 max-w-md mx-auto">Vous n'avez pas encore de reçus. Commencez par en créer un pour que l'IA extraira vos dépenses automatiquement.</p>
                <a href="{{ route('recus.create') }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau reçu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total reçus</p>
                            <p class="text-2xl font-display font-bold text-slate-900 mt-1">{{ $stats['total_recus'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Traités</p>
                            <p class="text-2xl font-display font-bold text-emerald-600 mt-1">{{ $stats['traite'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">En attente</p>
                            <p class="text-2xl font-display font-bold text-amber-600 mt-1">{{ $stats['en_attente'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Échoués</p>
                            <p class="text-2xl font-display font-bold text-red-600 mt-1">{{ $stats['echoue'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total estimé</p>
                            <p class="text-2xl font-display font-bold text-slate-900 mt-1">{{ number_format($stats['total_estime'], 0) }} <span class="text-sm font-normal text-slate-500">MAD</span></p>
                        </div>
                        <div class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="card p-6">
                    <h3 class="font-display font-bold text-slate-900 mb-4">Dépenses par catégorie</h3>
                    @if (count($chartCategories) > 0)
                        <canvas
                            x-data="{}"
                            x-init="new Chart($el, {
                                type: 'doughnut',
                                data: {
                                    labels: {{ Js::from($chartCategories) }},
                                    datasets: [{
                                        data: {{ Js::from($chartValues) }},
                                        backgroundColor: ['#0f766e', '#059669', '#d97706', '#0284c7', '#7c3aed'],
                                        borderWidth: 2,
                                        borderColor: '#fff',
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyle: 'circle' } }
                                    }
                                }
                            })"
                            class="max-h-64"
                        ></canvas>
                    @else
                        <div class="text-center py-8 text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            </svg>
                            <p class="text-sm">Aucune dépense pour le moment.</p>
                        </div>
                    @endif
                </div>

                <div class="card p-6">
                    <h3 class="font-display font-bold text-slate-900 mb-4">Évolution mensuelle</h3>
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
                                            borderColor: '#0f766e',
                                            backgroundColor: 'rgba(15, 118, 110, 0.1)',
                                            fill: true,
                                            tension: 0.3,
                                        },
                                        {
                                            label: 'Montant (MAD)',
                                            data: {{ Js::from($monthTotals) }},
                                            borderColor: '#d97706',
                                            backgroundColor: 'rgba(217, 119, 6, 0.1)',
                                            fill: true,
                                            tension: 0.3,
                                            yAxisID: 'y1',
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    interaction: { intersect: false, mode: 'index' },
                                    plugins: {
                                        legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, pointStyle: 'circle' } }
                                    },
                                    scales: {
                                        y: { beginAtZero: true, ticks: { stepSize: 1 } },
                                        y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
                                    }
                                }
                            })"
                            class="max-h-64"
                        ></canvas>
                    @else
                        <div class="text-center py-8 text-slate-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <p class="text-sm">Aucun reçu pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-display font-bold text-slate-900">Reçus récents</h3>
                    <a href="{{ route('recus.index') }}" class="text-sm font-semibold text-primary-700 hover:text-primary-800 transition-colors">
                        Voir tout →
                    </a>
                </div>

                @php
                    $statusLabels = [
                        'en_attente' => 'En attente',
                        'traite' => 'Traité',
                        'echoue' => 'Échoué',
                    ];
                    $statusClasses = [
                        'en_attente' => 'badge-warning',
                        'traite' => 'badge-success',
                        'echoue' => 'badge-danger',
                    ];
                @endphp

                @if ($recentRecus->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 text-left text-slate-500">
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Titre</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Dépenses</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($recentRecus as $recu)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-3.5">
                                            <a href="{{ route('recus.show', $recu) }}" class="font-semibold text-slate-900 hover:text-primary-700 transition-colors">
                                                {{ $recu->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-3.5">
                                            <span class="{{ $statusClasses[$recu->statut->value] ?? 'badge-neutral' }}">
                                                {{ $statusLabels[$recu->statut->value] ?? $recu->statut->value }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3.5 text-slate-600">{{ $recu->depenses_count }}</td>
                                        <td class="px-6 py-3.5 text-slate-500">{{ $recu->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-slate-400 text-center py-8">Aucun reçu récent.</p>
                @endif
            </div>
        @endif

    </div>
</x-app-layout>
