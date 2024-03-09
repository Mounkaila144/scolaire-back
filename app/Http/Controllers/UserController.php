<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'admin')->get();
        return response()->json($users);
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
    public function store(Request $request)
    {
        $requiredFields = ['nom', 'prenom', 'role'];
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
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|string|max:255',

        ]);
        $username = $this->generateUniqueUsername($request->input('prenom'));

        $password = $this->generateNumericPassword(8);
        $user = User::create([
            'nom' => $request->input('nom'), // Utilisez 'input' pour accéder aux valeurs
            'prenom' => $request->input('prenom'),
            'username' => $username,
            'role' => $request->input('role'),
            'password' => Hash::make($password),
            'passwordinit' =>$password, // Assurez-vous que le champ "passwordinit" existe dans le modèle
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }
    public function show($id)
    {

        $User= User::findOrFail($id);

        Return response()->json($User);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
