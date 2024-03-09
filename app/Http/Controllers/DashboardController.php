<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Depense;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\Eleve;
// ... autres imports ...

class DashboardController extends Controller
{
    public function stats()
    {
        $eleveCount = Eleve::count();
        $professeurCount = Professeur::count();
        $totalClasses = Classe::count();

        $elevesPerPromotion = Promotion::withCount('eleves')->get()->map(function($promotion) {
            return [
                'nom' => $promotion->nom,
                'nombre_eleves' => $promotion->eleves_count
            ];
        });
        $depensesTotales = Depense::sum('prix');

        $tendanceDepenses = Depense::selectRaw('DATE(created_at) as date, SUM(prix) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(30) // pour les 30 derniers jours, ajustez selon votre besoin
            ->get();


        return response()->json([
            'totalClasses' => $totalClasses,
            'total_eleves' => $eleveCount,
            'total_professeurs' => $professeurCount,
            'eleves_par_promotion' => $elevesPerPromotion,
            'depenses_totales' => $depensesTotales,
            'tendance_depenses' => $tendanceDepenses,
        ]);
    }
}
