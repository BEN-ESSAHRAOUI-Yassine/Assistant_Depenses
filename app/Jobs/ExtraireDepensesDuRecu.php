<?php

namespace App\Jobs;

use App\Ai\Agents\ReceiptExtractor;
use App\Enums\StatutRecu;
use App\Models\Recu;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExtraireDepensesDuRecu implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Recu $recu
    ) {
    }

    public function handle(): void
    {
        try {

            $response = (new ReceiptExtractor)
                ->prompt($this->recu->texte_source);

            foreach ($response['articles'] as $article) {

                $this->recu->depenses()->create([
                    'libelle' => $article['libelle'],
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'categorie' => $article['categorie'],
                ]);
            }

            $this->recu->update([
                'statut' => StatutRecu::Traite,
                'payload_brut' => $response,
                'total_estime' => $response['total_estime'],
                'currency' => $response['currency'],
            ]);

        } catch (\Throwable $e) {

            $this->recu->update([
                'statut' => StatutRecu::Echoue,
            ]);

            report($e);
        }
    }
}