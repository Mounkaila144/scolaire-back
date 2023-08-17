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
class PromotionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_promotions()
    {
        $data = [
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
            'nom' => 'Promo 2023',
        ];

        $this->json('post', 'api/promotions', $data);
        $response = $this->json('get', 'api/promotions')
            ->assertStatus(200);
        $this->assertCount(1, Promotion::all());
    }

    /** @test */
    public function test_it_can_show_and_store_promotions()
    {
        $data = [
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
            'nom' => 'Promo 2023',
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/promotions', $data);
        $promotion = $response->json(); // Récupérer l'utilisateur créé dans la réponse
        // Vérifier si les détails de l'utilisateur peuvent être récupérés via l'API
        $this->json('get', "api/promotions/{$promotion['id']}")
            ->assertStatus(200)
            ->assertJson([
                'debut' => now()->year, // Obtenir uniquement l'année actuelle
                'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
                'nom' => 'Promo 2023',
                // Ajouter d'autres champs que vous souhaitez vérifier
            ]);
    }

    public function testShowForMissingPromotion()
    {

        $this->json('get', "api/promotions/0")
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
        $this->json('post', 'api/promotions', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_it_can_update_a_promotion()
    {
        $data = [
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
            'nom' => 'Promo 2023',
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/promotions', $data);

        $promotion = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
                'nom' => 'Promo editer'
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/promotions/{$promotion['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
        $updatedPromotionResponse = $this->json('get', "api/promotions/{$promotion['id']}")
            ->assertStatus(200)
            ->assertJson([
                'nom' => 'Promo editer'
                // Ajoutez d'autres champs que vous avez modifiés
            ]);
    }

    public function testUpdateForMissingPromotion()
    {

        $payload = [
            'nom' => 'Science',
            'prix' => 250,
        ];

        $this->json('put', 'api/promotions/0', $payload)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_promotion()
    {
        $data = [
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
            'nom' => 'Promo 2023',
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/promotions', $data);

        $promotion = $response->json();
        $this->json('delete', "api/promotions/{$promotion['id']}")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('promotions', $data);

    }

    public function testDestroyForMissingPromotion()
    {

        $this->json('delete', 'api/promotions/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }


//    /** @test */
//    public function it_can_have_a_depense()
//    {
//        $promotion = Promotion::factory()->create();
//        $depense = Depense::factory()->create(['promotion_id' => $promotion->id]);
//        dump(Promotion::all());
//        dump(Depense::all());
//        $this->assertInstanceOf(Depense::class, $promotion->depense);
//    }
//
//    /** @test */
//    public function it_can_have_a_scolarite()
//    {
//        $promotion = Promotion::factory()->create();
//        $scolarite = Scolarite::factory()->create(['promotion_id' => $promotion->id]);
//
//        $this->assertInstanceOf(Scolarite::class, $promotion->scolarite);
//    }
//
////    /** @test */
//    public function it_can_have_a_payteacher()
//    {
//        $promotion = Promotion::factory()->create();
//        $payteacher = Payteacher::factory()->create(['promotion_id' => $promotion->id]);
//
//        $this->assertInstanceOf(Payteacher::class, $promotion->payteacher);
//    }
//
//    /** @test */
//    public function it_can_belong_to_multiple_eleves()
//    {
//        $promotion = Promotion::factory()->create();
//        $eleves = Eleve::factory(3)->create();
//
//        $promotion->eleves()->attach($eleves);
//
//        $this->assertCount(3, $promotion->eleves);
//    }
//
//    /** @test */
//    public function it_is_fillable()
//    {
//        $data = [
//            'debut' => now(),
//            'fin' => now()->addYear(),
//            'nom' => 'Promo 2023',
//        ];
//
//        $promotion = new Promotion($data);
//
//        $this->assertEquals($data, $promotion->getAttributes());
//    }
}
