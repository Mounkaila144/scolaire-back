<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    public function updater(Request $request, $id)
    {
        dd("hello");

    }



    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $user->load('roles');
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);

    }

    public function register(Request $request)
    {
        $requiredFields = ['nom', 'prenom', 'role'];
        foreach ($requiredFields as $field) {
            if (is_null($request->input($field))) {
                return $this->errorResponse(
                    'Un ou plusieurs champs sont manquants',
                    Response::HTTP_BAD_REQUEST
                );
            }
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
            'password' => Hash::make($request->input('password')),
            'passwordinit' =>$password, // Assurez-vous que le champ "passwordinit" existe dans le modèle
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
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
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
