<?php

namespace Tests\Unit\Controllers;
use App\Models\Cour;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Schedule;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        Cour::factory()->count(3)->create();
        $response = $this->get('/api/cours', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $cour = Cour::factory()->create();
        $response = $this->get("/api/cours/{$cour->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_create_cour()
    {
        $schedule = Schedule::factory()->create();
        $professeur = Professeur::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'schedule_id' => $schedule->id,
            'professeur_id' => $professeur->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
             'Authorization' => "Bearer $token"
        ])->post('/api/cours', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $cour = Cour::factory()->create();
        $data = ['cour' => 17];

        $response = $this->put("/api/cours/{$cour->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $cour = Cour::factory()->create();

        $response = $this->delete("/api/cours/{$cour->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
