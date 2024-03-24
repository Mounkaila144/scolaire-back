<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
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
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return ApiResponse::error('Unauthorized', null, 401);
        }

        return $this->createNewToken($token);
    }
    protected function createNewToken($token) {
        return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user(),
        ], 'Token created successfully');
    }
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function register(Request $request)
    {
        $requiredFields = ['nom', 'prenom'];
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

        ]);
        $username = $this->generateUniqueUsername($request->input('prenom'));

        $password = $this->generateNumericPassword(8);
        $user = User::create([
            'nom' => $request->input('nom'), // Utilisez 'input' pour accéder aux valeurs
            'prenom' => $request->input('prenom'),
            'username' => $username,
            'role' => $request->input('role'),
            'password' => Hash::make($request->input('password')),
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
        return ApiResponse::success([
        'user' => Auth::guard('api')->user(),
    ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return ApiResponse::success([], 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */


}
