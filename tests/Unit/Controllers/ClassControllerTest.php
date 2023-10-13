<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\DepenseController;
use App\Models\Classe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ClassControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsDataInValidFormat()
    {
        $response = $this->json('get', 'api/classes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'nom','eleves_count', 'prix', 'created_at', 'updated_at'],
            ]);
    }


    /** @test */
    public function it_can_get_all_classes()
    {
        $data = [
            'nom' => 'Mathematics',
            'prix' => 200,
            // Add more data as needed
        ];
        $this->postJson('/api/classes', $data);

        $response = $this->getJson('/api/classes');

        $response->assertStatus(200);

        $this->assertCount(1, Classe::all());
    }

    /** @test */
    public function it_can_show_classes()
    {
        $classe = Classe::factory()->create();

        $this->json('get', "api/classes/$classe->id")
            ->assertStatus(200)
            ->assertJson([
                'nom' => $classe->nom,
                'prix' => $classe->prix,
                'eleves_count'=>0
                // Add other fields you want to check for
            ]);

    }
    public function testShowForMissingClasse() {

        $this->json('get', "api/classes/0")
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);

    }

    /** @test */
    public function it_can_create_a_class()
    {
        $data = [
            'nom' => 'Mathematics',
            'prix' => 200,
            // Add more data as needed
        ];

        $this->json('post', 'api/classes', $data)
            ->assertStatus(201)
            ->assertJsonStructure(
                ['id', 'nom', 'prix', 'created_at', 'updated_at'],

            );
        $this->assertDatabaseHas('classes', $data);
    }
    public function testStoreWithMissingData() {

        $payload = [
            'nom' => 'Mathematics'
//            'prix' => 200,
            //email address is missing
        ];
        $this->json('post', 'api/classes', $payload)
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_update_a_class()
    {
        $classe = Classe::factory()->create([
            'nom' => 'Mathematics',
            'prix' => 200,
        ]);

        $dataEdit = [
            'nom' => 'Science',
            'prix' => 250,
            // Add more dataEdit as needed
        ];
//dd($classe->id);
        $this->json('put', "api/classes/$classe->id", $dataEdit)
            ->assertStatus(200);
    }
    public function testUpdateForMissingUser() {

        $payload = [
            'nom' => 'Science',
            'prix' => 250,
        ];

        $this->json('put', 'api/classes/0', $payload)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_can_delete_a_class()
    {
        $classeData = [
            "nom" => "6em",
            "prix" => 5000
        ];
        $classe = Classe::factory()->create($classeData);
        $this->json('delete', "api/classes/$classe->id")
            ->assertStatus(204)
            ->assertNoContent();
        $this->assertDatabaseMissing('classes', $classeData);

    }
    public function testDestroyForMissingUser() {

        $this->json('delete', 'api/classes/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['error']);
    }
}
