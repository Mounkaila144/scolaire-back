<?php
namespace App\Http\Controllers;

use App\Models\Professeur;
use App\Models\Payteacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayteacherController extends Controller
{
    public function index()
    {
        $payteachers = Payteacher::with(["professeur.user"])->get();
        return response()->json($payteachers);
    }

    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $request->validate([
            'prix' => 'required',
            'professeur_id' => 'required',
        ]);


        $data = [
            'prix' => $request->prix,
            'professeur_id' => $request->professeur_id,
            'promotion_id' => $promotionId
        ];

        $paytecher = Payteacher::create($data);

        return response()->json($paytecher, 201);
    }
    public function show($id)
    {

        $Payteacher= Payteacher::findOrFail($id);

        Return response()->json($Payteacher);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $payteacher = Payteacher::findOrFail($id);
        $data = $request->all();

        $payteacher->update($data);

        return response()->json($payteacher, 200);
    }

    public function destroy($id)
    {
        $payteacher = Payteacher::findOrFail($id);
        $payteacher->delete();
        return response()->json(null, 204);
    }
}
