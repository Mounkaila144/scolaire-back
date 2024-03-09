<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Suplier;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Category;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();



        // Create 100 users
        for ($i = 0; $i < 100; $i++) {
            Suplier::create([
                'name' => $faker->company,
                'adresse' => $faker->address,
                'phone' => $faker->phoneNumber
            ]);
        }

        // Create 100 categories
        for ($i = 0; $i < 100; $i++) {
            Categorie::create([
                'name' => $faker->word
            ]);
        }
    }
}
