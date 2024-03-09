<?php

namespace Tests\Unit\Controllers;
use App\Models\Promotion;
use App\Models\Payadmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayadminControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_payadmin()
    {
        Payadmin::factory()->count(3)->create();
        $response = $this->get('/api/payadmins');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_payadmin()
    {
        $payadmin = Payadmin::factory()->create();
        $response = $this->get("/api/payadmins/{$payadmin->id}");

        $response->assertStatus(200);
        $this->assertEquals($payadmin->id, $response->json('id'));
    }

    public function test_can_create_payadmin()
    {
        $prof = User::factory()->create();
        $promotion = Promotion::factory()->create();


        $data = [
            'prix' =>500,
            'user_id' => $prof->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->post('/api/payadmins', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('payadmins', $data);
    }

    public function test_can_update_payadmin()
    {
        $payadmin = Payadmin::factory()->create();
        $data = ['prix' => 1700.00];

        $response = $this->put("/api/payadmins/{$payadmin->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payadmins', $data);
    }

    public function test_can_delete_payadmin()
    {
        $payadmin = Payadmin::factory()->create();

        $response = $this->delete("/api/payadmins/{$payadmin->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('payadmins', ['id' => $payadmin->id]);
    }
}
