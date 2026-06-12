<?php

use App\Enums\StatutRecu;
use App\Jobs\ExtraireDepensesDuRecu;
use App\Models\Recu;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(function () {
    Queue::fake();
});

it('lists only the authenticated user receipts', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Recu::factory()->count(3)->create(['user_id' => $user->id]);
    Recu::factory()->count(2)->create(['user_id' => $otherUser->id]);

    actingAs($user);

    $response = get(route('recus.index'));

    $response->assertOk();
    $response->assertViewHas('recus', function ($recus) {
        return $recus->count() === 3;
    });
});

it('requires authentication', function () {
    get(route('recus.index'))->assertRedirect(route('login'));
    get(route('recus.create'))->assertRedirect(route('login'));
    get(route('recus.show', Recu::factory()->create()))->assertRedirect(route('login'));
    post(route('recus.store'), [])->assertRedirect(route('login'));
});

it('renders the create form', function () {
    actingAs(User::factory()->create());

    get(route('recus.create'))->assertOk();
});

it('creates a receipt and dispatches the job', function () {
    $user = User::factory()->create();

    actingAs($user);

    post(route('recus.store'), [
        'title' => 'Courses Carrefour',
        'texte_source' => 'Lait 8.50 MAD x2 Pain 3.00 MAD',
    ])->assertRedirect();

    $recu = Recu::first();

    expect($recu)->not->toBeNull();
    expect($recu->title)->toBe('Courses Carrefour');
    expect($recu->statut)->toBe(StatutRecu::EnAttente);
    expect($recu->user_id)->toBe($user->id);

    Queue::assertPushed(ExtraireDepensesDuRecu::class, function ($job) use ($recu) {
        return $job->recu->id === $recu->id;
    });
});

it('validates receipt creation', function () {
    actingAs(User::factory()->create());

    post(route('recus.store'), [])
        ->assertSessionHasErrors(['title', 'texte_source']);

    post(route('recus.store'), [
        'title' => 'Test',
        'texte_source' => 'Short',
    ])->assertSessionHasErrors(['texte_source']);
});

it('shows own receipt', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->traite()->avecDepenses(2)->create(['user_id' => $user->id]);

    actingAs($user);

    get(route('recus.show', $recu))
        ->assertOk()
        ->assertSee($recu->title)
        ->assertSee($recu->depenses->first()->libelle);
});

it('denies access to another users receipt', function () {
    $recu = Recu::factory()->create();

    actingAs(User::factory()->create());

    get(route('recus.show', $recu))->assertForbidden();
});

it('deletes own receipt', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    delete(route('recus.destroy', $recu))
        ->assertRedirect(route('recus.index'));

    expect(Recu::find($recu->id))->toBeNull();
});

it('denies deletion of another users receipt', function () {
    $recu = Recu::factory()->create();

    actingAs(User::factory()->create());

    delete(route('recus.destroy', $recu))->assertForbidden();
});

it('cascades depenses on receipt deletion', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->traite()->avecDepenses(3)->create(['user_id' => $user->id]);

    actingAs($user);

    delete(route('recus.destroy', $recu));

    expect($recu->depenses()->count())->toBe(0);
});
