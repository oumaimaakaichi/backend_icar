<?php
// app/Http/Controllers/AuthAtelier.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EntrepriseContractante;

class AuthEntrepriseContractante extends Controller
{
    public function showLoginForm()
    {
        return view('login.entreprise-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        logger()->info('Tentative de connexion', ['email' => $credentials['email']]);

        if (Auth::guard('entreprise')->attempt($credentials)) {
            logger()->info('Connexion réussie', ['user' => Auth::guard('entreprise')->user()]);
            $request->session()->regenerate();
            return redirect()->route('sidebarEntreprise');
        }

        logger()->error('Échec de connexion', ['email' => $credentials['email']]);
        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('entreprise')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/entreprise/login');
    }
}
