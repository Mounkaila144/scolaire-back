<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Categorie;
use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Categorie $categories)
    {

        return Categorie::orderBy('id', 'ASC')->get();


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $save = new Categorie();
        $save->name = $request->input(["name"]);
        $save->save();

        return response()->json($save);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Categorie $categorie
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $Categorie = Categorie::find($id);

        return response()->json($Categorie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);
        $data = [];
        $request->has('name') ? $data["name"] = $request->input(["name"]) : null;
        $categorie->update($data);
        return response()->json($categorie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Categorie $categorie
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request): \Illuminate\Http\JsonResponse
    {
        $categorie = Categorie::findOrFail($id);

        if ($categorie) {
            $products = $categorie->products;

            foreach ($products as $product) {
                $stock = new Stock();
                $stock->type = "delete";
                $stock->nom = $product->name;
                $stock->identifiant = $product->id;
                $stock->users_id = (int)$request->input("user");
                $stock->save();

                Storage::delete('public/product/' . $product->picture);
                $product->delete();
            }

            $categorie->delete();
        } else {
            return response()->json("erreur");
        }

        return response()->json(null);
    }



}
