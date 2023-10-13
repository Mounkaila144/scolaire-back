<?php
namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatiereController extends Controller
{
    public function index()
    {
        $matiere = Matiere::with(["classe"])->get();
        return response()->json($matiere);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'coef' => 'required',
            'classe_id' => 'required',
        ]);


        $data = [
            'nom' => $request->nom,
            'coef' => $request->coef,
            'classe_id' => $request->classe_id,
        ];

        $evaluation = Matiere::create($data);

        return response()->json($evaluation, 201);
    }
    public function show($id)
    {

        $Matiere= Matiere::findOrFail($id);

        Return response()->json($Matiere);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $matiere = Matiere::findOrFail($id);
        $data = $request->all();

        $matiere->update($data);

        return response()->json($matiere, 200);
    }

    public function destroy($id)
    {
        $matiere = Matiere::findOrFail($id);
        $matiere->delete();
        return response()->json(null, 204);
    }
}
