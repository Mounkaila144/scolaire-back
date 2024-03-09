<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluationFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Evaluation::class;

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
            'sur' => $this->faker->name(), // Générer un nombre aléatoire pour le prix
            'type' => 'devoir', // Générer un nombre aléatoire pour le prix
            'note' => 15, // Générer un nombre aléatoire pour le prix
            'matiere_id' => Matiere::factory(),
            'eleve_id' => Eleve::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
