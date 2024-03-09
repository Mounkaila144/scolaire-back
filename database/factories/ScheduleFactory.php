<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Schedule;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ScheduleFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'jour' => function () {
                $jours = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
                return $jours[rand(0, count($jours) - 1)];
            },
            'debut' => function () {
                return Carbon::now()->startOfDay();
            },
            'classe_id' => Classe::factory(),
            'matiere_id' => Matiere::factory(),
            'professeur_id' => Professeur::factory(),
            'promotion_id' => Promotion::factory(),
        ];
    }



}
