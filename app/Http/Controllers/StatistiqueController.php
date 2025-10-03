<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EntrepriseContractante;
use App\Models\Demande;
use App\Models\DemandePanneInconnu;

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

        // === DEMANDES CONNUES ===
        $demandesConnuesCount = Demande::count();

        // Demandes connues dédiées aux entreprises (atelier_id = null)
        $demandesConnuesEntreprisesCount = Demande::whereNull('atelier_id')->count();

        // Demandes connues envoyées à nos ateliers (atelier_id not null)
        $demandesConnuesAteliersCount = Demande::whereNotNull('atelier_id')->count();

        // === DEMANDES INCONNUES ===
        $demandesInconnuesCount = DemandePanneInconnu::count();

        // Demandes inconnues dédiées aux entreprises (atelier_id = null)
        $demandesInconnuesEntreprisesCount = DemandePanneInconnu::whereNull('atelier_id')->count();

        // Demandes inconnues envoyées à nos ateliers (atelier_id not null)
        $demandesInconnuesAteliersCount = DemandePanneInconnu::whereNotNull('atelier_id')->count();

        // === TOTAUX ===
        $totalDemandes = $demandesConnuesCount + $demandesInconnuesCount;
        $totalDemandesEntreprises = $demandesConnuesEntreprisesCount + $demandesInconnuesEntreprisesCount;
        $totalDemandesAteliers = $demandesConnuesAteliersCount + $demandesInconnuesAteliersCount;

        // === STATISTIQUES PAR STATUS (optionnel) ===
        $demandesConnuesParStatus = Demande::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $demandesInconnuesParStatus = DemandePanneInconnu::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('Admin.statistiques', compact(
            'techniciensCount',
            'expertsCount',
            'employesCount',
            'entreprisesCount',

            // Demandes connues
            'demandesConnuesCount',
            'demandesConnuesEntreprisesCount',
            'demandesConnuesAteliersCount',

            // Demandes inconnues
            'demandesInconnuesCount',
            'demandesInconnuesEntreprisesCount',
            'demandesInconnuesAteliersCount',

            // Totaux
            'totalDemandes',
            'totalDemandesEntreprises',
            'totalDemandesAteliers',

            // Statistiques par status
            'demandesConnuesParStatus',
            'demandesInconnuesParStatus'
        ));
    }

    /**
     * Méthode pour obtenir des statistiques détaillées des demandes
     */
    public function getDemandesStats()
    {
        return [
            'demandes_connues' => [
                'total' => Demande::count(),
                'entreprises' => Demande::whereNull('atelier_id')->count(),
                'ateliers' => Demande::whereNotNull('atelier_id')->count(),
                'par_status' => Demande::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status')
                    ->toArray()
            ],
            'demandes_inconnues' => [
                'total' => DemandePanneInconnu::count(),
                'entreprises' => DemandePanneInconnu::whereNull('atelier_id')->count(),
                'ateliers' => DemandePanneInconnu::whereNotNull('atelier_id')->count(),
                'par_status' => DemandePanneInconnu::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status')
                    ->toArray()
            ]
        ];
    }

    /**
     * Méthode pour obtenir les statistiques mensuelles
     */
    public function getStatsParMois()
    {
        $demandesConnuesParMois = Demande::selectRaw('MONTH(created_at) as mois, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('count', 'mois')
            ->toArray();

        $demandesInconnuesParMois = DemandePanneInconnu::selectRaw('MONTH(created_at) as mois, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('count', 'mois')
            ->toArray();

        return [
            'demandes_connues' => $demandesConnuesParMois,
            'demandes_inconnues' => $demandesInconnuesParMois
        ];
    }
}
