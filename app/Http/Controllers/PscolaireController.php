<?php
namespace App\Http\Controllers;

use App\Models\Scolarite;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PscolaireController extends Controller
{
    public function index()
    {
        $scolaires = Scolarite::all();
        return response()->json($scolaires);
    }

    public function store(Request $request)
    {

//        dd($request->all());
        if (is_null($request->input('nom')) || is_null($request->input('prix')) ) {
            return $this->errorResponse(
                'le nom et le prix sont obligatoir',
                Response::HTTP_BAD_REQUEST
            );
        }
        $scolaire = Scolarite::create($request->all());
        $scolaire->save();
        return response()->json($scolaire, 201);
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
