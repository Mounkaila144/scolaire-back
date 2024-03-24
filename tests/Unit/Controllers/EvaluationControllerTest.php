<?php

namespace Tests\Unit\Controllers;
use App\Models\Evaluation;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EvaluationControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }




    public function test_an_eleve_can_retrieve_own_evaluations()
    {
        $user = User::factory()->create();
        $user->assignRole('eleve');
        $token = auth()->login($user);

        $eleve = Eleve::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/evaluations/eleve/{$eleve->id}", ['Authorization' => "Bearer $token"]);

        $response->assertOk();
    }
    public function test_an_eleve_can_not_retrieve_evaluations_of_another()
    {
        $user = User::factory()->create();
        $user->assignRole('eleve');
        $token = auth()->login($user);

        $eleve2 = Eleve::factory()->create();

        $response = $this->getJson("/api/evaluations/eleve/{$eleve2->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(403);
    }


    public function test_getEvaluationsByMatiere_returns_evaluations_when_user_is_authorized()
    {
        $matiereId = 1;
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $matiere = Matiere::factory()->create();
        $absence = Evaluation::factory()->create([
            'matiere_id' => $matiere->id,
            'eleve_id' => Eleve::factory()->create()->id,
        ]);

        $response = $this->getJson("/api/evaluations/matiere/{$matiereId}", ['Authorization' => "Bearer $token"]);

        $response->assertOk();
        $response->assertJsonStructure([
            'status', 'message', 'data' => [
                [
                    'id', 'eleve_id', 'matiere_id',
                ],
            ],
        ]);
    }



    public function test_can_create_evalution()
    {
        $eleve = Eleve::factory()->create();
        $matiere = Matiere::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'type' =>'devoir',
            'sur' =>20,
            'note' =>20,
            'eleve_id' => $eleve->id,
            'matiere_id' => $matiere->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
             'Authorization' => "Bearer $token"
        ])->post('/api/evaluations', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_evalution()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $evalution = Evaluation::factory()->create();
        $data = ['coef' => 17];

        $response = $this->put("/api/evaluations/{$evalution->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_evalution()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $evalution = Evaluation::factory()->create();

        $response = $this->delete("/api/evaluations/{$evalution->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
