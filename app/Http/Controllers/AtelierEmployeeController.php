<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AtelierEmployeeController extends Controller
{
    public function create()
    {
        return view('atelier', [
            'atelier_id' => auth()->id() // L'ID de l'atelier connecté
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',

        ]);

        // Création de l'employé
        $employee = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'adresse' => $request->adresse,
            'role' => 'Client',
            'atelier_id' => $request->atelier_id, // Lier à l'atelier connecté
            'isActive' => false, // Désactivé par défaut

        ]);

        return redirect()->route('atelierss.employeeAtelier')
                         ->with('success', 'Employé enregistré avec succès! Un administrateur validera son compte.');
    }



    public function update(Request $request, User $employee)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$employee->id,
            'phone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'nom_entreprise' => 'required|string|max:255',
            'carte_professionnel' => 'required|string|max:50',
            'photo_carte_identite' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $employee->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'adresse' => $request->adresse,
            'extra_data' => [
                'nom_entreprise' => $request->nom_entreprise,
                'carte_professionnel' => $request->carte_professionnel,
                'photo_carte_identite' => $request->hasFile('photo_carte_identite')
                    ? $request->file('photo_carte_identite')->store('carte_identite', 'public')
                    : ($employee->extra_data['photo_carte_identite'] ?? null)
            ]
        ]);

        return redirect()->back()->with('success', 'Employee updated successfully!');
    }
}
