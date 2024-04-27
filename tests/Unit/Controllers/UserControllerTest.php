<?php

namespace Tests\Unit\Controllers;
use App\Models\User;
use App\Models\Promotion;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_user()
    {
        $user = User::factory()->create();
        $user->assignRole('superadmin');
        $token = auth()->login($user);
        User::factory()->count(3)->create();
        $response = $this->get('/api/users', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_show_user()
    {
        $user = User::factory()->create();
        $user->assignRole('superadmin');
        $token = auth()->login($user);
        $user = User::factory()->create();
        $response = $this->get("/api/users/{$user->id}", ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_create_user()
    {

        $matiere = User::factory()->create();
        $promotion = Promotion::factory()->create();

        $user = User::factory()->create();
        $user->assignRole('superadmin');
        $token = auth()->login($user);
        $data = [
            'nom' =>'mounkaila',
            'prenom' =>'boubacar',

        ];
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/users', $data);

        $response->assertStatus(201);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $user->assignRole('superadmin');
        $token = auth()->login($user);
        $user = User::factory()->create();
        $data = ['user' => 17];

        $response = $this->put("/api/users/{$user->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $user->assignRole('superadmin');
        $token = auth()->login($user);
        $user = User::factory()->create();

        $response = $this->delete("/api/users/{$user->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
