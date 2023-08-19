<?php

namespace Database\Factories;

use App\Models\Scolarite;
use App\Models\Eleve;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScolariteFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Scolarite::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        // Notez que nous utilisons des liaisons directes pour eleve_id et promotion_id.
        // Vous devez donc avoir des éléments existants dans les tables Eleve et Promotion pour que cela fonctionne correctement.
        return [
            'prix' => $this->faker->randomNumber(5), // Générer un nombre aléatoire pour le prix
            'eleve_id' => Eleve::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
