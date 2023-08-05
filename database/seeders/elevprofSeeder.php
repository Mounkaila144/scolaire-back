<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Eleve;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class elevprofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create 10 users and assign role 'eleve' to them
        User::create([
            'prenom' => 'Prénom 1',
            'nom' => 'Nom 1',
            'username' => 'user1',
            'password' => bcrypt('secret'),
            'role' => 'eleve',
        ]);

        User::create([
            'prenom' => 'Prénom 2',
            'nom' => 'Nom 2',
            'username' => 'user2',
            'password' => bcrypt('secret'),
            'role' => 'eleve',
        ]);

        User::create([
            'prenom' => 'Prénom 3',
            'nom' => 'Nom 3',
            'username' => 'user3',
            'password' => bcrypt('secret'),
            'role' => 'eleve',
        ]);

        User::create([
            'prenom' => 'Prénom 4',
            'nom' => 'Nom 4',
            'username' => 'user4',
            'password' => bcrypt('secret'),
            'role' => 'eleve',
        ]);

        User::create([
            'prenom' => 'Prénom 5',
            'nom' => 'Nom 5',
            'username' => 'user5',
            'password' => bcrypt('secret'),
            'role' => 'eleve',
        ]);


        // Create 10 eleves and associate each eleve with an existing user
        $users = User::where('role', 'eleve')->get();
        foreach ($users as $user) {
            Eleve::create([
                'number' => $faker->phoneNumber(),
                'adresse' => $faker->address(),
                'birth' => $faker->dateTime(),
                'user_id' => $user->id,
                'nationalite' => $faker->country,
                'genre' => $faker->randomElement(['M', 'F']), // You can use randomElement to get a random value from the array
            ]);
        }
    }
}
