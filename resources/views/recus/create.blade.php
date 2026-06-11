<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">

        <div class="mb-6">
            <a
                href="{{ route('recus.index') }}"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition"
            >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">
                Nouveau Reçu
            </h1>
            <p class="text-sm text-gray-500 mb-6">
                Collez le texte extrait de votre reçu (OCR) ci-dessous.
            </p>

            <form method="POST" action="{{ route('recus.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        Titre
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition"
                        placeholder="Ex: Courses Carrefour 10/06"
                    >
                    @error('title')
                        <p class="flex items-center gap-1 text-red-600 mt-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="estimated_total" class="block text-sm font-medium text-gray-700 mb-1">
                        Total estimé (MAD)
                    </label>
                    <input
                        type="number"
                        name="estimated_total"
                        id="estimated_total"
                        value="{{ old('estimated_total') }}"
                        step="0.01"
                        min="0"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition"
                        placeholder="0.00"
                    >
                    @error('estimated_total')
                        <p class="flex items-center gap-1 text-red-600 mt-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <textarea
                    name="texte_source"
                    rows="12"
                    class="w-full border border-gray-300 rounded-lg p-4 text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition"
                    placeholder="Collez ici le texte du reçu..."
                >{{ old('texte_source') }}</textarea>

                @error('texte_source')
                    <p class="flex items-center gap-1 text-red-600 mt-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <div class="flex items-center gap-3 mt-6">
                <button
                    type="submit"
                    class="inline-flex items-center px-8 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition shadow-sm"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer
                </button>

                    <a
                        href="{{ route('recus.index') }}"
                        class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>