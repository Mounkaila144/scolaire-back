<?php

namespace Tests\Unit\Controllers;
use App\Models\Payteacher;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayteacherControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_payteacher()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        Payteacher::factory()->count(3)->create();
        $response = $this->get('/api/payteachers', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_payteacher()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $payteacher = Payteacher::factory()->create();
        $response = $this->get("/api/payteachers/{$payteacher->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_create_payteacher()
    {

        $prof = Professeur::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'prix' =>700000,
            'professeur_id' => $prof->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->post('/api/payteachers', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_payteacher()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $payteacher = Payteacher::factory()->create();
        $data = ['prix' => 17];

        $response = $this->put("/api/payteachers/{$payteacher->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_payteacher()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $payteacher = Payteacher::factory()->create();

        $response = $this->delete("/api/payteachers/{$payteacher->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
