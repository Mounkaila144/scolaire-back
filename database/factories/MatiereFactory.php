<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatiereFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Matiere::class;

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
            'nom' => $this->faker->name(), // Générer un nombre aléatoire pour le prix
            'coef' => 20, // Générer un nombre aléatoire pour le prix
            'classe_id' => Classe::factory(),
        ];
    }
}
