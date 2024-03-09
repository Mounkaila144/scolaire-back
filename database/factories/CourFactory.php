<?php

namespace Database\Factories;

use App\Models\Cour;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Cour::class;

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

            'schedule_id' => Schedule::factory(),
            'professeur_id' => Professeur::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
