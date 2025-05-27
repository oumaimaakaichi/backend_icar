
<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceTicketController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\TypeTicketController;
use App\Http\Controllers\VoitureController;
use App\Http\Controllers\CategoryPaneController;
use App\Http\Controllers\ServicePanneController;
use App\Http\Controllers\ForfaitServiceController;
use App\Http\Controllers\CouleurController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\DemandeAchatPieceController;
use App\Http\Controllers\ForfaitController;
use App\Http\Controllers\EntrepriseAutomobileController;
use App\Http\Controllers\PieceRecommandeeController;
use App\Http\Controllers\FluxDirectController;
use Illuminate\Support\Facades\Auth;
// routes/api.php
use App\Http\Controllers\DemandeFluxController;


// routes/api.php

Route::get('/demandes/{demande_id}/meet-link', function ($demande_id) {
    $fluxDirect = \App\Models\FluxDirect::where('demande_id', $demande_id)
        ->with('demandeFlux')
        ->first();

    if (!$fluxDirect) {
        return response()->json(['message' => 'Flux direct non trouvé'], 404);
    }

    if (!$fluxDirect->demandeFlux || !$fluxDirect->demandeFlux->partage_with_client) {
        return response()->json(['message' => 'Visioconférence non disponible'], 403);
    }

    return response()->json([
        'lien_meet' => $fluxDirect->lien_meet,
        'partage_with_client' => $fluxDirect->demandeFlux->partage_with_client
    ]);
});
Route::get('demande-flux/by-flux/{idFlux}', [DemandeFluxController::class, 'getDemandeByIdFlux']);
Route::put('/autoriser-partage/{id}', [DemandeFluxController::class, 'autoriserPartage']);
Route::prefix('demande-flux')->group(function () {
    Route::post('/', [DemandeFluxController::class, 'store']);
    Route::get('/by-demande/{demandeId}', [DemandeFluxController::class, 'getFluxByDemandeId']);
    Route::put('/permission/{id}', [DemandeFluxController::class, 'updatePermission']);
});
Route::get('/flux-par-demande/{demandeId}', [FluxDirectController::class, 'getFluxParDemande']);

Route::get('/flux-direct/{demandeId}/{technicienId}', [FluxDirectController::class, 'getOrCreate']);
Route::get('/demande/{demandeId}/flux', [FluxDirectController::class, 'getFluxForDemande']);
Route::put('/demandes/{id}/update-location', [DemandeController::class, 'updateLocation']);
Route::get('/demandes/user/{id}', [DemandeController::class, 'getByDemandeWithTechnicien']);
Route::get('/demandes/technicien/{technicien_id}', [DemandeController::class, 'getDemandesParTechnicien']);

Route::put('/demandes/{id}/update-link', [DemandeController::class, 'updateFluxLink']);
Route::get('/{id}/confirmation-details', [DemandeController::class, 'getDetailsForConfirmation']);
    Route::get('/{id}/total-pieces', [DemandeController::class, 'getTotalPrixPieces']);
Route::get('/demandes/client/{client_id}/offres', [DemandeController::class, 'getDemandesAvecOffrePourClient']);
Route::post('/demandes/{id}/accept', [DemandeController::class, 'accepterOffre']);
Route::post('/demandes/{id}/reject', [DemandeController::class, 'refuserOffre']);
Route::get('/piece-recommandee/voir/{demandeId}', [PieceRecommandeeController::class, 'voir'])->name('piece_recommandee.voir');
Route::put('/demandes/{demande}/pieces-choisies', [DemandeController::class, 'updatePiecesChoisies']);
Route::put('/demandes/{id}/update-info', [DemandeController::class, 'updateInfo']);
Route::get('/demandes/atelier/{atelier_id}', [DemandeController::class, 'getDemandesParAtelier']);
Route::get('/forfaits', [ForfaitController::class, 'getAllForfaitsWithServicePannes']);
Route::get('/piece-recommandees', [PieceRecommandeeController::class, 'index']);
Route::post('/piece-recommandees', [PieceRecommandeeController::class, 'store']);
Route::get('demandes/{client_id}', [DemandeController::class, 'getDemandesParClient']);
Route::get('/piece-recommandee/{demandeId}', [PieceRecommandeeController::class, 'getByDemandeId']);
Route::get('/entreprises-with-voitures', [EntrepriseAutomobileController::class, 'getAllEntreprisesWithVoitures']);
//Route::get('/forfaits', [ForfaitController::class, 'getAllForfait']);
Route::post('/demande-achat-pieces ', [DemandeAchatPieceController::class, 'store']);
Route::get('/paniers/{client_id}', [PanierController::class, 'index']);
Route::post('/paniers', [PanierController::class, 'store']);
Route::delete('/paniers/{id}', [PanierController::class, 'destroy']);
Route::put('/panier/{id}', [PanierController::class, 'updateQuantite']);
Route::post('/demandes', [DemandeController::class, 'store']);
Route::get('/ateliers', [AtelierController::class, 'getAllAteliers']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::get('forfaitss/service/{serviceId}', [ForfaitServiceController::class, 'getByService']);
Route::get('/couleur', [CouleurController::class, 'indexMobile']);
Route::get('/catalogues', [CatalogueController::class, 'apiIndex']);
Route::post('/users/storeM', [UserController::class, 'storeTechnicien']);
Route::get('/tickets/client/{client_id}', [MaintenanceTicketController::class, 'getByClient']);
Route::get('/tickets/type', [TypeTicketController::class, 'getAllTickets']);
Route::post('/tickets', [MaintenanceTicketController::class, 'storee']);
Route::post('/send-code', [UserController::class, 'sendCode']);
Route::post('/register-client', [UserController::class, 'registerClient']);
Route::get('/voitures/{client_id}', [VoitureController::class, 'index']);
Route::get('/voiture/{client_id}', [VoitureController::class, 'index2']);           // Liste des voitures du client connecté
    Route::post('/voitures', [VoitureController::class, 'store']);        // Ajouter une voiture
    Route::get('/voitures/{id}', [VoitureController::class, 'show']);     // Détails d'une voiture
    Route::put('/voitures/{id}', [VoitureController::class, 'update']);   // Modifier une voiture
    Route::delete('/voitures/{id}', [VoitureController::class, 'destroy']);
    Route::get('/panne/category/{categoryId}', [ServicePanneController::class, 'getByCategory']);
    Route::apiResource('category-panes', CategoryPaneController::class);


Route::get('/demandes', [DemandeController::class, 'getAllDemande']);
Route::post('/flux-direct', [FluxDirectController::class, 'store']);
