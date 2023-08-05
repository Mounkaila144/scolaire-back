<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Eleve;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all category IDs
        $categoryIds = Categorie::pluck('id')->all();

        // Create 100 products
        for ($i = 0; $i < 3; $i++) {
            Eleve::create([
                'name' => $faker->word,
                'picture' => $faker->imageUrl(),
                'price' => $faker->numberBetween(100, 1000),
                'categorie' => $faker->randomElement($categoryIds),
                'suplier' => $faker->numberBetween(1, 100),
                'stock' => $faker->numberBetween(10, 100),
                'alert' => $faker->numberBetween(10, 30),
                'vendue' => 0
            ]);
        }
    }
}
