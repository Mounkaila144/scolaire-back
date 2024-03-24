<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Eleve;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin|prof|eleve')->only(['getEvaluationsByEleve']);
        $this->middleware('permission:admin|prof')->except(['getEvaluationsByEleve']);
    }

    //filtrer par eleve
// Récupère toutes les evaluation pour un élève donné et charge les relations 'matiere' et 'eleve'
    public function getEvaluationsByEleve($eleveId)
    {
        // Récupère toutes les evaluation pour un élève donné et charge les relations 'matiere' et 'eleve'
        $evaluation = Evaluation::with(['matiere', 'eleve'])->where('eleve_id', $eleveId)->get();

        // Récupère l'utilisateur authentifié
        $user = auth()->user();

        // Vérifie si l'utilisateur authentifié est un élève et s'il essaie d'accéder aux evaluation d'un autre élève
        if ($user->hasRole('eleve')) {
            // Assurez-vous que l'ID de l'utilisateur correspond à l'ID de l'utilisateur associé à l'élève demandé
            $eleve = Eleve::findOrFail($eleveId);
            if (!$eleve || $user->id !== $eleve->user_id) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Retourne les evaluation si l'utilisateur est autorisé
        return ApiResponse::success($evaluation);
    }

// Récupère toutes les evaluation pour une matière donnée et charge la relation 'matiere'
    public function getEvaluationsByMatiere($matiereId)
    {
        if (!$matiereId) {
            return ApiResponse::notFound('Le paramètre matiereId est requis');
        }

        $evaluation = Evaluation::with(['matiere'])->where('matiere_id', $matiereId)->get();
        return ApiResponse::success($evaluation);
    }


    public function index()
    {
        $evalution = Evaluation::with(["matiere","eleve"])->get();
        return ApiResponse::success($evalution);
    }

    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required',
            'sur' => 'required',
            'type' => 'required',
            'matiere_id' => 'required',
            'eleve_id' => 'required',
        ]);


        $data = [
            'note' => $request->note,
            'sur' => $request->sur,
            'type' => $request->type,
            'matiere_id' => $request->matiere_id,
            'eleve_id' => $request->eleve_id
        ];

        $evaluation = Evaluation::create($data);

        return ApiResponse::created($evaluation);
    }
    public function show($id)
    {

        $Evaluation= Evaluation::findOrFail($id);

        Return ApiResponse::success($Evaluation);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        $evalution = Evaluation::findOrFail($id);
        $data = $request->all();

        $evalution->update($data);

        return ApiResponse::success($evalution, 200);
    }

    public function destroy($id)
    {
        $evalution = Evaluation::findOrFail($id);
        $evalution->delete();
        return ApiResponse::noContent();
    }
}
