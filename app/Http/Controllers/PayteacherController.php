<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Professeur;
use App\Models\Payteacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayteacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function index()
    {
        $payteachers = Payteacher::with(["professeur.user"])->get();
        return ApiResponse::success($payteachers);
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

        return ApiResponse::created($paytecher);
    }
    public function show($id)
    {

        $Payteacher= Payteacher::findOrFail($id);

        Return ApiResponse::success($Payteacher);
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

        return ApiResponse::success($payteacher, 200);
    }

    public function destroy($id)
    {
        $payteacher = Payteacher::findOrFail($id);
        $payteacher->delete();
        return ApiResponse::noContent();
    }
}
