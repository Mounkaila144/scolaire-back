<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Order;
use App\Models\Eleve;
use App\Models\Entresorti;
use App\Models\Facture;
use App\Models\Stock;
use App\Models\Suplier;
use App\Models\User;
use App\Models\Vente;
use App\Models\Ventereservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Dahboard extends Controller
{


    public function TotalProduct(Request $request, Eleve $product, Vente $vente, Entresorti $entresorti, Ventereservation $ventereservation)
    {
        $data = [];
        $data["TotalProduct"] = Eleve::count();
        $data["TotalProductAlert"] = Eleve::whereColumn('alert', '>=', 'stock')->count(); // Get products where alert < stock
        $data["TotalOrder"] = Order::count();
        $data["TotalOrderFalse"] = Order::where('state', false)->count(); // Get count of orders with state false
        $data["TotalOrderTrue"] = Order::where('state', true)->count();
        $data["TotalUser"] = User::count();
        $data["TotalCategorie"] = Categorie::count();
        $data["TotalSuplier"] = Suplier::count();
        $data["productVendue"] = $vente->count();
        $data["productVendueJour"] =  (int)DB::table('ventes')
                ->select(DB::raw('SUM(price) as sum'))
                ->whereDate('created_at', '=', Carbon::today())->first()->sum ;

        $data["productVendueMoi"] = (int)DB::table('ventes')
                ->select(DB::raw('SUM(price) as sum'))
                ->whereMonth('created_at', '=', Carbon::now()->month)->first()->sum;

        $data["productVendueAnnee"] = (int)DB::table('ventes')
                ->select(DB::raw('SUM(price) as sum'))
                ->whereYear('created_at', '=', Carbon::now()->year)->first()->sum ;


        return $data;
    }

}
