<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PromotionController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:admin')->only(['store','update','destroy']);
    }

    public function index()
    {
        $promotions = Promotion::all();
        return ApiResponse::success($promotions, 'Liste des promotions récupérée avec succès');
    }

    public function store(Request $request)
    {

        $requiredFields = ['debut', 'fin']; // Champs requis
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (is_null($request->input($field))) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            $errorMessage = count($missingFields) > 1 ? 'Les champs suivants sont manquants : ' : 'Le champ suivant est manquant : ';
            $errorMessage .= implode(', ', $missingFields);

            return ApiResponse::error($errorMessage, [], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
        }
        $promotion = Promotion::create($request->all());
        $promotion->save();
        return ApiResponse::created($promotion, 'Promotion créée avec succès');
    }
    public function show($id)
    {

        $Promotion= Promotion::findOrFail($id);

        Return ApiResponse::success($Promotion, 'Détails de la promotion récupérés avec succès');;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update($request->all());

        return ApiResponse::success($promotion,'Promotion mise à jour avec succès');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return ApiResponse::noContent('Promotion supprimée avec succès');
    }
}
