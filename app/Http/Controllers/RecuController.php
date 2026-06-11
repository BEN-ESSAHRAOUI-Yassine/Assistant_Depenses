<?php

namespace App\Http\Controllers;

use App\Enums\StatutRecu;
use App\Http\Requests\StoreRecuRequest;
use App\Models\Recu;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecuController extends Controller
{
    public function index(): View
    {
        $recus = auth()
            ->user()
            ->recus()
            ->withCount('depenses')
            ->latest()
            ->get();

        return view('recus.index', compact('recus'));
    }

    public function create(): View
    {
        return view('recus.create');
    }

    public function store(StoreRecuRequest $request): RedirectResponse
    {
        auth()->user()->recus()->create([
            'title' => $request->validated('title'),
            'texte_source' => $request->validated('texte_source'),
            'estimated_total' => $request->validated('estimated_total') ?? 0,
            'statut' => StatutRecu::EnAttente,
        ]);

        return redirect()
            ->route('recus.index')
            ->with('success', 'Reçu créé avec succès.');
    }

    public function show(Recu $recu): View
    {
        $this->authorize('view', $recu);

        $recu->load('depenses');

        return view('recus.show', compact('recu'));
    }

    public function destroy(Recu $recu): RedirectResponse
    {
        $this->authorize('delete', $recu);

        $recu->delete();

        return redirect()
            ->route('recus.index')
            ->with('success', 'Reçu supprimé.');
    }
}
