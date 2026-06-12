<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-display font-bold text-slate-900">Dépenses</h1>
                <p class="text-sm text-slate-500 mt-1">{{ $depenses->total() }} dépense(s) au total</p>
            </div>
            <a href="{{ route('recus.create') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau reçu
            </a>
        </div>

        <div class="card overflow-hidden">

            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                <form method="GET" action="{{ route('depenses.index') }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label for="search" class="text-xs font-semibold text-slate-600 mb-1 block">Rechercher</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Libellé..."
                               class="input-field !w-48">
                    </div>
                    <div>
                        <label for="categorie" class="text-xs font-semibold text-slate-600 mb-1 block">Catégorie</label>
                        <select name="categorie" id="categorie" class="input-field !w-auto">
                            <option value="">Toutes</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->value }}" @selected(request('categorie') === $cat->value)>
                                    {{ $cat->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary !py-2">
                        Filtrer
                    </button>
                    @if(request()->anyFilled(['search', 'categorie', 'sort', 'direction']))
                        <a href="{{ route('depenses.index') }}" class="btn-secondary !py-2">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            @php
                                $sortCols = [
                                    'libelle' => 'Libellé',
                                    'quantite' => 'Qté',
                                    'prix_unitaire' => 'Prix unitaire',
                                    'categorie' => 'Catégorie',
                                ];
                            @endphp
                            @foreach($sortCols as $col => $label)
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <a href="{{ route('depenses.index', array_merge(request()->query(), ['sort' => $col, 'direction' => request('sort') === $col && request('direction') !== 'asc' ? 'asc' : 'desc'])) }}"
                                       class="flex items-center gap-1 hover:text-slate-900 transition-colors">
                                        {{ $label }}
                                        @if(request('sort') === $col)
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                            @endforeach
                            <th class="text-right px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reçu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($depenses as $depense)
                            @php
                                $categorieClasses = [
                                    'alimentaire' => 'bg-orange-50 text-orange-700',
                                    'boissons' => 'bg-sky-50 text-sky-700',
                                    'hygiene' => 'bg-purple-50 text-purple-700',
                                    'entretien' => 'bg-teal-50 text-teal-700',
                                    'autre' => 'bg-slate-100 text-slate-600',
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 font-semibold text-slate-900">{{ $depense->libelle }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $depense->quantite }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ number_format($depense->prix_unitaire, 2) }} MAD</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-900">{{ number_format($depense->quantite * $depense->prix_unitaire, 2) }} MAD</td>
                                <td class="px-4 py-3">
                                    <span class="badge {{ $categorieClasses[$depense->categorie->value] ?? 'badge-neutral' }}">
                                        {{ $depense->categorie->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('recus.show', $depense->recu) }}" class="text-slate-500 hover:text-primary-700 hover:underline transition-colors">
                                        {{ $depense->recu->title }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500">Aucune dépense trouvée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($depenses->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $depenses->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
