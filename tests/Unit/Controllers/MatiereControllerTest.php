<?php

namespace Tests\Unit\Controllers;
use App\Models\Classe;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Matiere;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatiereControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_matiere()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        Matiere::factory()->count(3)->create();
        $response = $this->get('/api/matiers', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_matiere()
    {
        $matiere = Matiere::factory()->create();
        $response = $this->get("/api/matiers/{$matiere->id}");

        $response->assertStatus(200);
    }

    public function test_can_create_matiere()
    {
        $classe = Classe::factory()->create();
        $professeur = Professeur::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'nom' =>'6eme',
            'coef' =>20,
            'classe_id' => $classe->id,
            'professeur_id' => $professeur->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
             'Authorization' => "Bearer $token"
        ])->post('/api/matiers', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_matiere()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $matiere = Matiere::factory()->create();
        $data = ['coef' => 17];

        $response = $this->put("/api/matiers/{$matiere->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_matiere()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $matiere = Matiere::factory()->create();

        $response = $this->delete("/api/matiers/{$matiere->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
