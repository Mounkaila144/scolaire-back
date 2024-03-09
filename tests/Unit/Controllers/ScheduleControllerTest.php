<?php

namespace Tests\Unit\Controllers;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Professeur;
use App\Models\Schedule;
use App\Models\Promotion;
use App\Models\User;
use Database\Seeders\initDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void {
        parent::setUp();
        // Exécute tous les seeders disponibles
        $this->seed(initDataSeeder::class);
    }
    public function test_can_list_texte()
    {

        Schedule::factory()->count(3)->create();
        $response = $this->get('/api/schedules');

        $response->assertStatus(200);
    }

    public function test_can_show_texte()
    {

        $texte = Schedule::factory()->create();
        $response = $this->get("/api/schedules/{$texte->id}");

        $response->assertStatus(200);
    }

    public function test_can_create_schedule()
    {
        // Création des entités nécessaires
        $classe = Classe::factory()->create();
        $matiere = Matiere::factory()->create();
        $professeur = Professeur::factory()->create();

        // Authentification d'un utilisateur avec le rôle 'admin'
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user); // Assurez-vous que cette méthode fonctionne comme prévu

        // Préparation des données pour la création d'un emploi du temps
        $data = [
            'jour' => 'Mardi',
            'debut' => '08:00', // Format HH:mm
            'classe_id' => $classe->id,
            'matiere_id' => $matiere->id,
            'professeur_id' => $professeur->id,
        ];

        // Envoi de la requête POST pour créer un emploi du temps
        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/schedules', $data);

        // Vérification du statut de la réponse
        $response->assertStatus(201); // ou $response->assertCreated();
    }

    public function test_can_update_texte()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $texte = Schedule::factory()->create();
        $data = ['jour' => 'Mardi'];

        $response = $this->put("/api/schedules/{$texte->id}", $data, ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
    }

    public function test_can_delete_texte()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $token = auth()->login($user);
        $texte = Schedule::factory()->create();

        $response = $this->delete("/api/schedules/{$texte->id}",[], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(204);
    }
}
