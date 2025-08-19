<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\Atelier;
use App\Models\Entreprise;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('login.unified-login');
    }

    // Connexion API pour mobile
    public function loginUser(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = Auth::guard('api')->attempt($credentials)) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => Auth::guard('api')->user(),
    ]);
}


    // Traitement de la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Essayer de se connecter avec chaque guard jusqu'à trouver le bon
        $guards = ['web', 'atelier', 'entreprise'];
        $successfulGuard = null;
        $user = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($request->only('email', 'password'))) {
                $successfulGuard = $guard;
                $user = Auth::guard($guard)->user();
                break;
            }
        }

        if ($successfulGuard && $user) {
            $request->session()->put('auth_guard', $successfulGuard);
            $request->session()->regenerate();

            // Redirection basée sur le type d'utilisateur
            switch ($successfulGuard) {
                case 'web':
                    if ($user->role === 'admin') {
                        return redirect()->route('technicien');
                    } elseif ($user->role === 'expert' && $user->isActive ) {
                        return redirect()->route('demandes.statistics');
                    } elseif ($user->role === 'Responsable_piece') {
                        return redirect()->route('responsable.choice');
                    }
                    break;

                case 'atelier':
                    if($user->is_active){
                    return redirect()->route('atelierss.statistiques');
                    }
                case 'entreprise':
                    return redirect()->intended(route('entreprise.statistiques'));
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ])->onlyInput('email');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $guards = ['web', 'atelier', 'entreprise'];

        foreach ($guards as $guard) {
            Auth::guard($guard)->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
