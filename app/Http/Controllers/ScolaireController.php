<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Scolarite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScolaireController extends Controller
{
    public function index()
    {
        $scolaires = Scolarite::all();
        return response()->json($scolaires);
    }

    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'promotion_id' => 'required|exists:promotions,id',
        ]);

        $eleve = Eleve::findOrFail($request->eleve_id);
        $prix = $eleve->classe->prix; // Récupérer le prix depuis la classe de l'élève

        $data = [
            'prix' => $prix,
            'eleve_id' => $request->eleve_id,
            'promotion_id' => $request->promotion_id
        ];

        $scolarite = Scolarite::create($data);

        return response()->json($scolarite, 201);
    }
    public function show($id)
    {

        $Scolarite= Scolarite::findOrFail($id);

        Return response()->json($Scolarite);
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
        $scolaire->update($request->all());

        return response()->json($scolaire, 200);
    }

    public function destroy($id)
    {
        $scolaire = Scolarite::findOrFail($id);
        $scolaire->delete();
        return response()->json(null, 204);
    }
}
