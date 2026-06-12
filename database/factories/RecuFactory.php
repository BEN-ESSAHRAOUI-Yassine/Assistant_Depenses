<?php

namespace Database\Factories;

use App\Enums\StatutRecu;
use App\Models\Recu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recu>
 */
class RecuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'texte_source' => fake()->paragraph(3),
            'statut' => StatutRecu::EnAttente,
        ];
    }

    public function traite(): static
    {
        return $this->state(fn (array $attrs) => [
            'statut' => StatutRecu::Traite,
            'payload_brut' => ['articles' => [], 'total_estime' => 0, 'currency' => 'MAD'],
            'estimated_total' => fake()->randomFloat(2, 10, 500),
            'currency' => 'MAD',
        ]);
    }

    public function echoue(): static
    {
        return $this->state(fn (array $attrs) => [
            'statut' => StatutRecu::Echoue,
        ]);
    }

    public function avecDepenses(int $count = 3): static
    {
        return $this->afterCreating(fn (Recu $recu) => DepenseFactory::new()->count($count)->create([
            'recu_id' => $recu->id,
        ]));
    }
}
