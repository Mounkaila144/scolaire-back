<?php

namespace Database\Factories;

use App\Models\Depense;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepenseFactory extends Factory
{
    protected $model = Depense::class;

    public function definition()
    {
        return [
            'details' => $this->faker->word,
            'prix' => $this->faker->numberBetween(100, 1000),
            'promotion_id' => Promotion::factory(),

        ];
    }
}

