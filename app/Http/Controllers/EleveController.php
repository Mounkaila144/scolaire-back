<?php
namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EleveController extends Controller
{
    public function index()
    {
        $depense = Eleve::all();
        return response()->json($depense);
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
            'classe_id',
            'promotion_id',
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
        $eleverequest=[
            'nom' => $request->input('nom'), // Utilisez 'input' pour accéder aux valeurs
            'prenom' => $request->input('prenom'),
            'role' => "eleve",
        ];
        $userResponse = $userController->store(new Request($eleverequest));
        // Une fois que l'utilisateur est créé, vous pouvez récupérer l'utilisateur nouvellement créé
        $user = $userResponse->original['user'];
        $data = $request->all();
        $data["user_id"] = $user->id;
        $eleve = Eleve::create($data);
        $eleve->save();
            // Associer la promotion choisie à l'élève
            $promotionId = $request->input('promotion_id');
            $promotion = Promotion::findOrFail($promotionId);
            $eleve->promotions()->attach($promotion);
            // Load the "classe" relationship
            $eleve->load('classe');

            return response()->json($eleve, 201);
    }
        else{
        return $this->errorResponse(
            "Aucune eleve n'exist ans la base de donner",
            Response::HTTP_BAD_REQUEST
        );
    }
    }
    public function show($id)
    {

        $Eleve= Eleve::findOrFail($id);

        Return response()->json($Eleve);
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
        $eleve->update($request->all());

        return response()->json($eleve, 200);
    }

    public function destroy($id)
    {
        $eleve = Eleve::findOrFail($id);

        // Delete related records first
        $eleve->promotions()->detach(); // Assuming there's a many-to-many relationship with promotions

        // Now delete the eleve
        $eleve->delete();

        return response()->json(null, 204);
    }

}
