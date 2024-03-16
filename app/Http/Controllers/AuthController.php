<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class AuthController extends Controller
{


    // Le constructeur reste inchangé si vous souhaitez garder certaines middleware pour d'autres méthodes
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    // Méthode de login adaptée pour une authentification classique avec redirection
    public function login_view()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['userename', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/index');
        }

        return back()->withErrors([
            'userename' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    // Méthode de logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirection vers la page de login ou autre
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



}
