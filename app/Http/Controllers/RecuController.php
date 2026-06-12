<?php

namespace App\Http\Controllers;

use App\Enums\StatutRecu;
use App\Http\Requests\StoreRecuRequest;
use App\Jobs\ExtraireDepensesDuRecu;
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
        $recu = auth()->user()->recus()->create([
            'title' => $request->validated('title'),
            'texte_source' => $request->validated('texte_source'),
            'statut' => StatutRecu::EnAttente,
            'estimated_total' => $request->validated('estimated_total'),
            'currency' => 'MAD',
        ]);

        ExtraireDepensesDuRecu::dispatch($recu);

        return redirect()
            ->route('recus.show', $recu)
            ->with('success', 'Extraction terminée.');
    }

    public function show(Recu $recu): View
    {
        $this->authorize('view', $recu);

        $recu->load('depenses');

        return view('recus.show', compact('recu'));
    }

    public function retry(Recu $recu): RedirectResponse
    {
        $this->authorize('retry', $recu);

        if ($recu->statut !== StatutRecu::Echoue) {
            return redirect()->route('recus.show', $recu)
                ->with('error', 'Seuls les reçus échoués peuvent être relancés.');
        }

        $recu->depenses()->delete();
        $recu->update([
            'statut' => StatutRecu::EnAttente,
            'payload_brut' => null,
            'estimated_total' => null,
            'currency' => null,
            'error_message' => null,
        ]);

        ExtraireDepensesDuRecu::dispatch($recu);

        return redirect()->route('recus.show', $recu)
            ->with('success', 'Extraction relancée.');
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
