<?php

namespace Database\Factories;

use App\Models\Eleve;
use App\Models\User;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

class EleveFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = Eleve::class;

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
            'passwordinit' => '444444444',
            'nationalite' => $this->faker->countryCode,
            'genre' => $this->faker->randomElement(['M', 'F']),
            'classe_id' => Classe::factory(),
            'user_id' => User::factory(),
        ];
    }
}
