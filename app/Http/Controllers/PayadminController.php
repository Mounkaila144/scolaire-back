<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Professeur;
use App\Models\Payadmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayadminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function index()
    {
        $payadmin = Payadmin::with(["user"])->get();
        return ApiResponse::success($payadmin);
    }

    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $request->validate([
            'prix' => 'required',
            'user_id' => 'required',
        ]);


        $data = [
            'prix' => $request->prix,
            'user_id' => $request->user_id,
            'promotion_id' => $promotionId
        ];

        $paytecher = Payadmin::create($data);

        return ApiResponse::created($paytecher);
    }
    public function show($id)
    {

        $Payadmin= Payadmin::findOrFail($id);

        Return ApiResponse::success($Payadmin);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $payadmin = Payadmin::findOrFail($id);
        $data = $request->all();

        $payadmin->update($data);

        return ApiResponse::success($payadmin, 200);
    }

    public function destroy($id)
    {
        $payadmin = Payadmin::findOrFail($id);
        $payadmin->delete();
        return ApiResponse::noContent();
    }
}
