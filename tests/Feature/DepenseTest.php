<?php

use App\Enums\CategorieDepense;
use App\Models\Depense;
use App\Models\Recu;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('lists only expenses from the authenticated users receipts', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $recu = Recu::factory()->traite()->avecDepenses(3)->create(['user_id' => $user->id]);
    Recu::factory()->traite()->avecDepenses(2)->create(['user_id' => $otherUser->id]);

    actingAs($user);

    $response = get(route('depenses.index'));

    $response->assertOk();
    expect($response->viewData('depenses')->total())->toBe(3);
});

it('requires authentication', function () {
    get(route('depenses.index'))->assertRedirect(route('login'));
});

it('filters expenses by category', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->traite()->create(['user_id' => $user->id]);

    Depense::factory()->create([
        'recu_id' => $recu->id,
        'categorie' => CategorieDepense::Alimentaire,
    ]);
    Depense::factory()->create([
        'recu_id' => $recu->id,
        'categorie' => CategorieDepense::Boissons,
    ]);

    actingAs($user);

    $response = get(route('depenses.index', ['categorie' => 'alimentaire']));
    expect($response->viewData('depenses')->total())->toBe(1);
});

it('searches expenses by libelle', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->traite()->create(['user_id' => $user->id]);

    Depense::factory()->create(['recu_id' => $recu->id, 'libelle' => 'Pommes Golden']);
    Depense::factory()->create(['recu_id' => $recu->id, 'libelle' => 'Lait entier']);
    Depense::factory()->create(['recu_id' => $recu->id, 'libelle' => 'Pommes de terre']);

    actingAs($user);

    $response = get(route('depenses.index', ['search' => 'Pommes']));
    expect($response->viewData('depenses')->total())->toBe(2);
});

it('sorts expenses by column', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->traite()->create(['user_id' => $user->id]);

    Depense::factory()->create(['recu_id' => $recu->id, 'libelle' => 'B', 'prix_unitaire' => 10]);
    Depense::factory()->create(['recu_id' => $recu->id, 'libelle' => 'A', 'prix_unitaire' => 20]);

    actingAs($user);

    $response = get(route('depenses.index', ['sort' => 'libelle', 'direction' => 'asc']));

    $depenses = $response->viewData('depenses');
    expect($depenses->first()->libelle)->toBe('A');
});

it('paginates expenses', function () {
    $user = User::factory()->create();
    $recu = Recu::factory()->traite()->create(['user_id' => $user->id]);

    Depense::factory()->count(20)->create(['recu_id' => $recu->id]);

    actingAs($user);

    $response = get(route('depenses.index'));
    expect($response->viewData('depenses')->total())->toBe(20);
    expect($response->viewData('depenses')->perPage())->toBe(15);
});
