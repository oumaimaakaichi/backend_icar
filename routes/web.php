<?php

// routes/web.php
use App\Models\User;
use App\Models\Atelier;
use App\Models\EntrepriseContractante;
use App\Models\SparePart;
use App\Models\Catalogue;
use App\Models\DemandeMaintenance;
use App\Models\MaintenanceTicket;
use App\Models\LoyaltyPoint;
use App\Models\TypeTickets;
use App\Models\Specialisation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CamionController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\Entreprise_contractanteController;
use App\Http\Controllers\VoitureController;
use App\Http\controllers\PointDeFideliteController;
use App\Http\Controllers\LoyaltyPointsController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\AuthAtelier;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\CouleurController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\MaintenanceTicketController;
use App\Http\Controllers\SpecialisationController;
use App\Http\Controllers\TypeTicketController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EntrepriseAutomobileController;
use App\Http\Controllers\ForfaitController;
use App\Http\Controllers\ClassificationPieceController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\AtelierEmployeeController;
use App\Http\Controllers\AuthEntrepriseContractante;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\DemandeMaintenanceController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\FluxDirectController;
use App\Http\Controllers\PieceRecommandeeController;
use App\Http\Controllers\DemandeFluxController;
use App\Http\Controllers\ServicePanneController;
use App\Http\Controllers\CategoryPaneController;
use App\Http\Controllers\DemandePanneInconnuController;
use App\Http\Controllers\DemandeFluxInconnuPanneController;
use App\Http\Controllers\AtelierAvailabilityController;
use App\Http\Controllers\TicketAssistanceController;
use App\Http\Controllers\RapportMaintenanceController;
use App\Http\Controllers\AssistanceAtelierController;


   Route::get('/assistance', [AssistanceAtelierController::class, 'index'])->name('assistance.index');
   Route::post('/assistance', [AssistanceAtelierController::class, 'store'])->name('assistance.store');
    Route::get('/assistance/{id}', [AssistanceAtelierController::class, 'show'])->name('assistance.show');
Route::middleware(['auth'])->group(function () {


});
Route::prefix('demande-flux')->group(function () {
    Route::post('/', [DemandeFluxController::class, 'store']);
    Route::get('/by-demande/{demandeId}', [DemandeFluxController::class, 'getFluxByDemandeId']);
    Route::put('/permission/{id}', [DemandeFluxController::class, 'updatePermission']);
});
Route::put('/demande-flux-inconnu/permission/{id}', [DemandeFluxInconnuPanneController::class, 'updatePermission']);
Route::get('/piece-recommandee/voir/{demandeId}', [PieceRecommandeeController::class, 'voir'])->name('piece_recommandee.voir');
Route::middleware(['auth:atelier'])->get('/atelierss/view', [DemandeController::class, 'showDemandesParAtelierPage'])
    ->name('atelierss.demandes-par-atelier');


    Route::middleware(['auth:atelier'])->get('/atelierss/viewInconnu', [DemandePanneInconnuController::class, 'showDemandesParAtelierPage'])
    ->name('ateliers.demandeInconnu');
Route::get('/demandes/{id}', [DemandeController::class, 'show'])->name('ateliers.show');

Route::get('/demandesI/{id}', [DemandePanneInconnuController::class, 'show1'])->name('ateliers.showInconnu');
Route::get('/flux-direct/{flux}', [FluxDirectController::class, 'show'])

     ->name('flux-direct.show');
Route::get('/demandesPourExpertt/{id}', [DemandeController::class, 'show2'])->name('expert.show4');
Route::get('/demandesPourExpert/{id}', [DemandePanneInconnuController::class, 'show2'])->name('expert.show2');
Route::put('/demandes/{demande}/update-techniciens', [DemandeController::class, 'updateTechniciens'])
     ->name('demandes.updateTechniciens');
Route::put('/demandesI/{demande}/update-techniciensInco', [DemandePanneInconnuController::class, 'updateTechniciens'])
     ->name('demandes.updateTechniciensInconnu');
Route::get('/demande_maintenance', [DemandeController::class, 'getAllDemandeToExpert'])->name('expert.demande_maintenance');
Route::get('/demande_maintenanceInconnu', [DemandePanneInconnuController::class, 'getAllDemandeToExpert'])->name('expert.demande_maintenanceInconnu');
// Pour l'API (api.php)
Route::get('/demandes/statistics', [DemandeController::class, 'getDemandeStatistics']);

// Route pour l'interface admin

// Pour la vue (web.php)
Route::get('/statistiques/demandes', [DemandeController::class, 'showStatistics'])

    ->name('demandes.statistics');


Route::get('/demande_autorisation', [DemandeController::class, 'getAllDemandeAtelierToExpert'])->name('expert.demande_autorisation');
Route::get('/request-choice', [DemandeController::class, 'showRequestChoice'])
         ->name('expert.request_choice');
Route::get('/request-choiceP', [DemandePanneInconnuController::class, 'showRequestChoice'])
         ->name('ateliers.choice');


         Route::get('/request-choiceResponsable', [UserController::class, 'showRequestChoice'])
         ->name('responsable.choice');
// Ou si vous utilisez un contrôleur
Route::get('/demandes-expert', [DemandeController::class, 'getAllDemandeToExpert'])->name('expert.demandes');
Route::post('/demandes/{id}/prix-main-oeuvre', [DemandeController::class, 'ajouterPrixMainOeuvre'])->name('demandes.ajouterPrixMainOeuvre');
Route::get('/piece-recommandee/ajouter/{demandeId}', [PieceRecommandeeController::class, 'formAjouter'])->name('piece_recommandee.ajouter');
Route::post('/piece-recommandee/store', [PieceRecommandeeController::class, 'store'])->name('piece_recommandee.store');
Route::put('/demandes/{id}/prix-main-oeuvre', [DemandeController::class, 'ajouterPrixMainOeuvre']);
Route::middleware(['auth:atelier'])->group(function () {
    Route::get('/tickets/create', [MaintenanceTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [MaintenanceTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets', [MaintenanceTicketController::class, 'index'])->name('tickets.index');
    Route::post('/techniciens', [UserController::class, 'storee'])->name('techniciens.storee');
    Route::get('/tickets/{id}', [MaintenanceTicketController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{id}/disable', [MaintenanceTicketController::class, 'disable'])->name('tickets.disable');
});
Route::post('/disponibilite-piece/{id}', [DemandePanneInconnuController::class, 'updateDisponibilitePiece'])->name('disponibilite.piece.update');

Route::get('/piece-recommandee/show/{demandeId}', [DemandePanneInconnuController::class, 'formAjouter'])->name('piece_recommandee.show');
Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques');

Route::middleware(['auth:atelier'])->group(function () {
Route::get('atelierss/ticket_maintenance', [MaintenanceTicketController::class, 'index'])->name('atelierss.ticket_maintenance');

});
Route::get('/techniciens/sans-atelier', [UserController::class, 'getTechniciensSansAteliers']);

Route::middleware(['auth:atelier'])->group(function () {
    Route::get('ticket_maintenance', [MaintenanceTicketController::class, 'index'])->name('atelierss.ticket_maintenance');

    });

Route::get('/statistiquesAtelier', [UserController::class, 'statistiques'])->name('statistiquesAtelier');
Route::get('ticket_maintenance', [MaintenanceTicketController::class, 'index'])->name('atelierss.ticket_maintenance');

Route::resource('factures', FactureController::class);
Route::middleware('auth:atelier')->get('atelierss/factures', [FactureController::class, 'getFacturesByConnectedAtelier'])->name('atelierss.factures');
//ville category
Route::patch('/ville/{ville}/toggle-visibility', [VilleController::class, 'toggleVisibility'])
    ->name('ville.toggle-visibility');
Route::get('/ville', [VilleController::class, 'index'])->name('ville.index');


Route::get('/categoryPanne', [CategoryPaneController::class, 'indexx'])->name('category.indexx');
Route::get('/toggle-visibility', [CategoryPaneController::class, 'toggle-visibility'])->name('category-panes.toggle-visibility');
Route::get('/ville/create', [VilleController::class, 'create'])->name('ville.create');
  Route::resource('category-panes', CategoryPaneController::class);
Route::post('/ville', [VilleController::class, 'store'])->name('ville.store');
Route::get('/ville/{ville}/edit', [VilleController::class, 'edit'])->name('ville.edit');
Route::put('/ville/{ville}', [VilleController::class, 'update'])->name('ville.update');
Route::delete('/ville/{ville}', [VilleController::class, 'destroy'])->name('ville.destroy');
Route::get('/ville/{ville}', [VilleController::class, 'show'])->name('ville.show');
//fofait
Route::get('/forfait', [ForfaitController::class, 'index'])->name('forfait.index');
Route::get('/forfait/create', [ForfaitController::class, 'create'])->name('forfait.create');
Route::post('/forfait', [ForfaitController::class, 'store'])->name('forfait.store');
Route::get('/forfait/{forfait}/edit', [ForfaitController::class, 'edit'])->name('forfait.edit');
Route::put('/forfait/{forfait}', [ForfaitController::class, 'update'])->name('forfait.update');
Route::delete('/forfait/{forfait}', [ForfaitController::class, 'destroy'])->name('forfait.destroy');
Route::get('/forfait/{forfait}', [ForfaitController::class, 'show'])->name('forfait.show');
//classification piéce
Route::get('/classificationPiece', [ClassificationPieceController::class, 'index'])->name('classificationPiece.index');
Route::get('/classificationPiece/create', [ClassificationPieceController::class, 'create'])->name('classificationPiece.create');
Route::post('/classificationPiece', [ClassificationPieceController::class, 'store'])->name('classificationPiece.store');
Route::get('/classificationPiece/{classificationPiece}/edit', [ClassificationPieceController::class, 'edit'])->name('classificationPiece.edit');
Route::put('/classificationPiece/{classificationPiece}', [ClassificationPieceController::class, 'update'])->name('classificationPiece.update');
Route::delete('/classificationPiece/{classificationPiece}', [ClassificationPieceController::class, 'destroy'])->name('classificationPiece.destroy');
Route::get('/classificationPiece/{classificationPiece}', [ClassificationPieceController::class, 'show'])->name('classificationPiece.show');

Route::middleware(['auth:atelier'])->group(function () {
    Route::get('/atelierss/statistiques', [UserController::class, 'statistiques'])
         ->name('atelierss.statistiques');
});
Route::middleware(['auth:atelier'])->group(function () {
    Route::get('/atelier/employes/create', [AtelierEmployeeController::class, 'create'])
         ->name('atelier.employes.create');
    Route::post('/atelier/employes', [AtelierEmployeeController::class, 'store'])
         ->name('atelier.employes.store');

         Route::put('/atelier/employes/{employee}', [AtelierEmployeeController::class, 'update'])
         ->name('atelier.employes.update');
});
//entreprise automobile
Route::get('/demandes', function () {
    return view('reponsable_piece.demandes');
})->name("reponsable_piece.demandes");

Route::get('/demandesInconnu', function () {
    return view('reponsable_piece.demande_inconnu');
})->name("reponsable_piece.demandesInconnu");

Route::get('/entrepriseAutomobile', [EntrepriseAutomobileController::class, 'index'])->name('entrepriseAutomobile.index');
Route::get('/entrepriseAutomobile/create', [EntrepriseAutomobileController::class, 'create'])->name('entrepriseAutomobile.create');
Route::post('/entrepriseAutomobile', [EntrepriseAutomobileController::class, 'store'])->name('entrepriseAutomobile.store');
Route::get('/entrepriseAutomobile/{entrepriseAutomobile}', [EntrepriseAutomobileController::class, 'show'])->name('entrepriseAutomobile.show');
Route::get('/entrepriseAutomobile/{entrepriseAutomobile}/edit', [EntrepriseAutomobileController::class, 'edit'])->name('entrepriseAutomobile.edit');
Route::put('/entrepriseAutomobile/{entrepriseAutomobile}', [EntrepriseAutomobileController::class, 'update'])->name('entrepriseAutomobile.update');
Route::delete('/entrepriseAutomobile/{entrepriseAutomobile}', [EntrepriseAutomobileController::class, 'destroy'])->name('entrepriseAutomobile.destroy');

// Routes pour la gestion des voitures
Route::post('/entrepriseAutomobile/{entreprise}/add-voiture', [EntrepriseAutomobileController::class, 'addVoiture'])
     ->name('entrepriseAutomobile.addVoiture');
Route::delete('/entrepriseAutomobile/{entreprise}/remove-voiture/{index}', [EntrepriseAutomobileController::class, 'removeVoiture'])
     ->name('entrepriseAutomobile.removeVoiture');
//services category


    Route::patch('/servicee/{service}/toggle-visibility', [ServicePanneController::class, 'toggleVisibility'])
    ->name('servicee.toggle-visibility');
Route::get('/service', [ServiceController::class, 'index'])->name('service.index');

Route::get('/servicee', [ServicePanneController::class, 'index'])->name('servicee.index');

Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/service', [ServiceController::class, 'store'])->name('service.store');

Route::post('/servicee', [ServicePanneController::class, 'store'])->name('servicee.store');
Route::get('/service/{service}/edit', [ServicePanneController::class, 'edit'])->name('servicee.edit');

Route::get('/servicee/{service}/edit', [ServicePanneController::class, 'edit'])->name('servicee.edit');
Route::put('/service/{service}', [ServiceController::class, 'update'])->name('service.update');
Route::put('/servicee/{service}', [ServicePanneController::class, 'update'])->name('servicee.update');
Route::delete('/servicee/{service}', [ServicePanneController::class, 'destroy'])->name('servicee.destroy');
Route::get('/service/{service}', [ServiceController::class, 'show'])->name('service.show');

// specialisation
Route::patch('/specialisation/{specialisation}/toggle-visibility', [SpecialisationController::class, 'toggleVisibility'])
    ->name('specialisation.toggle-visibility');
Route::get('/specialisation', [SpecialisationController::class, 'index'])->name('specialisation.index');
Route::get('/specialisation/create', [SpecialisationController::class, 'create'])->name('specialisation.create');
Route::post('/specialisation', [SpecialisationController::class, 'store'])->name('specialisation.store');
Route::get('/specialisation/{specialisation}/edit', [SpecialisationController::class, 'edit'])->name('specialisation.edit');
Route::put('/specialisation/{specialisation}', [SpecialisationController::class, 'update'])->name('specialisation.update');
Route::delete('/specialisation/{specialisation}', [SpecialisationController::class, 'destroy'])->name('specialisation.destroy');
Route::get('/specialisation/{specialisation}', [SpecialisationController::class, 'show'])->name('specialisation.show');

//banque
Route::patch('/banque/{banque}/toggle-visibility', [BanqueController::class, 'toggleVisibility'])
    ->name('banque.toggle-visibility');
Route::get('/banque', [BanqueController::class, 'index'])->name('banque.index');
Route::get('/banque/create', [BanqueController::class, 'create'])->name('banque.create');
Route::post('/banque', [BanqueController::class, 'store'])->name('banque.store');
Route::get('/banque/{banque}/edit', [BanqueController::class, 'edit'])->name('banque.edit');
Route::put('/banque/{banque}', [BanqueController::class, 'update'])->name('banque.update');
Route::delete('/banque/{banque}', [BanqueController::class, 'destroy'])->name('banque.destroy');
Route::get('/banque/{banque}', [BanqueController::class, 'show'])->name('banque.show');
//couleur
Route::patch('/couleur/{couleur}/toggle-visibility', [CouleurController::class, 'toggleVisibility'])
    ->name('couleur.toggle-visibility');
Route::get('/couleur', [CouleurController::class, 'index'])->name('couleur.index');
Route::get('/couleur/create', [CouleurController::class, 'create'])->name('couleur.create');
Route::post('/couleur', [CouleurController::class, 'store'])->name('couleur.store');
Route::get('/couleur/{couleur}/edit', [CouleurController::class, 'edit'])->name('couleur.edit');
Route::put('/couleur/{couleur}', [CouleurController::class, 'update'])->name('couleur.update');
Route::delete('/couleur/{couleur}', [CouleurController::class, 'destroy'])->name('couleur.destroy');
Route::get('/couleur/{couleur}', [CouleurController::class, 'show'])->name('couleur.show');


//type ticket
Route::patch('/ticket/{couleur}/toggle-visibility', [TypeTicketController::class, 'toggleVisibility'])
    ->name('ticket.toggle-visibility');
Route::get('/ticket', [TypeTicketController::class, 'index'])->name('ticket.index');


Route::get('/ticket/create', [TypeTicketController::class, 'create'])->name('ticket.create');
Route::post('/ticket', [TypeTicketController::class, 'store'])->name('ticket.store');
Route::get('/ticket/{ticket}/edit', [TypeTicketController::class, 'edit'])->name('ticket.edit');
Route::put('/ticket/{ticket}', [TypeTicketController::class, 'update'])->name('ticket.update');
Route::delete('/ticket/{ticket}', [TypeTicketController::class, 'destroy'])->name('ticket.destroy');
Route::get('/ticket/{ticket}', [TypeTicketController::class, 'show'])->name('ticket.show');

// Routes pour le catalogue
Route::get('/catalogues', [CatalogueController::class, 'index'])->name('catalogues.index'); // Afficher la liste des catalogues
Route::post('/catalogues', [CatalogueController::class, 'store'])->name('catalogues.store'); // Enregistrer un nouveau catalogue
Route::get('/catalogues/create', [CatalogueController::class, 'create'])->name('catalogues.create'); // Afficher le formulaire de création (optionnel si vous utilisez une popup)
Route::get('/catalogues/{catalogue}', [CatalogueController::class, 'show'])->name('catalogues.show'); // Afficher les détails d'un catalogue (optionnel)
Route::put('/catalogues/{catalogue}', [CatalogueController::class, 'update'])->name('catalogues.update'); // Mettre à jour un catalogue
Route::delete('/catalogues/{catalogue}', [CatalogueController::class, 'destroy'])->name('catalogues.destroy'); // Supprimer un catalogue
Route::get('/catalogues/{catalogue}/edit', [CatalogueController::class, 'edit'])->name('catalogues.edit'); // Afficher le formulaire de modification (optionnel si vous utilisez une popup)
// Afficher la vue de connexion par défauttt

Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::get('/statistiqueAtelier', function () {
    return view('statistiqueAtelier');
})->name('statistiqueAtelier');
Route::get('/sidebarAtelier', function () {
    return view('Sidebar.sidebarAtelier', [
        'user' => Auth::user()
    ]);
})->name('sidebarAtelier');
// routes/web.php
Route::get('/factures/{id}/download', [FactureController::class, 'downloadPdf'])
    ->name('factures.download');
Route::get('/sidebar', function () {
    return view('Sidebar.sidebar', [
        'user' => Auth::user()
    ]);
})->name('sidebarAtelier');



Route::get('/sidebarExpert', function () {
    // Récupère l'utilisateur avec la guard 'web' (ou 'expert' si vous avez un guard spécifique)
    $user = Auth::guard('web')->user();

    // Vérifie si l'utilisateur est connecté et a le bon rôle
    if (!$user || $user->role !== 'expert') {
        return redirect()->route('login')->with('error', 'Accès réservé aux experts');
    }

    return view('Sidebar.sidebarExpert', [
        'user' => $user,
        'atelier' => $user->atelier // Si vous avez une relation atelier
    ]);
})->name('sidebarExpert')->middleware('auth:web');



Route::get('/sidebarEntreprise', function () {
    if (!Auth::guard('entreprise')->check()) {
        abort(403, 'Unauthorized');
    }

    return view('Sidebar.sidebarEntreprise', [
        'user' => Auth::guard('entreprise')->user(),
    ]);
})->name('sidebarEntreprise')->middleware('auth:entreprise');


Route::get('/registreContactante', function () {
    return view('registreEntreprise');
})->name('sidebarAtelier');

Route::get('/', function () {
    return view('registreOption');
})->name('registreOption');
Route::get('/factures', [FactureController::class, 'index'])
    ->name('factures.index'); // Nommez correctement la route
Route::get('/entrepriseContractante', function () {
    return view('Admin.entrepriseContractante', [
       'entreprises' => EntrepriseContractante::all()
    ]);
})->name('entrepriseContractante');

Route::apiResource('villes', VilleController::class);
Route::get('/points', function () {
    return view('Admin.pointFideléte', [
       'points' => LoyaltyPoint::all()
    ]);
})->name('points');
// Route pour gérer la soumission du formulaire de connexion


Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

//Route::post('/api/login', [AuthController::class, 'loginUser']);
// Routes pour les utilisateurs
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::put('/users/{id}', [UserController::class, 'updateEmail'])->name('users.update');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
Route::get('/profileResponsable', [UserController::class, 'editResponsable'])->name('profile.editResponsable');
Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
Route::get('/profileAdmin', [UserController::class, 'editAdmin'])->name('profile.editAdmin');
Route::put('/techniciens/{id}', [UserController::class, 'update'])->name('techniciens.update');
Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::patch('/users/{id}/update-email-phone', [UserController::class, 'updateEmailPhoneAndAddress']);

Route::patch('/techniciens/{id}/update-email-phone', [UserController::class, 'updateEmailPhoneAndAddress']);
Route::patch('/users/{id}/activate', [UserController::class, 'activateUser'])->name('users.activate');
Route::patch('/users/{id}/desactivate', [UserController::class, 'désactivateUser'])->name('users.desactivate');
Route::patch('/users/{id}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
Route::delete('/techniciens/{technicien}', [UserController::class, 'destroyTechnicien'])
     ->name('techniciens.destroyTechnicien');

Route::prefix('atelier')->group(function () {
    Route::get('/loginA', [AuthAtelier::class, 'showLoginForm'])->name('atelier.login.form');
    Route::post('/loginA', [AuthAtelier::class, 'login'])->name('atelier.login');
    Route::post('/logout', [AuthAtelier::class, 'logout'])->name('atelier.logout');

    Route::middleware('auth:entreprise')->group(function () {
        Route::get('/dashboard', function () {
            return view('entreprise.dashboard');
        })->name('entreprise.dashboard');
    });
});

Route::middleware(['auth:entreprise'])->group(function () {
    Route::get('/dashboard', function () {
        return view('Sidebar.sidebarEntreprise');
    })->name('sidebarEntreprise');

    Route::post('/logout', [AuthEntrepriseContractante::class, 'logout'])
         ->name('entreprise.logout');
});

Route::prefix('entreprise')->group(function () {
    // Routes publiques
    Route::get('/login', [AuthEntrepriseContractante::class, 'showLoginForm'])
         ->name('entreprise.login.form');

    Route::post('/login', [AuthEntrepriseContractante::class, 'login'])
         ->name('entreprise.login');

    // Routes protégées

});
// Route pour la vue technicien
Route::get('/points', function () {
    return view('Admin.pointFideléte', [
        'points' => LoyaltyPoint::with(['user', 'technician', 'sparePart'])->latest()->get(),
        'users' => User::where('role', 'Client')->get(), // Ou le rôle approprié pour les clients
        'technicians' => User::where('role', 'Technicien')->get(),
        'spareParts' => Catalogue::all() // Si vous avez besoin des pièces de rechange
    ]);
})->name('points');

Route::get('/employee', function () {
    return view('Admin.employee', [
       'employee' => User::where('role', 'Client')->get()
    ]);
})->name('employee');
Route::get('/experts', function () {
    return view('Admin.experts', [
       'experts' => User::where('role', 'expert')->get(),
        'specialisations' => Specialisation::where('is_visible', true)->get()
    ]);
})->name('experts');
Route::get('/technicien', function () {
    return view('Admin.technicien', [
       'users' => User::where('role', 'technicien')->get(),
        'specialisations' => Specialisation::where('is_visible', true)->get()
    ]);
})->name('technicien');
Route::get('/atelier', function () {
    return view('Admin.listeAtelier', [
        'ateliers' => Atelier::all()
    ]);
})->name('ateliers');
Route::get('/categorie', function () {
    return view('Admin.categorie',);
})->name('categorie');
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/show', function () {
    return view('show');
})->name('show');
// Version corrigée

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logoutt', [AuthController::class, 'logout'])->name('atelierss.logout');
// Routes pour les camions
Route::get('/camions', [CamionController::class, 'index'])->name('camions.index'); // Afficher la liste des catalogues
Route::post('/camions', [CamionController::class, 'store'])->name('camions.store'); // Enregistrer un nouveau catalogue
Route::delete('/camions/{id}', [CamionController::class, 'destroy'])->name('camions.destroy');
Route::put('/camions/{id}', [CamionController::class, 'update'])->name('camions.update');
// routes/web.php
Route::get('/camions/{id}', [CamionController::class, 'show'])->name('camions.show');
 // Enregistrer un nouveau catalogue
Route::delete('/atelier/{id}', [AtelierController::class, 'destroy'])->name('ateliers.destroy');
Route::put('/atelier/{id}', [AtelierController::class, 'update'])->name('ateliers.update');
Route::get('/atelier/inscription', [AtelierController::class, 'showInscriptionForm'])->name('atelier.inscription');
Route::get('/entreprises', [Entreprise_contractanteController::class, 'store'])->name('entreprises.store');
// Traiter la soumission du formulaire
Route::post('/atelier/inscription', [AtelierController::class, 'submitInscriptionForm'])->name('atelier.inscription.submit');
Route::post('/ateliers/{id}/activate', [AtelierController::class, 'activateAtelier']);
Route::patch('/ateliers/{id}/desactivate', [AtelierController::class, 'desactivateAtelier']);
Route::get('/ateliers', [AtelierController::class, 'index'])->name('ateliers.index');
//Route pour entreprise contractante
Route::prefix('entreprises')->name('entreprises.')->group(function () {
    Route::get('/', [Entreprise_contractanteController::class, 'index'])->name('index');
    Route::post('/', [Entreprise_contractanteController::class, 'store'])->name('store');
    Route::get('/{id}', [Entreprise_contractanteController::class, 'show'])->name('show');
    Route::put('/{id}', [Entreprise_contractanteController::class, 'update'])->name('update');
    Route::delete('/{id}', [Entreprise_contractanteController::class, 'destroy'])->name('destroy');
});
Route::post('/entreprises/{id}/activer', [Entreprise_contractanteController::class, 'activer'])->name('entreprises.activer');;
Route::post('/entreprises/{id}/desactiver', [Entreprise_contractanteController::class, 'desactiver'])->name('entreprises.desactiver');;
Route::put('/entreprises/{id}/accepter', [Entreprise_contractanteController::class, 'accepter'])->name('entreprises.accepter');
Route::put('/entreprises/{id}/refuser', [Entreprise_contractanteController::class, 'refuser'])->name('entreprises.refuser');
//Route de point de fidélité
Route::prefix('points-de-fidelite')->group(function () {
    Route::get('/', [PointDeFideliteController::class, 'index']); // Liste des points de fidélité
    Route::post('/', [PointDeFideliteController::class, 'store']); // Ajouter des points de fidélité
    Route::get('{id}', [PointDeFideliteController::class, 'show']); // Voir un enregistrement
    Route::put('{id}', [PointDeFideliteController::class, 'update']); // Modifier un enregistrement
    Route::delete('{id}', [PointDeFideliteController::class, 'destroy']); // Supprimer un enregistrement
});

//Route de Rapport
Route::apiResource('rapports', RapportController::class);
//Route de Voiture
Route::apiResource('voitures', VoitureController::class);
Route::get('/loyalty-points', [LoyaltyPointsController::class, 'index'])->name('loyalty-points.index');
Route::post('/loyalty-points', [LoyaltyPointsController::class, 'store'])->name('loyalty-points.store');
Route::get('/loyalty-points/create', [LoyaltyPointsController::class, 'create'])->name('loyalty-points.create');
Route::get('/loyalty-points/{loyaltyPoint}', [LoyaltyPointsController::class, 'show'])->name('loyalty-points.show');
Route::get('/loyalty-points/{loyaltyPoint}/edit', [LoyaltyPointsController::class, 'edit'])->name('loyalty-points.edit');
Route::put('/loyalty-points/{loyaltyPoint}', [LoyaltyPointsController::class, 'update'])->name('loyalty-points.update');
Route::delete('/loyalty-points/{loyaltyPoint}', [LoyaltyPointsController::class, 'destroy'])->name('loyalty-points.destroy');

Route::middleware(['auth:atelier'])->group(function () {
Route::get('atelierss/technicienAtelier', function() {
    return view('ateliers.techniciens', [
        'techniciens' => User::where('role', 'technicien')
                          ->where('atelier_id', Auth::id())
                          ->paginate(4),
        'specialisations' => Specialisation::where('is_visible', true)->get()
    ]);
})->name('atelierss.techniciensAtelier');
});




Route::get('exper/technicien', function() {
    return view('expert.technician', [
        'techniciens' => User::where('role', 'technicien')
                         ->whereNull('atelier_id')
                          ->paginate(6),
    ]);
})->name('expert.techniciens');

Route::middleware(['auth:atelier'])->prefix('atelier')->name('atelier.')->group(function () {

    // Afficher le profil
    Route::get('/profile', [AtelierController::class, 'showProfile'])->name('profile.show');

    // Formulaire d'édition
    Route::get('/profile/edit', [AtelierController::class, 'update'])->name('profile.edit');

    // Mettre à jour le profil
    Route::put('/profile', [AtelierController::class, 'update'])->name('profile.update');
    Route::post('/profile', [AtelierController::class, 'update'])->name('profile.update.post');

    // Mettre à jour la disponibilité

    // Changer le statut
    Route::patch('/profile/status', [AtelierController::class, 'toggleStatus'])->name('profile.toggle-status');

});

Route::middleware(['auth:entreprise'])->group(function () {
    Route::get('/entreprise/statistiques', [UserController::class, 'statistiquesEntreprise'])
         ->name('entreprise.statistiques');
});

Route::prefix('ateliers')->group(function () {
    // Récupérer les disponibilités d'un atelier
    Route::get('/{id}/availability', [AtelierController::class, 'getAvailability']);

    // Mettre à jour les disponibilités
    Route::post('/{id}/availability', [AtelierController::class, 'updateAvailability']);

    // Ajouter un créneau spécifique
    Route::post('/{id}/availability/{day}/add-slot', [AtelierController::class, 'addTimeSlot']);

    // Supprimer un créneau spécifique
    Route::delete('/{id}/availability/{day}/remove-slot', [AtelierController::class, 'removeTimeSlot']);
});
Route::get('/atelierss/availability', [AtelierController::class, 'availabilityView'])->name('atelierss.availability');
Route::get('/atelier/{id}/availability', [AtelierAvailabilityController::class, 'showForm'])->name('atelier.availability.form');
Route::post('/atelier/{id}/availability', [AtelierAvailabilityController::class, 'store'])->name('atelier.availability.store');

Route::middleware(['auth:atelier'])->group(function () {
Route::get('atelierss/employeeAtelier', function() {
    return view('ateliers.employeeAtelier', [
        'employees' => User::where('role', 'Client')
                          ->where('atelier_id', Auth::id())
                          ->paginate(6)
    ]);
})->name('atelierss.employeeAtelier');

});



Route::middleware(['auth:atelier'])->group(function () {
    Route::get('/atelier/disponibilites', [AtelierController::class, 'showAvailabilityForm'])->name('atelier.availability');
    Route::post('/atelier/disponibilites', [AtelierController::class, 'updateAvailability'])->name('atelier.availability.update');
    Route::get('/atelier/disponibilites', [AtelierController::class, 'availabilityView'])
         ->name('atelier.availability');
});
Route::middleware(['auth:atelier'])->group(function () {
    Route::get('/employeeAtelier', function() {
        return view('ateliers.employeeAtelier', [
            'employees' => User::where('role', 'Client')
                              ->where('atelier_id', Auth::id())
                              ->paginate(6)
        ]);
    })->name('employeeAtelier');

    });
Route::post('/users/{user}/approve', [UserController::class, 'approveUser'])->name('users.approve');
Route::post('/users/{user}/reject', [UserController::class, 'rejectUser'])->name('users.reject');

Route::middleware(['auth:entreprise'])->group(function () {
    Route::get('entreprise/employeeEntreprise', function() {
        return view('entreprise.employes', [
            'employees' => User::where('role', 'employe')
                              ->where('entreprise_contractante_id', Auth::id())
                              ->get()
        ]);
    })->name('entreprise.employeeEntreprise');

    });
Route::post('/tickets/{id}/generate-ai-response', [TicketAssistanceController::class, 'generateAIResponse'])->name('tickets.generate-ai-response');
Route::post('/techniciens', [UserController::class, 'storee'])->name('techniciens.storee');
Route::post('/techniciensStore', [UserController::class, 'storeTech'])->name('techniciens.storeTech');
Route::post('/expertStore', [UserController::class, 'storeExpert'])->name('expert.storeExpert');
Route::prefix('rapport-maintenance')->group(function () {
    // Télécharger un rapport spécifique
    Route::get('/{id}/download', [RapportMaintenanceController::class, 'download'])
         ->name('rapport.download');





    // Voir les rapports pour une demande
    Route::get('/demande/{demandeId}', [RapportMaintenanceController::class, 'showByDemande']);

    // Autres routes si nécessaire...
});

Route::get('/rapport-maintenance-inconnu/{id}/download', [RapportMaintenanceInconnuController::class, 'download'])->name('rapportt.downloadd');;
Route::get('/ticketts', [TicketAssistanceController::class, 'index'])
     ->name('tickets.index');
Route::post('/tickets/{id}/reply', [TicketController::class, 'reply']);
Route::post('/tickets/{id}/close', [TicketAssistanceController::class, 'closeTicket']);
