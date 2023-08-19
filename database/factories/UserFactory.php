<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Le nom du modèle correspondant à la factory.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'username' => $this->faker->unique()->userName,
            'role' => 'student', // exemple, vous pouvez ajuster selon vos besoins
            'password' => bcrypt('password'), // mot de passe par défaut
            'passwordinit' => 'password', // mot de passe init par défaut
        ];
    }
}
