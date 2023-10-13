<?php

namespace Database\Factories;

use App\Models\Payadmin;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayadminFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Payadmin::class;

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
            'user_id' => User::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
