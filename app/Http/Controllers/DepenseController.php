<?php
namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepenseController extends Controller
{
    public function index()
    {
        $depense = Depense::all();
        return response()->json($depense);
    }

    public function store(Request $request)
    {
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

            return $this->errorResponse(
                $errorMessage,
                Response::HTTP_BAD_REQUEST
            );
        }
        $data = $request->all();

        $classe = Depense::create($data);
        $classe->save();
        return response()->json($classe, 201);
    }
    public function show($id)
    {

        $Depense= Depense::findOrFail($id);

        Return response()->json($Depense);
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

        return response()->json($classe, 200);
    }

    public function destroy($id)
    {
        $classe = Depense::findOrFail($id);
        $classe->delete();
        return response()->json(null, 204);
    }
}
