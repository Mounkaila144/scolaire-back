<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Professeur;
use App\Models\Cour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function index()
    {
        $cour = Cour::with(["schedule","professeur"])->get();
        return ApiResponse::success($cour);
    }

    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $request->validate([
            'schedule_id' => 'required',
            'professeur_id' => 'required',
        ]);


        $data = [
            'schedule_id' => $request->schedule_id,
            'professeur_id' => $request->professeur_id
        ];
        $data = $request->all();
        $data["promotion_id"]=$promotionId;
        $evaluation = Cour::create($data);

        return ApiResponse::created($evaluation);
    }
    public function show($id)
    {

        $Cour= Cour::findOrFail($id);

        Return ApiResponse::success($Cour);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $cour = Cour::findOrFail($id);
        $data = $request->all();

        $cour->update($data);

        return ApiResponse::success($cour, 200);
    }

    public function destroy($id)
    {
        $cour = Cour::findOrFail($id);
        $cour->delete();
        return ApiResponse::noContent();
    }
}
