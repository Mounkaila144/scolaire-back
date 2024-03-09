<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
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
        $promotion = Promotion::factory()->create();
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
        ];
        $this->seed(initDataSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/promotions', $data, ['Authorization' => "Bearer $token"]);
        $promotion = $response->json(); // Récupérer l'utilisateur créé dans la réponse
        // Vérifier si les détails de l'utilisateur peuvent être récupérés via l'API
        $this->json('get', "api/promotions/{$promotion['data']['id']}")
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Détails de la promotion récupérés avec succès',
                'data' => [
                'debut' => now()->year, // Obtenir uniquement l'année actuelle
                'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1
                // Ajouter d'autres champs que vous souhaitez vérifier
                    ]
            ]);
    }

    public function testShowForMissingPromotion()
    {

        $this->json('get', "api/promotions/0")
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);

    }


    /** @test */
    public function test_it_can_update_a_promotion()
    {
        $this->seed(initDataSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $data = [
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1

        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/promotions', $data, ['Authorization' => "Bearer $token"]);

        $promotion = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
            'fin' => now()->year, // Obtenir l'année actuelle + 1
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/promotions/{$promotion['data']['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
        $updatedPromotionResponse = $this->json('get', "api/promotions/{$promotion['data']['id']}")
            ->assertStatus(200)
            ->assertJson([
                    'status' => 'success',
                    'message' => 'Détails de la promotion récupérés avec succès',
                    'data' => [
                "fin" =>now()->year
                // Ajoutez d'autres champs que vous avez modifiés
                        ]
            ]);
    }



    /** @test */
    public function it_can_delete_a_promotion()
    {

        $data = [
            'debut' => now()->year, // Obtenir uniquement l'année actuelle
            'fin' => now()->addYear()->year, // Obtenir l'année actuelle + 1

        ];
        $this->seed(initDataSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->json('post', 'api/promotions', $data,['Authorization' => "Bearer $token"]);

        $promotion = $response->json();
        $this->json('delete', "api/promotions/{$promotion['data']['id']}",['Authorization' => "Bearer $token"])
            ->assertStatus(204)
            ->assertNoContent();

    }


}
