<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Professeur;
use App\Models\Texte;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TexteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:prof|admin');
    }
    public function index()
    {
        $text = Texte::with(["matiere","professeur"])->get();
        return ApiResponse::success($text);
    }

    public function store(Request $request)
    {
        $request->validate([
            'texte' => 'required',
            'matiere_id' => 'required',
            'professeur_id' => 'required',
        ]);


        $data = [
            'texte' => $request->texte,
            'matiere_id' => $request->matiere_id,
            'professeur_id' => $request->professeur_id
        ];

        $evaluation = Texte::create($data);

        return ApiResponse::created($evaluation);
    }
    public function show($id)
    {

        $Texte= Texte::findOrFail($id);

        Return ApiResponse::success($Texte);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $text = Texte::findOrFail($id);
        $data = $request->all();

        $text->update($data);

        return ApiResponse::success($text, 200);
    }

    public function destroy($id)
    {
        $text = Texte::findOrFail($id);
        $text->delete();
        return ApiResponse::noContent();
    }
}
