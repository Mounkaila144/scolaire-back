<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseFactory extends Factory
{
    protected $model = Classe::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'prix' => 100000,
            'promotion_id' => Promotion::factory(),
        ];
    }
}

