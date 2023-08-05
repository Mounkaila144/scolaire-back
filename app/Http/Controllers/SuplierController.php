<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request ,Suplier $supliers)
    {
        return  Suplier::all();


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $save = new Suplier();
        $save->name =$request->input(["name"]);
        $save->phone =$request->input(["phone"]);
        $save->adresse =$request->get('adresse');
        $save->save();

        Return response()->json($save);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $Suplier= Suplier::find($id);

        Return response()->json($Suplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,Suplier $suplier)
    {
        $input=$request->all();
        $suplier->update($input);
        $suplier->save();
            return response()->json($suplier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suplier  $suplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->input(["data"]);
        $d = [];
        foreach ($data as $id) {
            $d[] = Suplier::findOrFail($id);
        }

        foreach ($d as $suplier) {
            if ($suplier) {
                $suplier->delete();
            } else {
                return response()->json("eureur");
            }
        }
        return response()->json("sucess");
    }


}
