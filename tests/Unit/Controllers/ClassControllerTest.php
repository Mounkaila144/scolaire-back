<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\Classe;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ClassControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function testIndexReturnsDataInValidFormat()
    {
        $this->seed(initDataSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $response = $this->json('get', 'api/classes',[], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
    }


    /** @test */
    public function it_can_get_all_classes()
    {
        Classe::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $response = $this->getJson('/api/classes', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);

        $this->assertCount(1, Classe::all());
    }

    /** @test */

    public function it_can_show_classes()
    {
        $classe = Classe::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->json('get', "api/classes/{$classe->id}", ['Authorization' => "Bearer $token"])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Détails de la classe récupérés avec succès',
                'data' => [
                    'nom' => $classe->nom,
                    'prix' => $classe->prix,
                    'eleves_count' => 0,
                    // Ajoutez d'autres champs si nécessaire
                ]
            ]);
    }

    public function testShowForMissingClasse() {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->json('get', "api/classes/0", ['Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);

    }

    /** @test */
    public function it_can_create_a_class()
    {

        $promotion = Promotion::factory()->create();

        $data = [
            'nom' => 'Mathematics',
            'prix' => 200,
            // Add more data as needed
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('post', 'api/classes', $data, ['Authorization' => "Bearer $token"])
            ->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'nom', 'prix', 'created_at', 'updated_at'],
            ]);
        $this->assertDatabaseHas('classes', $data);
    }
    public function testStoreWithMissingData() {

        $payload = [
            'nom' => 'Mathematics'
//            'prix' => 200,
            //email address is missing
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->json('post', 'api/classes', $payload, ['Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function it_can_update_a_class()
    {
        $classe = Classe::factory()->create([
            'nom' => 'Mathematics',
            'prix' => 200,
        ]);

        $dataEdit = [
            'nom' => 'Science',
            'prix' => 250,
            // Add more dataEdit as needed
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->json('put', "api/classes/$classe->id", $dataEdit, ['Authorization' => "Bearer $token"])
            ->assertJson([
                'status' => 'success',
                'message' => 'Classe mise à jour avec succès',
                'data' => [
                    'nom' => $dataEdit['nom'],
                    'prix' => $dataEdit['prix']
                    // Ajoutez d'autres champs si nécessaire
                ]
            ])
            ->assertStatus(200);
    }
    public function testUpdateForMissingUser() {

        $payload = [
            'nom' => 'Science',
            'prix' => 250,
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->json('put', 'api/classes/0', $payload, ['Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_class()
    {
        $classeData = [
            "nom" => "6em",
            "prix" => 5000
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $classe = Classe::factory()->create($classeData);
        $this->json('delete', "api/classes/$classe->id",[], ['Authorization' => "Bearer $token"])
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('classes', $classeData);

    }
    public function testDestroyForMissingUser() {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $this->json('delete', 'api/classes/0',[], ['Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }
}
