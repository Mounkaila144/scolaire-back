<?php

namespace Tests\Unit\Controllers;

use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Payteacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayteacherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_payteacher()
    {
        Payteacher::factory()->count(3)->create();
        $response = $this->get('/api/payteachers');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function test_can_show_payteacher()
    {
        $payteacher = Payteacher::factory()->create();
        $response = $this->get("/api/payteachers/{$payteacher->id}");

        $response->assertStatus(200);
        $this->assertEquals($payteacher->id, $response->json('id'));
    }

    public function test_can_create_payteacher()
    {
        $prof = Professeur::factory()->create();
        $promotion = Promotion::factory()->create();


        $data = [
            'prix' =>500,
            'professeur_id' => $prof->id,
        ];
        $response = $this->withHeaders([
            'X-Promotion' => $promotion->id,
        ])->post('/api/payteachers', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('payteachers', $data);
    }

    public function test_can_update_payteacher()
    {
        $payteacher = Payteacher::factory()->create();
        $data = ['prix' => 1700.00];

        $response = $this->put("/api/payteachers/{$payteacher->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('payteachers', $data);
    }

    public function test_can_delete_payteacher()
    {
        $payteacher = Payteacher::factory()->create();

        $response = $this->delete("/api/payteachers/{$payteacher->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('payteachers', ['id' => $payteacher->id]);
    }
}
