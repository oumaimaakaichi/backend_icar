<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion unifié
    public function showLoginForm()
    {
        return view('login.unified-login'); // Créez cette vue avec un sélecteur de type d'utilisateur
    }
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
            'password' => 'required|string',
            'user_type' => 'required|in:admin,expert,Responsable_piece,atelier,entreprise'
        ]);

        $guard = match($request->user_type) {
            'admin', 'expert' , 'Responsable_piece' => 'web',
            'atelier' => 'atelier',
            'entreprise' => 'entreprise',
            default => 'web'
        };

        // Ajoutez un log pour débogage
        \Log::info("Tentative de connexion avec guard: {$guard}", [
            'email' => $request->email,
            'user_type' => $request->user_type
        ]);

        if (Auth::guard($guard)->attempt($request->only('email', 'password'))) {
            \Log::info("Connexion réussie avec guard: {$guard}");
            $request->session()->put('auth_guard', $guard);
            $request->session()->regenerate();

            return match($request->user_type) {
                'admin' => redirect()->route('technicien'),
                'expert' => redirect()->route('expert.demande_maintenance'),
               'Responsable_piece' => redirect()->route('reponsable_piece.demandes'),
                'atelier' => redirect()->route('atelierss.statistiques'),
                'entreprise' => redirect()->intended(route('entreprise.statistiques')),
                default => redirect('/')
            };
        }
else{
    \Log::error("Échec de connexion pour guard: {$guard}");
}

        return back()->withErrors([
            'email' => 'Identifiants incorrects pour ce type de compte',
        ])->onlyInput('email');
    }

    // Déconnexion unifiée
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

    // Méthodes helpers
    protected function getGuard($userType)
    {
        return match($userType) {
            'admin', 'expert' => 'web',
            'atelier' => 'atelier',
            'entreprise' => 'entreprise',
            default => 'web'
        };
    }

    protected function getRedirectRoute($userType)
    {
        return match($userType) {
            'admin' => 'technicien',
            'expert' => 'expert.demande_maintenance',
            'atelier' => 'atelierss.statistiques',
            'entreprise' => 'sidebarEntreprise',
            default => '/'
        };
    }

    protected function attemptLogin($request, $guard)
    {
        return Auth::guard($guard)->attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        );
    }

    protected function sendFailedLoginResponse($request)
    {
        return back()->withErrors([
            'email' => 'Identifiants incorrects pour ce type de compte',
        ])->onlyInput('email');
    }

    protected function apiResponse($guard)
    {
        $user = Auth::guard($guard)->user();
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}
