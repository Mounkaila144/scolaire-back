<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Ecole;
use Illuminate\Database\Eloquent\Factories\Factory;

class EcoleFactory extends Factory
{
    protected $model = Ecole::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'description' => $this->faker->word,
            'numero1' => $this->faker->phoneNumber,
            'numero2' => $this->faker->phoneNumber,
            'adresse' => $this->faker->address,
        ];
    }
}

