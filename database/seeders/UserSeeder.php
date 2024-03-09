<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Promotion::create([
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
        ]);
        $admin_role = Role::create(['name' => 'superadmin']);
        $data = [
            'nom' => 'Boubacar',
            'prenom' => 'Mounkaila',
            'username' => 'mounkaila144',
            'password' => bcrypt('90145781')
        ];
        $admin=User::create($data);

        $admin->assignRole($admin_role);

    }
}
