<?php
// app/Http/Controllers/AuthAtelier.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAtelier extends Controller
{
    public function showLoginForm()
    {
        return view('login.atelier-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('atelier')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('atelierss.statistiques');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('atelier')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/atelier/loginA');
    }
}
