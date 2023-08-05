<?php

namespace Tests\Feature;

use App\Models\Eleve;
use Database\Seeders\elevprofSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_authenticate_eleve()
    {
        // Exécuter le seeder pour créer les utilisateurs
        $this->seed(elevprofSeeder::class);

        // 1. Authentifier l'utilisateur admin en utilisant les informations d'identification fournies
        $credentials = [
            'username' => 'user5',
            'password' => 'secret'
        ];

        // 2. Vérifier que l'authentification réussit en utilisant la route de connexion
        $authResponse = $this->post('/api/login', $credentials);
        $authResponse->assertStatus(200);
        $id=$authResponse->json()["user"]["id"];
dump(Eleve::find($id));
        // 3. Vous pouvez utiuserliser assertJsonFragment pour vérifier que 'username' => 'user5' est présent dans la réponse JSON
        $authResponse->assertJsonFragment([
            'username' => 'user5',
        ]);

        // 4. Vous pouvez également ajouter d'autres assertions pour vérifier des informations supplémentaires sur l'utilisateur authentifié
    }

}
