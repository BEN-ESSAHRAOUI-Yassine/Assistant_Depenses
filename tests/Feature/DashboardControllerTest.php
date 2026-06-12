<?php

use App\Enums\StatutRecu;
use App\Models\Recu;
use App\Models\User;

it('redirects guests to login', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

it('loads the dashboard for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Tableau de bord');
});

it('shows zero state for new users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Bienvenue sur votre espace');
    $response->assertSee('Nouveau reçu');
});

it('displays correct stats', function () {
    $user = User::factory()->create();

    Recu::factory()->count(3)->create([
        'user_id' => $user->id,
        'statut' => StatutRecu::Traite,
        'estimated_total' => 100,
    ]);

    Recu::factory()->count(2)->create([
        'user_id' => $user->id,
        'statut' => StatutRecu::EnAttente,
    ]);

    Recu::factory()->create([
        'user_id' => $user->id,
        'statut' => StatutRecu::Echoue,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('6'); // total recus
    $response->assertSee('3'); // traite
    $response->assertSee('2'); // en attente
    $response->assertSee('1'); // echoue
    $response->assertSee('300'); // total estime (3 * 100)
});

it('shows only 5 most recent receipts', function () {
    $user = User::factory()->create();

    $old = Recu::factory()->create([
        'user_id' => $user->id,
        'statut' => StatutRecu::Traite,
        'created_at' => now()->subDay(),
        'title' => 'OLD_RECEIPT',
    ]);

    Recu::factory()->count(5)->create([
        'user_id' => $user->id,
        'statut' => StatutRecu::Traite,
        'created_at' => now(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertDontSee('OLD_RECEIPT');
});

it('isolates data between users', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    Recu::factory()->count(5)->create(['user_id' => $user1->id]);
    Recu::factory()->count(3)->create(['user_id' => $user2->id]);

    $response = $this->actingAs($user2)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('3'); // user2 has 3 recus
});
