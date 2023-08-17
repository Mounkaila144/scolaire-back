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
class EleveControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_eleves()
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
            'classe_id' => $classe->id, // Remplacez par l'ID de la classe appropriée
            'promotion_id' => $promotion->id,
        ];


        $this->json('post', 'api/eleves', $data);
      $this->json('get', 'api/eleves')
            ->assertStatus(200)
        ->assertJsonCount(1);
    }

    /** @test */
    public function test_it_can_show_and_store_eleves()
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
            'classe_id' => $classe->id, // Remplacez par l'ID de la classe appropriée
            'promotion_id' => $promotion->id,
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/eleves', $data);
        $eleve = $response->json();
        // Récupérer l'utilisateur créé dans la réponse
        // Vérifier si les détails de l'utilisateur peuvent être récupérés via l'API
        $this->json('get', "api/eleves/{$eleve['id']}")
            ->assertStatus(200)
            ->assertJson([
                'number' => '12345',
                'adresse' => '123 Street',
                'birth' => '2000-01-01',
                'nationalite' => 'FR',
                'genre' => 'M',
                'classe_id' => $classe->id // Remplacez par l'ID de la classe appropriée
            ]);
    }

    public function testShowForMissingPromotion()
    {

        $this->json('get', "api/eleves/0")
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
        $this->json('post', 'api/eleves', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function test_it_can_update_a_eleve()
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
            'classe_id' => $classe->id, // Remplacez par l'ID de la classe appropriée
            'promotion_id' => $promotion->id,
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/eleves', $data);

        $eleve = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
                'adresse' => 'edit'
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/eleves/{$eleve['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
       $this->json('get', "api/eleves/{$eleve['id']}")
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
            'classe_id' => $classe->id, // Remplacez par l'ID de la classe appropriée
            'promotion_id' => $promotion->id,
        ];


        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $this->json('put', 'api/eleves/0', $data)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_eleve()
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
            'classe_id' => $classe->id, // Remplacez par l'ID de la classe appropriée
            'promotion_id' => $promotion->id,
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/eleves', $data);

        $eleve = $response->json();

        $this->json('delete', "api/eleves/{$eleve['id']}")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('eleves', $data);

    }

    public function testDestroyForMissingPromotion()
    {

        $this->json('delete', 'api/eleves/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_belongs_to_a_promotion_and_classe()
    {
        // Créez une dépense et une promotion
        $promotion1 = Promotion::factory()->create();
        $promotion2 = Promotion::factory()->create();
        $classe = Classe::factory()->create();

        $data = [
            'nom' => 'Mounkaila',
            'prenom' => 'Boubacar',
            'number' => '12345',
            'adresse' => '123 Street',
            'birth' => '2000-01-01',
            'nationalite' => 'FR',
            'genre' => 'M',
            'classe_id' => $classe->id,
            'promotion_id' => $promotion1->id,

        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/eleves', $data);

        $eleve = $response->json();
//        $eleve->promotions()->attach([$promotion1->id, $promotion2->id]);
//        $this->assertArrayHasKey('promotions', $eleve);

//        // Verify the promotion IDs present in the response
//        $this->assertContains($promotion1->id, array_column($eleve['promotions'], 'id'));
//        $this->assertContains($promotion2->id, array_column($eleve['promotions'], 'id'));

        $this->assertArrayHasKey('classe', $eleve);
        $this->assertEquals($classe->id, $eleve["classe"]["id"]);
    }

}