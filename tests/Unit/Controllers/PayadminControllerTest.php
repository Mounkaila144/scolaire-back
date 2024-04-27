<?php

namespace Tests\Unit\Controllers;
use App\Models\Payadmin;
use App\Models\User;
use App\Models\Promotion;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayadminControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_payadmin()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        Payadmin::factory()->count(3)->create();
        $response = $this->get('/api/payadmins', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_payadmin()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $payadmin = Payadmin::factory()->create();
        $response = $this->get("/api/payadmins/{$payadmin->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_create_payadmin()
    {

        $admin = User::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $data = [
            'prix' =>700000,
            'user_id' => $admin->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
            'Authorization' => "Bearer $token"
        ])->post('/api/payadmins', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_payadmin()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $payadmin = Payadmin::factory()->create();
        $data = ['prix' => 17];

        $response = $this->put("/api/payadmins/{$payadmin->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_payadmin()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $payadmin = Payadmin::factory()->create();

        $response = $this->delete("/api/payadmins/{$payadmin->id}",[], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(204);
    }
}
