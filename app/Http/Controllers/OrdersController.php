<?php

namespace App\Http\Controllers;
use App\Models\Eleve;
use App\Models\Order;
use App\Models\Vente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request, Order $products)
    {
        $products = $products->newQuery();
        return $products->get();


    }
    public function show($id)
    {
        $order = Order::find($id);
        $contenue=json_decode($order->data);
        $total=0;
        foreach ($contenue as$value){
            $total+=$value->itemTotal;
        }
        return view('reservation.facture',["order"=>$order,"contenue"=>$contenue,"total"=>$total]);
    }

    function state(Request $request, $id)
    {
        $order = Order::find($id);

                $order->state?$order->update(["state" => false]):$order->update(["state" => true]);

            return response()->json("change");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $r
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {

        $contenue = $request->input(["data"]);
        $total = 0;

        foreach ($contenue as $value) {
            $total += $value['itemTotal'];
        }


        $save = new Order();
        $save->name = $request->input(["name"]);
        $save->lastname = $request->input(["lastname"]);
        $save->adresse = $request->input(["adresse"]);
        $save->phone = $request->input(["phone"]);
        $save->state = $request->input(["state"]);
        $save->data = json_encode($request->input(["data"]));
        $save->user_id = (int)$request->get('user_id');
        $save->save();
        $contenue = json_decode($save->data);
        foreach ($contenue as $content) {
            $produt = Eleve::findOrFail($content->id);
            if ($produt->stock - $content->quantity < 0 or $produt->stock < $content->quantity) {
                throw new Exception("Database error");
            } else {
                $produt->update(["stock" => $produt->stock - $content->quantity]);
                $produt->update([ "vendue" => $produt->vendue + $content->quantity]);

                $vente = new Vente();
                $vente->name = $produt->name;
                $vente->identifiant=$save->id;
                $vente->price = $produt->price;
                $vente->quantity = $content->quantity;
                $vente->user_id = $save->user_id;
                $vente->save();
            }
        }


        return response()->json($save);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->input(["data"]);
        $d = [];
        foreach ($data as $id) {
            $d[] = Order::findOrFail($id);
        }

        foreach ($d as $order) {
            if ($order) {
                $contenue = json_decode($order->data);
                foreach ($contenue as $content) {
                    $produt = Eleve::find($content->id);
                    $produt===null?null:$produt->update(["stock" => $produt->stock + $content->quantity,"vendue" => $produt->vendue - $content->quantity]);
                }
                Vente::where("identifiant",$order->id)->delete();
                $order->delete();
            } else {
                return response()->json("eureur");
            }
        }
        return response()->json("sucess");
    }
}
