<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('recus.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Retour à la liste
            </a>
        </div>

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
            $categorieLabels = [
                'alimentaire' => 'Alimentaire',
                'boissons' => 'Boissons',
                'hygiene' => 'Hygiène',
                'entretien' => 'Entretien',
                'autre' => 'Autre',
            ];
            $categorieClasses = [
                'alimentaire' => 'bg-orange-50 text-orange-700',
                'boissons' => 'bg-sky-50 text-sky-700',
                'hygiene' => 'bg-purple-50 text-purple-700',
                'entretien' => 'bg-teal-50 text-teal-700',
                'autre' => 'bg-slate-100 text-slate-600',
            ];
        @endphp

        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if ($recu->error_message)
            <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <strong class="font-semibold">Erreur d'extraction :</strong>
                {{ $recu->error_message }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-display font-bold text-slate-900">{{ $recu->title }}</h1>
                <span class="text-xs text-slate-400 font-medium">#{{ $recu->id }}</span>
                <span class="{{ $statusClasses[$recu->statut->value] ?? 'badge-neutral' }}">
                    {{ $statusLabels[$recu->statut->value] ?? $recu->statut->value }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                @if ($recu->statut === \App\Enums\StatutRecu::Echoue)
                    <form method="POST" action="{{ route('recus.retry', $recu) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-secondary !border-amber-300 !text-amber-700 hover:!bg-amber-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Relancer l'extraction
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('recus.destroy', $recu) }}" class="inline" onsubmit="return confirm('Supprimer ce reçu ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger !py-1.5 !px-3 !text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="card p-6">
                    <h2 class="font-display font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Texte source
                    </h2>
                    <pre class="text-xs text-slate-700 whitespace-pre-wrap font-mono bg-slate-50 rounded-lg p-4 border border-slate-100 leading-relaxed">{{ $recu->texte_source }}</pre>
                </div>

                <div class="card p-6">
                    <h2 class="font-display font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Dépenses extraites
                        @if($recu->depenses->count())
                            <span class="text-sm font-normal text-slate-500">({{ $recu->depenses->count() }})</span>
                        @endif
                    </h2>

                    @forelse($recu->depenses as $depense)
                        <div class="flex items-center justify-between py-3 {{ !$loop->first ? 'border-t border-slate-100' : '' }}">
                            <div class="flex-1">
                                <span class="font-semibold text-slate-900">{{ $depense->libelle }}</span>
                                <div class="flex items-center gap-3 mt-1 text-sm text-slate-500">
                                    <span>Qté : {{ $depense->quantite }}</span>
                                    <span>Prix unitaire : {{ number_format($depense->prix_unitaire, 2) }} MAD</span>
                                    <span class="font-semibold text-slate-700">
                                        Total : {{ number_format($depense->quantite * $depense->prix_unitaire, 2) }} MAD
                                    </span>
                                </div>
                            </div>
                            <span class="badge {{ $categorieClasses[$depense->categorie->value] ?? 'badge-neutral' }}">
                                {{ $categorieLabels[$depense->categorie->value] ?? $depense->categorie->value }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-sm text-slate-500">Aucune dépense extraite pour ce reçu.</p>
                        </div>
                    @endforelse
                </div>

            </div>

            <div class="space-y-6">

                <div class="card p-6">
                    <h2 class="font-display font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informations
                    </h2>

                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Statut</dt>
                            <dd>
                                <span class="{{ $statusClasses[$recu->statut->value] ?? 'badge-neutral' }}">
                                    {{ $statusLabels[$recu->statut->value] ?? $recu->statut->value }}
                                </span>
                            </dd>
                        </div>

                        <div class="flex justify-between border-t border-slate-100 pt-3">
                            <dt class="text-slate-500">Titre</dt>
                            <dd class="text-slate-900 text-right max-w-[160px] truncate font-medium">{{ $recu->title }}</dd>
                        </div>

                        <div class="flex justify-between border-t border-slate-100 pt-3">
                            <dt class="text-slate-500">Date</dt>
                            <dd class="text-slate-900">{{ $recu->created_at->format('d/m/Y') }}</dd>
                        </div>

                        <div class="flex justify-between border-t border-slate-100 pt-3">
                            <dt class="text-slate-500">Dépenses</dt>
                            <dd class="text-slate-900 font-medium">{{ $recu->depenses->count() }}</dd>
                        </div>

                        @if ($recu->estimated_total)
                            <div class="flex justify-between border-t border-slate-100 pt-3">
                                <dt class="text-slate-500">Total estimé</dt>
                                <dd class="font-bold text-slate-900">
                                    {{ number_format($recu->estimated_total, 2) }} {{ $recu->currency ?? 'MAD' }}
                                </dd>
                            </div>
                        @endif

                        @if ($recu->payload_brut)
                            <div class="flex justify-between border-t border-slate-100 pt-3">
                                <dt class="text-slate-500">Payload</dt>
                                <dd class="text-slate-900">{{ count($recu->payload_brut) }} entrées</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="card p-6">
                    <h2 class="font-display font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Actions
                    </h2>

                    <div class="space-y-2">
                        <a href="{{ route('recus.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Retour à la liste
                        </a>

                        <a href="{{ route('recus.create') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-slate-900 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Nouveau reçu
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
