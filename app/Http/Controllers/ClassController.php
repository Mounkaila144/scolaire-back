<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Classe;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassController extends Controller
{
    public function __construct()
    {
        // Utiliser le middleware 'permission' avec des groupes de permissions
        $this->middleware('permission:admin|prof|eleve')->only(['show']);
        $this->middleware('permission:admin')->except(['show']);
    }

    public function index()
    {
        $classes = Classe::withCount('eleves')->get();
        return ApiResponse::success($classes, 'Liste des classes récupérée avec succès');
    }


    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $champsRequis = ['nom', 'prix']; // Champs requis
        $champsManquants = [];

        foreach ($champsRequis as $champ) {
            if (is_null($request->input($champ))) {
                $champsManquants[] = $champ;
            }
        }

        if (!empty($champsManquants)) {
            $messageErreur = count($champsManquants) > 1 ? 'Les champs suivants sont manquants : ' : 'Le champ suivant est manquant : ';
            $messageErreur .= implode(', ', $champsManquants);

            return ApiResponse::error($messageErreur, [], Response::HTTP_BAD_REQUEST);
        }
        $data = $request->all();
        $data["promotion_id"]=$promotionId;
        $classe = Classe::create($data);
        return ApiResponse::created($classe, 'Classe créée avec succès');
    }

    public function show($id)
    {
        $classe = Classe::withCount('eleves')->findOrFail($id);
        return ApiResponse::success($classe, 'Détails de la classe récupérés avec succès');
    }

    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);
        $classe->update($request->all());
        return ApiResponse::success($classe, 'Classe mise à jour avec succès');
    }


    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return ApiResponse::noContent('Classe supprimée avec succès');
    }
}
