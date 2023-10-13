<?php

namespace Tests\Unit\Controllers;

use App\Models\Eleve;
use App\Models\Promotion;
use App\Models\Scolarite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScolariteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_scolarites()
    {
        Scolarite::factory()->count(3)->create();
        $response = $this->get('/api/scolarites');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_scolarite()
    {
        $scolarite = Scolarite::factory()->create();
        $response = $this->get("/api/scolarites/{$scolarite->id}");

        $response->assertStatus(200);
        $this->assertEquals($scolarite->id, $response->json('id'));
    }

    public function test_can_create_scolarite()
    {
        $eleve = Eleve::factory()->create();
        $promotion = Promotion::factory()->create();


        $prix = $eleve->classe->prix; // Récupérer le prix depuis la classe de l'élève
        $data = [
            'prix' =>$prix,
            'eleve_id' => $eleve->id,
            'promotion_id' => $promotion->id
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->post('/api/scolarites', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('scolarites', $data);
    }

    public function test_can_update_scolarite()
    {
        $scolarite = Scolarite::factory()->create();
        $data = ['prix' => 1700.00];

        $response = $this->put("/api/scolarites/{$scolarite->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('scolarites', $data);
    }

    public function test_can_delete_scolarite()
    {
        $scolarite = Scolarite::factory()->create();

        $response = $this->delete("/api/scolarites/{$scolarite->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('scolarites', ['id' => $scolarite->id]);
    }
}
