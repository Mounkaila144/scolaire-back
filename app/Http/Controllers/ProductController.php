<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Stock;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Eleve $products)
    {
        $products = $products->newQuery();
        if ($request->has("categorie")) {
            return $products
                ->where("categorie", "=", $request->get("categorie"))
                ->get();
        }
        elseif ($request->has("alert")){
           $data= Eleve::whereColumn('alert', '>=', 'stock')->get();
           dd($data);
        }

        return Eleve::orderBy('id', 'ASC')
            ->with('categorie','suplier') // Chargement de la relation "categorie" avec uniquement la colonne "name"
            ->get();


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
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'price' => 'required|numeric',
            'alert' => 'required|numeric',
            'categorie' => 'required|numeric',
            'stock' => 'required|numeric',
            'suplier' => 'required|numeric',
        ]);

        $pictureName = time() . '.' . $request->file('picture')->getClientOriginalExtension();

        // Compress the image before storing
        $compressedImage = Image::make($request->file('picture'))
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        // Store the compressed image
        Storage::put('public/product/' . $pictureName, $compressedImage);

        $save = new Eleve();
        $save->picture = $pictureName;
        $save->name = $request->input('name');
        $save->price = (int) $request->input('price');
        $save->alert = (int) $request->input('alert');
        $save->categorie = (int) $request->input('categorie');
        $save->stock = (int) $request->input('stock');
        $save->suplier = (int) $request->input('suplier');
        $save->vendue = 0;
        $save->save();

        return response()->json($save);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Eleve $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $Product = Eleve::find($id);

        return response()->json($Product);
    }


    public function updateProductPicture(Request $request, $productId)
    {
        // Validate the incoming request
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve the product
        $product = Eleve::findOrFail($productId);

        // Delete the previous picture if it exists
        if ($product->picture) {
            Storage::delete('public/product/' . $product->picture);
        }

        // Upload and store the new picture
        $pictureName = time() . '.' . $request->file('picture')->getClientOriginalExtension();

        // Compress the image before saving
        $compressedImage = Image::make($request->file('picture'))
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75);

        // Save the compressed image
        Storage::put('public/product/' . $pictureName, $compressedImage);

        // Update the product with the new picture name
        $product->picture = $pictureName;
        $product->save();

        return response()->json(['message' => "Eleve picture updated successfully"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Eleve::findOrFail($id);
        $data = [];
        $pictureName = '';

        if ($request->has('stock')) {
            if ($request->input(["stock"]) > 0 && $product->stock<$request->input(["stock"])) {
                $product->update(["stock" => $product->stock + $request->input(["stock"])]);
                $stock = new Stock();
                $stock->type = "add";
                $stock->identifiant = $product->id;
                $stock->quantity = $request->input(["stock"]);
                $stock->name = $product->name;
                $stock->users_id = $request->input(["user"]);
                $stock->save();
                return response()->json($product);
            }
           else if ($request->input(["stock"]) > 0 and $product->stock > $request->input(["stock"])) {
                $product->update(["stock" => $product->stock - $request->input(["stock"])]);
                $stock = new Stock();
                $stock->type = "remove";
                $stock->identifiant = $product->id;
                $stock->quantity = $request->input(["stock"]);
                $stock->name = $product->name;
                $stock->users_id = $request->input(["user"]);
                $stock->save();
                return response()->json($product);
            }
           else if ($product->stock = $request->input(["stock"])) {

           }
           else {
                throw new Exception("Database error");
            }
        }
        if ($request->has('price')) {
            if ($request->input(["price"]) >=0) {
                $product->update(["price" => $request->input(["price"])]);
                $stock = new Stock();
                $stock->type = "prix";
                $stock->identifiant = $product->id;
                $stock->name = $product->name;
                $stock->price = $request->input(["price"]);
                $stock->users_id = $request->input(["user"]);
                $stock->save();
            }
            else {
                throw new Exception("Database error");
            }
        }

        $request->has('name') ? $data["name"] = $request->input(["name"]) : null;
        $request->has('categorie') ? $data['categorie'] = $request->input(["categorie"]) : null;
        $request->has('suplier') ? $data['suplier'] = $request->input(["suplier"]) : null;
        $request->has('alert') ? $data['alert'] = (int)$request->input(["alert"]) : null;
        $product->update($data);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Eleve $product
     * @return \Illuminate\Http\JsonResponse
     */
//    public function destroy($id): \Illuminate\Http\JsonResponse
//    {
//
//        $Eleve = Eleve::findOrFail($id);
//        if ($Eleve) {
//            Storage::delete('public/product/' . $Eleve->picture);
//            $Eleve->delete();
//        } else
//            return response()->json("eureur");
//        return response()->json(null);
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Eleve $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->input(["data"]);

        $d = [];
        foreach ($data as $id) {
            $d[] = Eleve::findOrFail($id);
        }

        foreach ($d as $Product) {
            if ($Product) {
                $stock = new Stock();
                $stock->type = "delect";
                $stock->name = $Product->name;
                $stock->identifiant = $Product->id;
                $stock->users_id = (int)$request->input(["user"]);
                $stock->save();
                Storage::delete('public/product/' . $Product->picture);
                $Product->delete();
            }
        }
        return response()->json("sucess");
    }

}
