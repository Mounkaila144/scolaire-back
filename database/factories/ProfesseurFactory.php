<?php

namespace Database\Factories;

use App\Models\Eleve;
use App\Models\Professeur;
use App\Models\User;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesseurFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Professeur::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        // Notez que nous utilisons des liaisons directes pour user_id et classe_id.
        // Vous devez donc avoir des éléments existants dans les tables User et Classe pour que cela fonctionne correctement.
        return [
            'number' => $this->faker->unique()->randomNumber(5),
            'adresse' => $this->faker->address,
            'birth' => $this->faker->date(),
            'nationalite' => $this->faker->countryCode,
            'genre' => $this->faker->randomElement(['M', 'F']),
            'user_id' => User::factory(),
        ];
    }
}
