<?php

namespace Database\Factories;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseFactory extends Factory
{
    protected $model = Classe::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'prix' => $this->faker->numberBetween(100, 1000),
        ];
    }
}

