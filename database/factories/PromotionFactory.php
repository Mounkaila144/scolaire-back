<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition()
    {
        return [
            'debut' => now()->year, // Utilisez l'année actuelle ou toute autre logique que vous préférez
            'fin' => now()->addYear()->year, // Utilisez l'année actuelle + 1 ou toute autre logique que vous préférez
        ];
    }
}

