<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin')->only('store','update','destroy');
    }
    // Affiche l'emploi du temps hebdomadaire pour une classe donnée
    public function index(Request $request)
    {
        $emploisDuTemps = Schedule::with(['classe', 'matiere', 'professeur'])
            ->where('classe_id', $request->classe_id)
            ->get();

        return  ApiResponse::success($emploisDuTemps);
    }

    // Crée un nouvel emploi du temps
    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $validator = Validator::make($request->all(), [
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'debut' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return  ApiResponse::validationError($validator->errors(), 422);
        }
        $data = $request->all();
        $data["promotion_id"]=$promotionId;
        $emploiDuTemps = Schedule::create($data);

        return  ApiResponse::created($emploiDuTemps, 201);
    }

    // Affiche un emploi du temps spécifique
    public function show($id)
    {
        $emploiDuTemps = Schedule::with(['classe', 'matiere', 'professeur'])->find($id);

        if (!$emploiDuTemps) {
            return  ApiResponse::success(['message' => 'Emploi du temps non trouvé'], 404);
        }

        return  ApiResponse::success($emploiDuTemps);
    }

    // Met à jour un emploi du temps
    public function update(Request $request, $id)
    {
        $emploiDuTemps = Schedule::find($id);

        if (!$emploiDuTemps) {
            return  ApiResponse::success(['message' => 'Emploi du temps non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'classe_id' => 'sometimes|required|exists:classes,id',
            'matiere_id' => 'sometimes|required|exists:matieres,id',
            'professeur_id' => 'sometimes|required|exists:professeurs,id',
            'jour' => 'sometimes|required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'debut' => 'sometimes|required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return  ApiResponse::success($validator->errors(), 422);
        }

        $emploiDuTemps->update($validator->validated());

        return  ApiResponse::success($emploiDuTemps);
    }

    // Supprime un emploi du temps
    public function destroy($id)
    {
        $emploiDuTemps = Schedule::find($id);

        if (!$emploiDuTemps) {
            return  ApiResponse::success(['message' => 'Emploi du temps non trouvé'], 404);
        }

        $emploiDuTemps->delete();

        return  ApiResponse::noContent();
    }
}
