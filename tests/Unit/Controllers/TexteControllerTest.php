<?php

namespace Tests\Unit\Controllers;
use App\Models\Texte;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TexteControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_texte()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        Texte::factory()->count(3)->create();
        $response = $this->get('/api/textes', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_texte()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $texte = Texte::factory()->create();
        $response = $this->get("/api/textes/{$texte->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_create_texte()
    {
        $matiere = Texte::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'texte' =>'fff',
            'matiere_id' => $matiere->id,
            'professeur_id' => $matiere->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
             'Authorization' => "Bearer $token"
        ])->post('/api/textes', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_texte()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $texte = Texte::factory()->create();
        $data = ['texte' => 17];

        $response = $this->put("/api/textes/{$texte->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_texte()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $texte = Texte::factory()->create();

        $response = $this->delete("/api/textes/{$texte->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
