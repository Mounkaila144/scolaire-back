<?php

namespace Tests\Unit\Controllers;
use App\Models\Ecole;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Schedule;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcoleControllerTest extends TestCase
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
        Ecole::factory()->create();
        $response = $this->get('/api/ecoles', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $cour = Ecole::factory()->create();
        $response = $this->get("/api/ecoles/{$cour->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_create_cour()
    {

        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'nom' => 'lamartine',
            'description' => 'lamartine',
            'adresse' => 'lamartine',
            'numero1' => 'lamartine',
            'numero2' => 'lamartine',

        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
             'Authorization' => "Bearer $token"
        ])->post('/api/ecoles', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $cour = Ecole::factory()->create();
        $data = ['cour' => 17];

        $response = $this->put("/api/ecoles/{$cour->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_cour()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $cour = Ecole::factory()->create();

        $response = $this->delete("/api/ecoles/{$cour->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
