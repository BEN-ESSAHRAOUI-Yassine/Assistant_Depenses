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

    public $tries = 3;

    public $maxExceptions = 1;

    public function backoff(): array
    {
        return [10, 30];
    }

    public function __construct(
        public Recu $recu
    ) {}

    public function handle(): void
    {
        try {

            $response = (new ReceiptExtractor)
                ->prompt($this->recu->texte_source);

            if (! is_array($response['articles'] ?? null)) {
                throw new \RuntimeException('La réponse de l\'IA ne contient pas une liste d\'articles valide.');
            }

            foreach ($response['articles'] as $article) {

                if (! is_array($article) || ! isset($article['libelle'], $article['quantite'], $article['prix_unitaire'], $article['categorie'])) {
                    continue;
                }

                $this->recu->depenses()->create([
                    'libelle' => $article['libelle'],
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'categorie' => $article['categorie'],
                ]);
            }

            $total = isset($response['total_estime']) && is_numeric($response['total_estime'])
                ? (float) $response['total_estime']
                : null;

            $this->recu->update([
                'statut' => StatutRecu::Traite,
                'payload_brut' => $response,
                'estimated_total' => $total,
                'currency' => $response['currency'] ?? 'MAD',
                'error_message' => null,
            ]);

        } catch (\Throwable $e) {

            $message = match (true) {
                str_contains($e->getMessage(), 'liste d\'articles') => $e->getMessage(),
                str_contains(get_class($e), 'ConnectionException') => 'L\'API Groq est temporairement indisponible. Réessai automatique...',
                default => 'L\'extraction a échoué : '.$e->getMessage(),
            };

            $this->recu->update([
                'statut' => StatutRecu::Echoue,
                'error_message' => $message,
            ]);

            report($e);
        }
    }
}
