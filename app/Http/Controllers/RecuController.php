<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ReceiptExtractor;
use App\Enums\StatutRecu;
use App\Http\Requests\StoreRecuRequest;
use App\Models\Recu;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Jobs\ExtraireDepensesDuRecu;

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
        ]);

        // try {

        //     $response = (new ReceiptExtractor)
        //         ->prompt($recu->texte_source);

        //     foreach ($response['articles'] as $article) {

        //         $recu->depenses()->create([
        //             'libelle' => $article['libelle'],
        //             'quantite' => $article['quantite'],
        //             'prix_unitaire' => $article['prix_unitaire'],
        //             'categorie' => $article['categorie'],
        //         ]);
        //     }

        //     $recu->update([
        //         'statut' => StatutRecu::Traite,
        //         'payload_brut' => $response,
        //         'total_estime' => $response['total_estime'],
        //         'currency' => $response['currency'],
        //     ]);

        // } catch (\Throwable $e) {

        //     $recu->update([
        //         'statut' => StatutRecu::Echoue,
        //     ]);

        //     report($e);
        // }
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

    public function destroy(Recu $recu): RedirectResponse
    {
        $this->authorize('delete', $recu);

        $recu->delete();

        return redirect()
            ->route('recus.index')
            ->with('success', 'Reçu supprimé.');
    }
}