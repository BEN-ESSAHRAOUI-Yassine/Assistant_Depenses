<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('recus.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <div class="card p-8">
            <div class="mb-8">
                <h1 class="text-2xl font-display font-bold text-slate-900">Nouveau Reçu</h1>
                <p class="text-sm text-slate-500 mt-1">Collez le texte extrait de votre reçu (OCR) et laissez l'IA faire le reste.</p>
            </div>

            <form method="POST" action="{{ route('recus.store') }}">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="label">Titre</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title') }}"
                            class="input-field"
                            placeholder="Ex: Courses Carrefour 10/06"
                        >
                        @error('title')
                            <x-input-error :messages="$messages" />
                        @enderror
                    </div>

                    <div>
                        <label for="estimated_total" class="label">Total estimé (MAD)</label>
                        <input
                            type="number"
                            name="estimated_total"
                            id="estimated_total"
                            value="{{ old('estimated_total') }}"
                            step="0.01"
                            min="0"
                            class="input-field"
                            placeholder="0.00"
                        >
                        @error('estimated_total')
                            <x-input-error :messages="$messages" />
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="texte_source" class="label">Texte du reçu</label>
                    <textarea
                        name="texte_source"
                        id="texte_source"
                        rows="14"
                        class="input-field font-mono text-xs leading-relaxed"
                        placeholder="Collez ici le texte complet de votre reçu..."
                    >{{ old('texte_source') }}</textarea>
                    @error('texte_source')
                        <x-input-error :messages="$messages" />
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer
                    </button>
                    <a href="{{ route('recus.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
