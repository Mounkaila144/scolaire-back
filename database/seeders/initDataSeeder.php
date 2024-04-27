<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class initDataSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $rolePermissions = config('auth.rolePermissions');

        foreach ($rolePermissions as $role => $perms) {
            $roleObject = Role::findOrCreate($role); //create role

            if (count($perms) > 0) {
                foreach ($perms as $perm) {
                    Permission::findOrCreate($perm); //Creat permission
                    $roleObject->givePermissionTo($perm);
                }
            }
        }

        Promotion::firstOrCreate([
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
        ]);

        $user = User::where('username', 'mounkaila144')->first();
        if (!$user) {
            $user = User::create([
                'nom' => 'Boubacar',
                'prenom' => 'Mounkaila',
                'username' => 'mounkaila144',
                'password' => bcrypt('90145781')
            ]);
            $user->assignRole('superadmin');
        }

    }
}
