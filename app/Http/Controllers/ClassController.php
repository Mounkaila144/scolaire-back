<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('eleves')->get();
        return response()->json($classes);
    }


    public function store(Request $request)
    {

        $requiredFields = ['nom', 'prix']; // Champs requis
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
        $classe = Classe::create($request->all());
        $classe->save();
        return response()->json($classe, 201);
    }
    public function show($id)
    {
        $classe = Classe::withCount('eleves')->findOrFail($id);
        return response()->json($classe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);
        $classe->update($request->all());

        return response()->json($classe, 200);
    }

    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();
        return response()->json(null, 204);
    }
}
