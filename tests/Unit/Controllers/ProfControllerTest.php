<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Depense;
use App\Models\Scolarite;
use App\Models\Payteacher;
class ProfControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    /** @test */
    public function it_can_get_all_professeurs()
    {
        $promotion = Promotion::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M'
        ];


        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        // Perform the request
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('POST', 'api/professeurs', $data);

        $this->json('get', 'api/professeurs')
            ->assertStatus(200);
    }

    /** @test */
    public function test_it_can_store_professeurs()
    {
        $promotion = Promotion::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M'
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        // Perform the request
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('POST', 'api/professeurs', $data);

        $prof = $response->json();

        // Vérification de l'élève avec un en-tête X-Promotion
        $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('GET', "api/professeurs/{$prof['data']['id']}")
            ->assertStatus(200);
    }

    public function testShowForMissingPromotion()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);


        $this->json('get', "api/professeurs/0",[], ['Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);

    }

    /** @test */
    public function testStoreWithMissingData()
    {

        $payload = [
            'adresse' => 'Mathematics'
//            'prix' => 200,
            //email address is missing
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $this->json('post', 'api/professeurs', $payload,[ 'Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function test_it_can_update_a_prof()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prix' => 50000,
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
        ];

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        // Perform the request
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('POST', 'api/professeurs', $data);


        $prof = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
            'adresse' => 'edit'
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/professeurs/{$prof['data']['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
        $this->json('get', "api/professeurs/{$prof['data']['id']}")
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Success',
                'data' => [
                    'adresse' => 'edit']
            ]);
    }

    public function testUpdateForMissingPromotion()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prix' => 50000,
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
            'classe_id' => $classe->id, // Remplacez par l'ID de la classe appropriée
            'promotion_id' => $promotion->id,
        ];

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);



        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $this->json('put', 'api/professeurs/0', $data,[ 'Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_can_delete_a_prof()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prix' => 50000,
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M'
        ];
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        // Perform the request
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('POST', 'api/professeurs', $data);


        $prof = $response->json();

        $this->json('delete', "api/professeurs/{$prof['data']['id']}")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('professeurs', $data);

    }

    public function testDestroyForMissingPromotion()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);


        $this->json('delete', 'api/professeurs/0', ['Authorization' => "Bearer $token"])
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }


}
