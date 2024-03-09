<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_can_get_all_users()
    {
        $data = [
            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName(),
            'role' => "admin"
        ];
        $this->json('post', 'api/users', $data);
        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
        $this->assertCount(1, User::all());
    }

    /** @test */

    public function testShowForMissingUser()
    {

        $this->json('get', "api/users/0")
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);

    }

    /** @test */
    public function testStoreWithMissingData()
    {

        $payload = [
            'nom' => 'Mathematics'
//            'prix' => 200,
            //email address is missing
        ];
        $this->json('post', 'api/users', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_it_can_update_a_user()
    {
        $data = [
            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName(),
            'role' => "admin"
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/users', $data);

        $user = $response->json('user'); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
            'nom' => 'bbc',
            'prenom' => 'mkl',
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/users/{$user['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
        $updatedUserResponse = $this->json('get', "api/users/{$user['id']}")
            ->assertStatus(200)
            ->assertJson([
                'nom' => $dataEdit['nom'],
                'prenom' => $dataEdit['prenom'],
                // Ajoutez d'autres champs que vous avez modifiés
            ]);
    }

    public function testUpdateForMissingUser()
    {

        $payload = [
            'nom' => 'Science',
            'prix' => 250,
        ];

        $this->json('put', 'api/users/0', $payload)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $data = [
            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName(),
            'role' => "admin"
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/users', $data);

        $user = $response->json('user');
        $this->json('delete', "api/users/{$user['id']}")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('users', $data);

    }

    public function testDestroyForMissingUser()
    {

        $this->json('delete', 'api/users/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }
}
