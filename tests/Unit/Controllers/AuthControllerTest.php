<?php

namespace Tests\Unit\Controllers;

use App\Models\Specialty;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase {
    use RefreshDatabase, WithFaker;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }

    public function test_user_can_login_with_correct_credentials() {
        $password = 'password'; // Ou tout autre mot de passe de votre choix
        $user = User::factory()->create(['password' => bcrypt($password)]);

        $response = $this->postJson('/api/login', [
            'username' => $user->username,
            'password' => $password,
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user' => [
                        'id',
                        'nom',
                        'prenom',
                    ],
                ],
            ]);
    }

    public function test_user_cannot_login_with_incorrect_password() {
        $user = User::factory()->create([
            'password' => bcrypt('i-love-laravel'),
        ]);

        $response = $this->postJson('/api/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401); // Unauthorized
    }

    public function test_user_can_refresh_token() {
        // Créer un utilisateur de test
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        // Connexion pour obtenir un token initial
        $loginResponse = $this->postJson('/api/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        $loginResponse->assertStatus(200);
        $oldAccessToken = $loginResponse->json('data.access_token');

        // Utilisation du token initial pour rafraîchir et obtenir un nouveau token
        $refreshResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $oldAccessToken,
        ])->postJson('/api/refresh');
        // Vérification de la structure de la réponse
        $refreshResponse->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user', // Assurez-vous que ces clés correspondent à la réponse attendue
                ],
            ]);

        // Extraction du nouveau token
        $newAccessToken = $refreshResponse->json('data.access_token');

        // Vérification que le nouveau token est différent de l'ancien
        $this->assertNotEquals($oldAccessToken, $newAccessToken);
    }

}
