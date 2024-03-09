<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreProfRequest;
use App\Models\Classe;
use App\Models\Professeur;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ProfController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin')->except(['show']);
    }
    public function index()
    {
        $prof = Professeur::with(['user'])->get();
        return ApiResponse::success($prof);
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
    public function store(StoreProfRequest $request)
    {
        $prof = new Professeur($request->validated());
        $username = $this->generateUniqueUsername($request->input('prenom'));

        $password = $this->generateNumericPassword(8);
        $user = User::create([
            'nom' => $request->input('nom'), // Utilisez 'input' pour accéder aux valeurs
            'prenom' => $request->input('prenom'),
            'username' => $username,
            'password' => Hash::make($password),
            // Assurez-vous que le champ "passwordinit" existe dans le modèle
        ]);
        $prof->user_id = $user->id; // Assurez-vous que le modèle Eleve a un champ user_id
        $prof->passwordinit = $password; // Assurez-vous que le modèle Eleve a un champ user_id
        // Sauvegarde de l'élève dans la base de données
        $prof->save();

        // Charger les relations nécessaires pour la réponse, si nécessaire
        $prof->load('user');

        // Retourner une réponse API avec le nouvel élève créé
        return ApiResponse::created($prof, 'Prof créé avec succès');
    }
    public function show($id)
    {

        $Professeur= Professeur::findOrFail($id);

        Return ApiResponse::success($Professeur);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $prof = Professeur::findOrFail($id);
        $prof->update($request->all());

        return ApiResponse::success($prof);
    }

    public function destroy($id)
    {
        $prof = Professeur::findOrFail($id);

        // Now delete the prof
        $prof->delete();

        return ApiResponse::noContent();
    }

}
