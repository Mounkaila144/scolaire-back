<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Absence;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsenceFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Absence::class;

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
            'justifiee' => $this->faker->boolean,
            'matiere_id' => Matiere::factory(),
            'eleve_id' => Eleve::factory(),
            'schedule_id' => Schedule::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }
}
