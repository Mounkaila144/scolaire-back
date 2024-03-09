<?php

namespace Tests\Unit\Controllers;

use App\Models\Eleve;
use App\Models\Promotion;
use App\Models\Scolarite;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScolariteControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }

    public function test_can_list_scolarites()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        Scolarite::factory()->count(3)->create();
        $response = $this->get('/api/scolarites',['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_scolarite()
    {
        $scolarite = Scolarite::factory()->create();
        $response = $this->get("/api/scolarites/{$scolarite->id}");

        $response->assertStatus(200);
        $this->assertEquals($scolarite->id, $response->json()['data']['id']);
    }

    public function test_can_create_new_scolarite()
    {
        $eleve = Eleve::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $data = [
            'prix' =>50000,
            'eleve_id' => $eleve->id
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->post('/api/scolarites', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('scolarites', $data);
    }


    public function test_can_delete_scolarite()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $scolarite = Scolarite::factory()->create();

        $response = $this->delete("/api/scolarites/{$scolarite->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('scolarites', ['id' => $scolarite->id]);
    }
}
