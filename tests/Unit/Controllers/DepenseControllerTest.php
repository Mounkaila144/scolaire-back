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
class DepenseControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    /** @test */
    public function it_can_get_all_depenses()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
      $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
             'Authorization' => "Bearer $token"
        ])->json('post', 'api/depenses', $data);
        $response = $this->json('get', 'api/depenses')
            ->assertStatus(200);
    }

    /** @test */
    public function test_it_can_show_and_store_depenses()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
         $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('post', 'api/depenses', $data);
        $depense = $response->json();
        // Récupérer l'utilisateur créé dans la réponse
        // Vérifier si les détails de l'utilisateur peuvent être récupérés via l'API
        $this->json('get', "api/depenses/{$depense['data']['id']}")
            ->assertStatus(200);
    }

    public function test_it_can_update_a_depense()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('post', 'api/depenses', $data);

        $depense = $response->json(); // Récupérer l'utilisateur créé dans la réponse

        $dataEdit = [
                'details' => 'details'
            // Ajoutez d'autres données à modifier au besoin
        ];

        // Mettre à jour les données de l'utilisateur via l'API PUT
        $this->json('put', "api/depenses/{$depense['data']['id']}", $dataEdit)
            ->assertStatus(200);

        // Récupérer à nouveau les détails de l'utilisateur après la mise à jour
        $updatedPromotionResponse = $this->json('get', "api/depenses/{$depense['data']['id']}")
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_depense()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
         $promotion = Promotion::factory()->create();

        $data = [
            'details' => "details",
            'prix' => 500
        ];

        // Enregistrer l'utilisateur et récupérer la réponse JSON
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->json('post', 'api/depenses', $data);

        $depense = $response->json();
        $this->json('delete', "api/depenses/{$depense['data']['id']}")
            ->assertStatus(204);

    }


}
