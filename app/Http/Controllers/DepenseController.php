<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function index()
    {
        $depense = Depense::all();
        return ApiResponse::success($depense);
    }

    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $requiredFields = ['details', 'prix']; // Champs requis
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (is_null($request->input($field))) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            $errorMessage = count($missingFields) > 1 ? 'Les champs suivants sont manquants : ' : 'Le champ suivant est manquant : ';
            $errorMessage .= implode(', ', $missingFields);

            return ApiResponse::error();
        }
        $data = $request->all();
$data["promotion_id"]=$promotionId;
        $classe = Depense::create($data);
        $classe->save();
        return ApiResponse::created($classe);
    }
    public function show($id)
    {

        $Depense= Depense::findOrFail($id);

        Return ApiResponse::success($Depense);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $classe = Depense::findOrFail($id);
        $classe->update($request->all());

        return ApiResponse::success($classe);
    }

    public function destroy($id)
    {
        $classe = Depense::findOrFail($id);
        $classe->delete();
        return ApiResponse::noContent();
    }
}
