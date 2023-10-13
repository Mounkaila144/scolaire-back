<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Professeur;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfController extends Controller
{
    public function index()
    {
        $prof = Professeur::with(['user'])->get();
        return response()->json($prof);
    }

    public function store(Request $request)
    {

        if (Classe::exists()) {
        $requiredFields = [
            'number',
            'adresse',
            'birth',
            'nationalite',
            'genre',
//            'user_id'
        ]; // Champs requis
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (is_null($request->input($field))) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            $errorMessage = count($missingFields) > 1 ? 'Les champs suivants sont manquants : ' : 'Le champ suivant est manquant : ';
            $errorMessage .= implode(', ', $missingFields);

            return $this->errorResponse(
                $errorMessage,
                Response::HTTP_BAD_REQUEST
            );
        }
        $userController = new UserController();
        $profrequest=[
            'nom' => $request->input('nom'), // Utilisez 'input' pour accéder aux valeurs
            'prenom' => $request->input('prenom'),
            'role' => "prof",
        ];
        $userResponse = $userController->store(new Request($profrequest));
        // Une fois que l'utilisateur est créé, vous pouvez récupérer l'utilisateur nouvellement créé
        $user = $userResponse->original['user'];
        $data = $request->all();
        $data["user_id"] = $user->id;
        $prof = Professeur::create($data);
        $prof->save();

            return response()->json($prof, 201);
    }
        else{
        return $this->errorResponse(
            "Aucune prof n'exist ans la base de donner",
            Response::HTTP_BAD_REQUEST
        );
    }
    }
    public function show($id)
    {

        $Professeur= Professeur::findOrFail($id);

        Return response()->json($Professeur);
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

        return response()->json($prof, 200);
    }

    public function destroy($id)
    {
        $prof = Professeur::findOrFail($id);

        // Now delete the prof
        $prof->delete();

        return response()->json(null, 204);
    }

}
