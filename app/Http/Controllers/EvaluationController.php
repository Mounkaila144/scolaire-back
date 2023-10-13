<?php
namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EvaluationController extends Controller
{
    public function index()
    {
        $evalution = Evaluation::with(["matiere,eleve"])->get();
        return response()->json($evalution);
    }

    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required',
            'sur' => 'required',
            'type' => 'required',
            'classe_id' => 'required',
            'eleve_id' => 'required',
        ]);


        $data = [
            'note' => $request->note,
            'sur' => $request->sur,
            'type' => $request->type,
            'classe_id' => $request->classe_id,
            'eleve_id' => $request->eleve_id
        ];

        $evaluation = Evaluation::create($data);

        return response()->json($evaluation, 201);
    }
    public function show($id)
    {

        $Evaluation= Evaluation::findOrFail($id);

        Return response()->json($Evaluation);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $evalution = Evaluation::findOrFail($id);
        $data = $request->all();

        $evalution->update($data);

        return response()->json($evalution, 200);
    }

    public function destroy($id)
    {
        $evalution = Evaluation::findOrFail($id);
        $evalution->delete();
        return response()->json(null, 204);
    }
}
