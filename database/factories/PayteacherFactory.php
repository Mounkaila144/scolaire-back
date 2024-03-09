<?php

namespace Database\Factories;

use App\Models\Payteacher;
use App\Models\Professeur;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayteacherFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Payteacher::class;

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
            'professeur_id' => Professeur::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
