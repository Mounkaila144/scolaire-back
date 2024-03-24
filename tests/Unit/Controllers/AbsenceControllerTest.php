<?php

namespace Tests\Unit\Controllers;
use App\Models\Absence;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Promotion;
use App\Models\Matiere;
use App\Models\Schedule;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbsenceControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }

    public function test_an_eleve_can_retrieve_own_absences()
    {
        $user = User::factory()->create();
        $user->assignRole('eleve');
        $token = auth()->login($user);

        $eleve = Eleve::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/absences/eleve/{$eleve->id}", ['Authorization' => "Bearer $token"]);

        $response->assertOk();
    }
    public function test_an_eleve_can_not_retrieve_absences_of_another()
    {
        $user = User::factory()->create();
        $user->assignRole('eleve');
        $token = auth()->login($user);

        $eleve2 = Eleve::factory()->create();

        $response = $this->getJson("/api/absences/eleve/{$eleve2->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(403);
    }


    public function test_getAbsencesByMatiere_returns_absences_when_user_is_authorized()
    {
        $matiereId = 1;
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);

        $matiere = Matiere::factory()->create();
        $absence = Absence::factory()->create([
            'matiere_id' => $matiere->id,
            'eleve_id' => Eleve::factory()->create()->id,
        ]);

        $response = $this->getJson("/api/absences/matiere/{$matiereId}", ['Authorization' => "Bearer $token"]);

        $response->assertOk();
        $response->assertJsonStructure([
            'status', 'message', 'data' => [
                [
                    'id', 'eleve_id', 'matiere_id',
                ],
            ],
        ]);
    }



    /** @test */
    /** @test */
    /** @test */
    public function test_can_create_absence_with_specific_justifications()
    {
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('prof');
        $token = auth()->login($user);

        $schedule = Schedule::factory()->create();
        $matiere = Matiere::factory()->create();
        $eleve1 = Eleve::factory()->create();
        $eleve2 = Eleve::factory()->create();

        $absencesData = [
            'schedule_id' => $schedule->id,
            'matiere_id' => $matiere->id,
            'eleves_absents' => [
                ['id' => $eleve1->id, 'justifiee' => true],
                ['id' => $eleve2->id, 'justifiee' => false],
            ],
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->json('post','/api/absences', $absencesData, ['Authorization' => "Bearer $token"]);

        // Vérification que la requête a réussi
        $response->assertStatus(201); // ou $response->assertOk() si votre API ne retourne pas 201 pour une création


    }


    public function test_can_update_absence()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $absence = Matiere::factory()->create();
        $data = ['coef' => 17];

        $response = $this->put("/api/matiers/{$absence->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_absence()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $absence = Matiere::factory()->create();

        $response = $this->delete("/api/matiers/{$absence->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
