<?php

namespace Tests\Unit\Controllers;

use App\Models\Eleve;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class
DashboardControllerTest extends TestCase
{
    use RefreshDatabase;  // Cette trait est utilisé si vous souhaitez rafraîchir la base de données à chaque test

    public function testStatsReturnsCorrectData()
    {
        // Créer des données factices pour votre test ici, par exemple en utilisant des factories
        $elevesCreated = Eleve::factory(10)->create();
        $expectedEleveCount = count($elevesCreated);

        // Ensuite, faites une demande à votre endpoint:
        $response = $this->get('/api/dashboard');  // Ajustez l'URL si nécessaire
        // Assurez-vous que la demande a réussi:
        $response->assertStatus(200);

        // Vérifiez que les données attendues sont dans la réponse:
        $response->assertJsonStructure([
            'totalClasses',
            'total_eleves',
            'total_professeurs',
            'eleves_par_promotion',
            'depenses_totales',
            'tendance_depenses'
        ]);

        // Vérifiez les valeurs spécifiques
        $data = $response->json();
        $this->assertEquals($expectedEleveCount, $data['total_eleves']);

        // ... ajoutez d'autres assertions si nécessaire ...
    }

    // Ajoutez des méthodes de test supplémentaires pour d'autres fonctionnalités/endpoints de votre DashboardController
}

