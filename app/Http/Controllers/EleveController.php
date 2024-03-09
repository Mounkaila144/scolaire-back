<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreEleveRequest;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class EleveController extends Controller
{
    public function __construct() {
        $this->middleware('permission:admin');
    }
    public function index()
    {

        $eleve = Eleve::with(['user', 'classe'])->get();
        return ApiResponse::success($eleve);
    }

    public function filterByClasse($id)
    {

        if (!$id) {
            return ApiResponse::notFound('Le paramètre id est requis');
        }

        $eleves = Eleve::with(['user', 'classe'])->where('classe_id', $id)->get();
        return ApiResponse::success($eleves);
    }
    public function store(StoreEleveRequest $request)
    {
        $eleve = new Eleve($request->validated());
        $username = $this->generateUniqueUsername($request->input('prenom'));

        $password = $this->generateNumericPassword(8);
        $user = User::create([
            'nom' => $request->input('nom'), // Utilisez 'input' pour accéder aux valeurs
            'prenom' => $request->input('prenom'),
            'username' => $username,
            'password' => Hash::make($password),
          // Assurez-vous que le champ "passwordinit" existe dans le modèle
        ]);
        $eleve->user_id = $user->id; // Assurez-vous que le modèle Eleve a un champ user_id
        $eleve->passwordinit = $password; // Assurez-vous que le modèle Eleve a un champ user_id
        // Sauvegarde de l'élève dans la base de données
        $eleve->save();

        // Ajout de l'élève à des promotions si un identifiant de promotion est fourni
        if ($promotionId = $request->header('X-Promotion')) {
            // Assurez-vous que le modèle Eleve a une relation many-to-many avec Promotion
            $promotion = Promotion::findOrFail($promotionId);
            $eleve->promotions()->attach($promotion);
        }

        // Charger les relations nécessaires pour la réponse, si nécessaire
        $eleve->load('user', 'promotions');

        // Retourner une réponse API avec le nouvel élève créé
        return ApiResponse::created($eleve, 'Élève créé avec succès');
    }
    private function generateNumericPassword($length)
    {
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= mt_rand(0, 9);
        }

        return $password;
    }
    private function generateUniqueUsername($prenom)
    {
        $username = strtolower($prenom);
        $i = 1;

        // Vérifier l'unicité de l'username
        while (User::where('username', $username)->exists()) {
            $username = strtolower($prenom . $i);
            $i++;
        }

        return $username;
    }
    public function show($id)
    {

        $Eleve= Eleve::with(['user', 'classe'])->findOrFail($id);

        Return ApiResponse::success($Eleve);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        // Mise à jour des champs fournis dans la requête
        $eleve->update($request->all());

//        // Si un nouvel identifiant de promotion est fourni, mettez à jour la relation
//        if ($promotionId) {
//            $promotion = Promotion::findOrFail($promotionId);
//            $eleve->promotions()->sync($promotion);
//        }

        // Mise à jour optionnelle de l'utilisateur lié
        if ($request->has('nom') || $request->has('prenom')) {
            $user = $eleve->user;
            $user->update([
                'nom' => $request->input('nom', $user->nom),
                'prenom' => $request->input('prenom', $user->prenom),
                // Ajoutez d'autres champs ici si nécessaire
            ]);
        }

        // Charger la relation "classe" pour l'inclure dans la réponse
        $eleve->load('classe');

        return ApiResponse::success($eleve, 200);
    }

    public function destroy($id)
    {
        $eleve = Eleve::findOrFail($id);

        // Delete related records first
        $eleve->promotions()->detach(); // Assuming there's a many-to-many relationship with promotions

        // Now delete the eleve
        $eleve->delete();

        return ApiResponse::noContent();
    }

}
