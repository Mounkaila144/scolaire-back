<?php

namespace Database\Seeders;

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
        $admin_role = Role::create(['name' => 'admin']);
        $user_role = Role::create(['name' => 'user']);
        $permission = Permission::create(['name' => 'delect']);
        $data = [
            'nom' => 'Boubacar',
            'role' => 'admin',
            'prenom' => 'Mounkaila',
            'username' => 'mounkaila144',
            'password' => bcrypt('secret')
        ];
        $dataeleve = [

            'nom' => 'Boubacar',
            'role' => 'eleve',
            'prenom' => 'latifa',
            'username' => 'latifa144',
            'password' => bcrypt('secret')
        ];
        $dataprof = [
            'nom' => 'Jibril',
            'role' => 'prof',
            'prenom' => 'maarif',
            'username' => 'jibril144',
            'password' => bcrypt('secret')
        ];
        $admin_role->givePermissionTo($permission);
        $admin=User::create($data);
        $eleve=User::create($dataeleve);
        $prof=User::create($dataprof);
        $admin->assignRole($admin_role);
        $prof->assignRole($user_role);
        $eleve->assignRole($user_role);
    }
}
