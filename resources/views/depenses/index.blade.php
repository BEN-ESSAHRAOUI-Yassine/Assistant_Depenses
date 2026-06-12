<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dépenses</h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $depenses->total() }} dépense(s) au total
                </p>
            </div>
            <a href="{{ route('recus.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition">
                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau reçu
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <form method="GET" action="{{ route('depenses.index') }}" class="flex flex-wrap gap-3 items-end">
                    <div>
                        <label for="search" class="block text-xs font-medium text-gray-600 mb-1">Rechercher</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Libellé..."
                               class="w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                    </div>
                    <div>
                        <label for="categorie" class="block text-xs font-medium text-gray-600 mb-1">Catégorie</label>
                        <select name="categorie" id="categorie"
                                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900">
                            <option value="">Toutes</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->value }}" @selected(request('categorie') === $cat->value)>
                                    {{ $cat->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                            class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition">
                        Filtrer
                    </button>
                    @if(request()->anyFilled(['search', 'categorie', 'sort', 'direction']))
                        <a href="{{ route('depenses.index') }}"
                           class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">
                                <a href="{{ route('depenses.index', array_merge(request()->query(), ['sort' => 'libelle', 'direction' => request('sort') === 'libelle' && request('direction') !== 'asc' ? 'asc' : 'desc'])) }}"
                                   class="flex items-center gap-1 hover:text-gray-900">
                                    Libellé
                                    @if(request('sort') === 'libelle')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">
                                <a href="{{ route('depenses.index', array_merge(request()->query(), ['sort' => 'quantite', 'direction' => request('sort') === 'quantite' && request('direction') !== 'asc' ? 'asc' : 'desc'])) }}"
                                   class="flex items-center gap-1 hover:text-gray-900">
                                    Qté
                                    @if(request('sort') === 'quantite')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">
                                <a href="{{ route('depenses.index', array_merge(request()->query(), ['sort' => 'prix_unitaire', 'direction' => request('sort') === 'prix_unitaire' && request('direction') !== 'asc' ? 'asc' : 'desc'])) }}"
                                   class="flex items-center gap-1 hover:text-gray-900">
                                    Prix unitaire
                                    @if(request('sort') === 'prix_unitaire')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="text-right px-4 py-3 font-medium text-gray-600">Total</th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">
                                <a href="{{ route('depenses.index', array_merge(request()->query(), ['sort' => 'categorie', 'direction' => request('sort') === 'categorie' && request('direction') !== 'asc' ? 'asc' : 'desc'])) }}"
                                   class="flex items-center gap-1 hover:text-gray-900">
                                    Catégorie
                                    @if(request('sort') === 'categorie')
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="text-left px-4 py-3 font-medium text-gray-600">Reçu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($depenses as $depense)
                            @php
                                $categorieClasses = [
                                    'alimentaire' => 'bg-orange-100 text-orange-700',
                                    'boissons' => 'bg-blue-100 text-blue-700',
                                    'hygiene' => 'bg-purple-100 text-purple-700',
                                    'entretien' => 'bg-teal-100 text-teal-700',
                                    'autre' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $depense->libelle }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $depense->quantite }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ number_format($depense->prix_unitaire, 2) }} MAD</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">{{ number_format($depense->quantite * $depense->prix_unitaire, 2) }} MAD</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $categorieClasses[$depense->categorie->value] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $depense->categorie->label() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    <a href="{{ route('recus.show', $depense->recu) }}" class="hover:text-gray-900 hover:underline">
                                        {{ $depense->recu->title }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-sm">Aucune dépense trouvée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($depenses->hasPages())
                <div class="p-4 border-t border-gray-200">
                    {{ $depenses->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
