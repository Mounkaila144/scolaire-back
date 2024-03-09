<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Texte;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TexteFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Texte::class;

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

            'texte' => "texte du prof", // Générer un nombre aléatoire pour le prix
            'matiere_id' => Matiere::factory(),
            'professeur_id' => Professeur::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
