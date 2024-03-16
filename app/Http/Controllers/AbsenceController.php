<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreEleveRequest;
use App\Models\Absence;
use App\Models\Classe;
use App\Models\Depense;
use App\Models\Eleve;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin|prof|eleve')->only(['getAbsencesByEleve']);
        $this->middleware('permission:admin|prof')->except(['getAbsencesByEleve']);
    }

    //filtrer par eleve
// Récupère toutes les absences pour un élève donné et charge les relations 'matiere' et 'eleve'
    public function getAbsencesByEleve($eleveId)
    {
        // Récupère toutes les absences pour un élève donné et charge les relations 'matiere' et 'eleve'
        $absences = Absence::with(['matiere', 'eleve'])->where('eleve_id', $eleveId)->get();

        // Récupère l'utilisateur authentifié
        $user = auth()->user();

        // Vérifie si l'utilisateur authentifié est un élève et s'il essaie d'accéder aux absences d'un autre élève
        if ($user->hasRole('eleve')) {
            // Assurez-vous que l'ID de l'utilisateur correspond à l'ID de l'utilisateur associé à l'élève demandé
            $eleve = Eleve::findOrFail($eleveId);
            if (!$eleve || $user->id !== $eleve->user_id) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Retourne les absences si l'utilisateur est autorisé
        return ApiResponse::success($absences);
    }

// Récupère toutes les absences pour une matière donnée et charge la relation 'matiere'
    public function getAbsencesByMatiere($matiereId)
    {
        if (!$matiereId) {
            return ApiResponse::notFound('Le paramètre matiereId est requis');
        }

        $absences = Absence::with(['matiere'])->where('matiere_id', $matiereId)->get();
        return ApiResponse::success($absences);
    }

    public function store(Request $request)
    {
        $promotionId = $request->header('X-Promotion');

        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'matiere_id' => 'required|exists:matieres,id',
            'eleves_absents' => 'required|array',
            'eleves_absents.*.id' => 'required|exists:eleves,id',
            'eleves_absents.*.justifiee' => 'required|boolean',
        ]);

        foreach ($validated['eleves_absents'] as $absenceInfo) {
            Absence::create([
                'eleve_id' => $absenceInfo['id'],
                'schedule_id' => $validated['schedule_id'],
                'matiere_id' => $validated['matiere_id'],
                'justifiee' => $absenceInfo['justifiee'],
                'promotion_id' => $promotionId,
                // Assurez-vous d'inclure ici tous les autres champs requis par votre modèle Absence
            ]);
        }

        return ApiResponse::created();
    }


    public function update(Request $request, $id)
    {
        $absence = Absence::findOrFail($id); // Trouve l'absence par ID ou renvoie une erreur 404

        $validated = $request->validate([
            'justifiee' => 'required|boolean', // Valide que le champ 'justifiee' est bien un booléen
            // Ajoutez toute autre validation nécessaire ici
        ]);

        // Mise à jour de l'absence
        $absence->update($validated);

        return ApiResponse::success($absence);
    }


    public function destroy($id)
    {
        $absence = Depense::findOrFail($id);
        $absence->delete();
        return ApiResponse::noContent();
    }


}
