<?php

use App\Ai\Agents\ReceiptExtractor;
use App\Enums\StatutRecu;
use App\Jobs\ExtraireDepensesDuRecu;
use App\Models\Recu;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Queue\Queueable;

use function Pest\Laravel\assertDatabaseHas;

it('creates expenses from AI response on success', function () {
    ReceiptExtractor::fake([
        [
            'articles' => [
                ['libelle' => 'Lait', 'quantite' => 2, 'prix_unitaire' => 8.50, 'categorie' => 'boissons'],
                ['libelle' => 'Pain', 'quantite' => 1, 'prix_unitaire' => 3.00, 'categorie' => 'alimentaire'],
            ],
            'total_estime' => 20.00,
            'currency' => 'MAD',
        ],
    ]);

    $user = User::factory()->create();
    $recu = Recu::factory()->create(['user_id' => $user->id]);

    $job = new ExtraireDepensesDuRecu($recu);
    $job->handle();

    $recu->refresh();

    expect($recu->statut)->toBe(StatutRecu::Traite);
    expect($recu->depenses()->count())->toBe(2);
    expect((float) $recu->estimated_total)->toBe(20.0);
    expect($recu->currency)->toBe('MAD');
    expect($recu->error_message)->toBeNull();

    assertDatabaseHas('depenses', [
        'recu_id' => $recu->id,
        'libelle' => 'Lait',
        'categorie' => 'boissons',
    ]);
});

it('sets status to echoue on failure and stores error', function () {
    ReceiptExtractor::fake([
        function () {
            throw new Exception('API error');
        },
    ]);

    $user = User::factory()->create();
    $recu = Recu::factory()->create(['user_id' => $user->id]);

    $job = new ExtraireDepensesDuRecu($recu);
    $job->handle();

    $recu->refresh();

    expect($recu->statut)->toBe(StatutRecu::Echoue);
    expect($recu->depenses()->count())->toBe(0);
    expect($recu->error_message)->not->toBeNull();
    expect($recu->error_message)->toContain('API error');
});

it('handles empty articles array', function () {
    ReceiptExtractor::fake([
        [
            'articles' => [],
            'total_estime' => 0,
            'currency' => 'MAD',
        ],
    ]);

    $user = User::factory()->create();
    $recu = Recu::factory()->create([
        'user_id' => $user->id,
        'texte_source' => 'Not a receipt',
    ]);

    $job = new ExtraireDepensesDuRecu($recu);
    $job->handle();

    $recu->refresh();

    expect($recu->statut)->toBe(StatutRecu::Traite);
    expect($recu->depenses()->count())->toBe(0);
    expect($recu->error_message)->toBeNull();
});

it('handles malformed articles gracefully and stores error', function () {
    ReceiptExtractor::fake([
        [
            'articles' => null,
            'total_estime' => 100,
            'currency' => 'MAD',
        ],
    ]);

    $user = User::factory()->create();
    $recu = Recu::factory()->create(['user_id' => $user->id]);

    $job = new ExtraireDepensesDuRecu($recu);
    $job->handle();

    $recu->refresh();

    expect($recu->statut)->toBe(StatutRecu::Echoue);
    expect($recu->depenses()->count())->toBe(0);
    expect($recu->error_message)->toContain('liste d\'articles');
});

it('handles missing total_estime', function () {
    ReceiptExtractor::fake([
        [
            'articles' => [
                ['libelle' => 'Pain', 'quantite' => 1, 'prix_unitaire' => 3.00, 'categorie' => 'alimentaire'],
            ],
            'currency' => 'MAD',
        ],
    ]);

    $user = User::factory()->create();
    $recu = Recu::factory()->create(['user_id' => $user->id]);

    $job = new ExtraireDepensesDuRecu($recu);
    $job->handle();

    $recu->refresh();

    expect($recu->statut)->toBe(StatutRecu::Traite);
    expect($recu->estimated_total)->toBeNull();
    expect($recu->error_message)->toBeNull();
});

it('has retry and backoff configuration', function () {
    $job = new ExtraireDepensesDuRecu(new Recu);

    expect($job->tries)->toBe(3);
    expect($job->maxExceptions)->toBe(1);
    expect($job->backoff())->toBe([10, 30]);
});

it('does not implement ShouldBeUnique', function () {
    $job = new ExtraireDepensesDuRecu(new Recu);

    expect($job)->not->toBeInstanceOf(ShouldBeUnique::class);
    expect(class_uses_recursive($job))->toContain(Queueable::class);
});

it('clears error_message on successful extraction', function () {
    ReceiptExtractor::fake([
        [
            'articles' => [
                ['libelle' => 'Lait', 'quantite' => 2, 'prix_unitaire' => 8.50, 'categorie' => 'boissons'],
            ],
            'total_estime' => 17.00,
            'currency' => 'MAD',
        ],
    ]);

    $user = User::factory()->create();
    $recu = Recu::factory()->create([
        'user_id' => $user->id,
        'error_message' => 'Previous failure',
    ]);

    expect($recu->error_message)->toBe('Previous failure');

    $job = new ExtraireDepensesDuRecu($recu);
    $job->handle();

    $recu->refresh();

    expect($recu->statut)->toBe(StatutRecu::Traite);
    expect($recu->error_message)->toBeNull();
});
