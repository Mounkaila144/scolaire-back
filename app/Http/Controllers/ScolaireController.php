<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Eleve;
use App\Models\Scolarite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScolaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin')->except(['show']);
    }

    public function index()
    {
        $scolaires = Scolarite::all();
        return ApiResponse::success($scolaires);
    }

    public function store(Request $request)
    {
        // Valider les données en premier
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'prix' => 'required|numeric',
        ]);


        // Récupérer l'élève et vérifier le prix
        $eleve = Eleve::with('classe', 'scolarites')->findOrFail($request->eleve_id); // Utilisation de la chargement précoce pour la classe
        $totalScolaritePayer = $eleve->scolarites->sum('prix');
        $total = $eleve->classe->prix; // Pas besoin de vérifier l'existence de scolarité ici

// Assurez-vous que la validation de la requête a été effectuée avant ce bloc de code

        if ($request->prix > 0 && ($request->prix + $totalScolaritePayer) <= $total) {

                $promotionId = $request->header('X-Promotion');

            // Assumer que la logique de validation ou de nettoyage pour promotionId est effectuée ici

            $data = [
                'prix' => $request->prix,
                'eleve_id' => $request->eleve_id,
                'promotion_id' => $promotionId,
            ];

            $scolarite = Scolarite::create($data);

            // Supposer que ApiResponse::created est une méthode personnalisée pour envoyer des réponses
            return ApiResponse::created($scolarite, 201);
        } else {
            // Gérer le cas où le prix n'est pas dans la plage attendue
            return ApiResponse::error(
                'Le prix doit être supérieur à 0 et inférieur au prix total de la scolariter.',
            );
        }
    }


    public function show($id)
    {

        $Scolarite = Scolarite::findOrFail($id);

        return ApiResponse::success($Scolarite);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $scolaire = Scolarite::findOrFail($id);
        $data = $request->all();

        $scolaire->update($data);

        return ApiResponse::success($scolaire, 200);
    }

    public function destroy($id)
    {
        $scolaire = Scolarite::findOrFail($id);
        $scolaire->delete();
        return ApiResponse::noContent();
    }
}
