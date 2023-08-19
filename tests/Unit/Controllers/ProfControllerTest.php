<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Depense;
use App\Models\Scolarite;
use App\Models\Payteacher;
class ProfControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_professeurs()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
        ];


        $this->json('post', 'api/professeurs', $data);
      $this->json('get', 'api/professeurs')
            ->assertStatus(200)
        ->assertJsonCount(1);
    }

    /** @test */
    public function test_it_can_show_and_store_professeurs()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/professeurs', $data);
        $prof = $response->json();
        // Récupérer l'utilisateur créé dans la réponse
        // Vérifier si les détails de l'utilisateur peuvent être récupérés via l'API
        $this->json('get', "api/professeurs/{$prof['id']}")
            ->assertStatus(200)
            ->assertJson([
                'number' => '12345',
                'adresse' => '123 Street',
                'birth' => '2000-01-01',
                'nationalite' => 'FR',
                'genre' => 'M',
            ]);
    }

    public function testShowForMissingPromotion()
    {

        $this->json('get', "api/professeurs/0")
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
        $this->json('post', 'api/professeurs', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_it_can_update_a_prof()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/professeurs', $data);

        $prof = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
                'adresse' => 'edit'
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/professeurs/{$prof['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
       $this->json('get', "api/professeurs/{$prof['id']}")
            ->assertStatus(200)
            ->assertJson([
                'adresse' => 'edit'
                // Ajoutez d'autres champs que vous avez modifiés
            ]);
    }

    public function testUpdateForMissingPromotion()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
        ];


        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $this->json('put', 'api/professeurs/0', $data)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_prof()
    {
        $promotion = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/professeurs', $data);

        $prof = $response->json();

        $this->json('delete', "api/professeurs/{$prof['id']}")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('professeurs', $data);

    }

    public function testDestroyForMissingPromotion()
    {

        $this->json('delete', 'api/professeurs/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    }

