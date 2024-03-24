<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Professeur;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatiereController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin')->except("index","show");
    }
    public function index()
    {
        $matiere = Matiere::with(["classe",'professeur'])->get();
        return ApiResponse::success($matiere);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'coef' => 'required',
            'classe_id' => 'required',
            'professeur_id' => 'required',
        ]);


        $data = [
            'nom' => $request->nom,
            'coef' => $request->coef,
            'classe_id' => $request->classe_id,
            'professeur_id' => $request->professeur_id,
        ];

        $matiere = Matiere::create($data);

        return ApiResponse::created($matiere);
    }
    public function show($id)
    {

        $Matiere= Matiere::findOrFail($id);

        Return ApiResponse::success($Matiere);
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

        return ApiResponse::success($matiere);
    }

    public function destroy($id)
    {
        $matiere = Matiere::findOrFail($id);
        $matiere->delete();
        return ApiResponse::noContent();
    }
}
