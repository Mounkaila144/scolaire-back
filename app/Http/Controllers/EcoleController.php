<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EcoleController extends Controller
{
    public function __construct()
    {
        // Utiliser le middleware 'permission' avec des groupes de permissions
        $this->middleware('permission:admin')->only(['store','destroy','update']);
    }

    public function index()
    {
        $classes = Ecole::all();
        return ApiResponse::success($classes, 'Liste des classes récupérée avec succès');
    }


    public function store(Request $request)
    {
        if (Ecole::count() === 0) {
            $champsRequis = ['nom', 'adresse', 'numero1', 'numero2', 'description']; // Champs requis
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

            $classe = Ecole::create($request->all());
            return ApiResponse::created($classe, 'Ecole créée avec succès');
        } else {
            return ApiResponse::error('Vous ne pouvez pas créer plus d\'une école', [], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        $classe = Ecole::findOrFail($id);
        return ApiResponse::success($classe, 'Détails de la classe récupérés avec succès');
    }

    public function update(Request $request, $id)
    {
        $classe = Ecole::findOrFail($id);
        $classe->update($request->all());
        return ApiResponse::success($classe, 'Ecole mise à jour avec succès');
    }


    public function destroy($id)
    {
        $classe = Ecole::findOrFail($id);
        $classe->delete();
        return ApiResponse::noContent('Ecole supprimée avec succès');
    }
}
