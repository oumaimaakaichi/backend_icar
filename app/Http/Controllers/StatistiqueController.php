<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EntrepriseContractante;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Compter les utilisateurs par rôle
        $techniciensCount = User::where('role', 'technicien')->count();
        $expertsCount = User::where('role', 'expert')->count();
        $employesCount = User::where('role', 'Client')->count();

        // Compter les entreprises contractantes
        $entreprisesCount = EntrepriseContractante::count();

        return view('Admin.statistiques', compact(
            'techniciensCount',
            'expertsCount',
            'employesCount',
            'entreprisesCount'
        ));
    }
}
