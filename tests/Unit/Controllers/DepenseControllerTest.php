<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Depense;
use App\Models\Scolarite;
use App\Models\Payteacher;
class DepenseControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_depenses()
    {
      $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('post', 'api/depenses', $data);
        $response = $this->json('get', 'api/depenses')
            ->assertStatus(200)
        ->assertJsonCount(1);
    }

    /** @test */
    public function test_it_can_show_and_store_depenses()
    {
         $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('post', 'api/depenses', $data);
        $depense = $response->json();
        // Récupérer l'utilisateur créé dans la réponse
        // Vérifier si les détails de l'utilisateur peuvent être récupérés via l'API
        $this->json('get', "api/depenses/{$depense['id']}")
            ->assertStatus(200)
            ->assertJson([
                'details' => "details",
                'prix' => 500,
                'promotion_id' =>$promotion->id,
                // Ajouter d'autres champs que vous souhaitez vérifier
            ]);
    }

    public function testShowForMissingPromotion()
    {

        $this->json('get', "api/depenses/0")
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
        $this->json('post', 'api/depenses', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_it_can_update_a_depense()
    {
        $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('post', 'api/depenses', $data);

        $depense = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
                'details' => 'details'
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/depenses/{$depense['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
        $updatedPromotionResponse = $this->json('get', "api/depenses/{$depense['id']}")
            ->assertStatus(200)
            ->assertJson([
                'details' => 'details'
                // Ajoutez d'autres champs que vous avez modifiés
            ]);
    }

    public function testUpdateForMissingPromotion()
    {

        $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];


        // Enregistrer l'utilisateur et récupérer la réponse JSON
       $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('put', 'api/depenses/0', $data)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_depense()
    {
         $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('post', 'api/depenses', $data);

        $depense = $response->json();
        $this->json('delete', "api/depenses/{$depense['id']}")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('depenses', $data);

    }

    public function testDestroyForMissingPromotion()
    {

        $this->json('delete', 'api/depenses/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_belongs_to_a_promotion()
    {
        // Créez une dépense et une promotion
        $promotion = Promotion::factory()->create();
        $depense = Depense::factory()->create(['promotion_id' => $promotion->id]);
        // Assurez-vous que la relation promotion fonctionne
        $this->assertInstanceOf(Promotion::class, $depense->promotion);
        $this->assertEquals($promotion->id, $depense->promotion->id);
    }

}
