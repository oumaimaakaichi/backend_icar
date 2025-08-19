
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

use App\Http\Controllers\TicketAssistanceController;
use App\Http\Controllers\PieceRecommandeeController;
use App\Http\Controllers\FluxDirectController;
use App\Http\Controllers\NotificationPrixController;
use Illuminate\Support\Facades\Auth;
// routes/api.php
use App\Http\Controllers\DemandeFluxController;

use App\Http\Controllers\FluxDirectInconnuPanneController;
use App\Http\Controllers\DemandeFluxInconnuPanneController;
use App\Http\Controllers\NotificationTechnicienController;

// routes/api.php
use App\Http\Controllers\RapportMaintenanceController;
use App\Http\Controllers\RapportMaintenanceInconnuController;

use App\Http\Controllers\DemandePanneInconnuController;

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\RecusController;
Route::post('/demandes/{demandeId}/payer', [PaiementController::class, 'payer']);
Route::get('/atelier/{id}/disponibilite', [AtelierController::class, 'getAvailability']);

 Route::get('/mes-recus/{clientId}', [RecusController::class, 'mesRecus']);

    // Télécharger un reçu spécifique
    Route::get('/download-recu/{paiementId}', [RecusController::class, 'downloadRecu']);

    // Régénérer un reçu PDF
    Route::post('/regenerer-recu/{paiementId}', [RecusController::class, 'regenererRecu']);
Route::get('/reviews/technicien/{technicienId}', [ReviewController::class, 'getReviewsByTechnicien']);
Route::post('/reviews', [ReviewController::class, 'store']);


Route::get('/reviews2/demande/{demandeId}/technicienI/{technicienId}', [ReviewController::class, 'getByDemandeAndTechnicien2']);


Route::post('/reviewsStore', [ReviewController::class, 'store2']);
Route::get('/reviews/demande/{demandeId}/technicien/{technicienId}', [ReviewController::class, 'getByDemandeAndTechnicien']);
// Créer une demande de flux
Route::post('/demande-flux-inconnu', [DemandeFluxInconnuPanneController::class, 'store']);

// Récupérer le flux par ID de demande (attention : cette méthode semble incorrectement nommée, voir remarque plus bas)
Route::get('/demande-flux-inconnu/by-demande/{demandeId}', [DemandeFluxInconnuPanneController::class, 'getFluxByDemandeId']);

// Mettre à jour la permission
Route::put('/demande-flux-inconnu/{id}/permission', [DemandeFluxInconnuPanneController::class, 'updatePermission']);

// Récupérer une demande de flux via l'id_flux
Route::get('/demande-flux-inconnu/by-flux/{idFlux}', [DemandeFluxInconnuPanneController::class, 'getDemandeByIdFlux']);

// Autoriser le partage du lien Meet avec le client
Route::put('/demande-flux-inconnu/{id}/autoriser-partage', [DemandeFluxInconnuPanneController::class, 'autoriserPartage']);

Route::get('/demandes-technicien/{technicien_id}', [DemandePanneInconnuController::class, 'getDemandesParTechnicien']);

Route::put('/demande-panne/{id}/update-panne', [DemandePanneInconnuController::class, 'updatePanne']);

        Route::get('/demandeInconnu/{userId}', [DemandePanneInconnuController::class, 'index']);
        Route::get('/demandeInconnu/{id}', [DemandePanneInconnuController::class, 'show']);
Route::put('/demandes-panne-inconnue/{id}/main-oeuvre', [DemandePanneInconnuController::class, 'ajouterPrixMainOeuvrePiece']);
 Route::prefix('demandes-panne-inconnue')->group(function () {
        Route::post('/', [DemandePanneInconnuController::class, 'store']);
        Route::get('/{id}', [DemandePanneInconnuController::class, 'show']);
    });
Route::apiResource('rapport-maintenance', RapportMaintenanceController::class);
Route::get('/demandes/statistics', [DemandeController::class, 'getDemandeStatistics']);

Route::post('/demande-panne/generate-recommendations', [DemandePanneInconnuController::class, 'generateRecommendations']);
Route::get('/rapport-maintenance/demande/{demandeId}', [RapportMaintenanceController::class, 'showByDemande']);

Route::get('/rapport-maintenance/{id}/download', [RapportMaintenanceController::class, 'download']);








Route::apiResource('rapport-maintenance-inconnu', RapportMaintenanceInconnuController::class);

Route::post('/demande-panne-inconnu/generate-recommendations', [RapportMaintenanceInconnuController::class, 'generateRecommendations']);
Route::get('/rapport-maintenance-inconnu/demande/{demandeId}', [RapportMaintenanceInconnuController::class, 'showByDemande']);

Route::get('/rapport-maintenance-inconnu/{id}/download', [RapportMaintenanceInconnuController::class, 'download']);





Route::get('/demandes/{demande_id}/meet-link-inconnu', function ($demande_id) {
    // Récupération du flux direct avec relation 'demandeFlux'
    $fluxDirect = \App\Models\FluxDirectInconnuPanne::with('demandeFlux')
        ->where('demande_id', $demande_id)
        ->where('type_meet', 'Examination')
        ->first();

    // Vérification si le flux existe
    if (!$fluxDirect) {
        return response()->json([
            'success' => false,
            'message' => 'Flux direct non trouvé'
        ], 404);
    }

    // Vérification des permissions de partage
    if (!$fluxDirect->demandeFlux || !$fluxDirect->demandeFlux->partage_with_client) {
        return response()->json([
            'success' => false,
            'message' => 'Visioconférence non disponible'
        ], 403);
    }

    // Retour des informations de la visioconférence
    return response()->json([
        'success' => true,
        'lien_meet' => $fluxDirect->lien_meet,
        'ouvert' => $fluxDirect->ouvert,
        'partage_with_client' => $fluxDirect->demandeFlux->partage_with_client,
    ]);
});

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
        'ouvert' => $fluxDirect->ouvert,
        'partage_with_client' => $fluxDirect->demandeFlux->partage_with_client
    ]);
});
// Handle preflight OPTIONS requests

Route::get('demande-flux/by-flux/{idFlux}', [DemandeFluxController::class, 'getDemandeByIdFlux']);
Route::put('/autoriser-partage/{id}', [DemandeFluxController::class, 'autoriserPartage']);
Route::prefix('demande-flux')->group(function () {
    Route::post('/', [DemandeFluxController::class, 'store']);
    Route::get('/by-demande/{demandeId}', [DemandeFluxController::class, 'getFluxByDemandeId']);
    Route::put('/permission/{id}', [DemandeFluxController::class, 'updatePermission']);
});
Route::get('/demandes-inconnues/{demandeId}', [DemandePanneInconnuController::class, 'show']);

Route::get('/flux-par-demande/{demandeId}', [FluxDirectController::class, 'getFluxParDemande']);

Route::post('/flux-par-demandeInconnu', [FluxDirectInconnuPanneController::class, 'store']);
Route::get('/flux-par-demande_inconnu/{demandeId}', [FluxDirectInconnuPanneController::class, 'getFluxParDemande']);

Route::get('/flux-par-demande_inconnu-entretient/{demandeId}', [FluxDirectInconnuPanneController::class, 'getFluxParDemandeEntretient']);
Route::get('/flux-direct/{demandeId}/{technicienId}', [FluxDirectInconnuPanneController::class, 'getOrCreate']);
Route::get('/flux-direct-inconnu/{demandeId}/{technicienId}', [FluxDirectController::class, 'getOrCreate']);
Route::get('/demande/{demandeId}/flux', [FluxDirectController::class, 'getFluxForDemande']);
Route::put('/demandes/{id}/update-location', [DemandeController::class, 'updateLocation']);
Route::get('/demandes/user/{id}', [DemandeController::class, 'getByDemandeWithTechnicien']);
Route::get('/demandes/technicien/{technicien_id}', [DemandeController::class, 'getDemandesParTechnicien']);
Route::put('/flux-direct/{fluxId}/fermer', [FluxDirectController::class, 'fermerFlux']);
Route::put('/flux-direct-inconnu/{fluxId}/fermer', [FluxDirectInconnuPanneController::class, 'fermerFlux']);
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
Route::get('/tickets/typess', [TypeTicketController::class, 'getTicketTypess']);
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
    Route::get('/notifications', [NotificationController::class, 'index']);
     Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
Route::middleware('auth:api')->group(function() {

    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
});




Route::prefix('notificationsT')->group(function () {

    // CRUD de base
    Route::post('/', [NotificationTechnicienController::class, 'store']);
    Route::get('/{id}', [NotificationTechnicienController::class, 'show']);
    Route::delete('/{id}', [NotificationTechnicienController::class, 'destroy']);

    // Routes pour un technicien spécifique
    Route::prefix('technicien/{technicienId}')->group(function () {

        // Récupérer les notifications
        Route::get('/', [NotificationTechnicienController::class, 'index']);
        Route::get('/non-lues', [NotificationTechnicienController::class, 'getNonLues']);
        Route::get('/recentes', [NotificationTechnicienController::class, 'getRecentes']);
        Route::get('/statistiques', [NotificationTechnicienController::class, 'getStatistiques']);

        // Actions en lot
        Route::patch('/marquer-toutes-lues', [NotificationTechnicienController::class, 'marquerToutesLues']);
        Route::delete('/supprimer-lues', [NotificationTechnicienController::class, 'supprimerLues']);
    });

    // Actions sur une notification spécifique
    Route::patch('/{id}/marquer-lue', [NotificationTechnicienController::class, 'marquerLue']);
    Route::patch('/{id}/marquer-non-lue', [NotificationTechnicienController::class, 'marquerNonLue']);

    // Route de maintenance (peut être protégée par un middleware admin)
    Route::delete('/nettoyer-anciennes', [NotificationTechnicienController::class, 'nettoyerAnciennes']);
});


Route::post('/tickets/store', [TicketAssistanceController::class, 'store']);
Route::get('/tickets/user/{userId}', [TicketAssistanceController::class, 'getUserTickets']);

Route::get('/tickets/{id}', [TicketAssistanceController::class, 'show']);
Route::post('/tickets/{id}/reply', [TicketAssistanceController::class, 'reply']);
Route::middleware('auth:api')->post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
Route::get('/demandes', [DemandeController::class, 'getAllDemande']);
Route::get('/demandes-iconnu', [DemandePanneInconnuController::class, 'getAllDemande']);
Route::post('/flux-direct', [FluxDirectController::class, 'store']);
Route::get('/demandes/client/{userId}', [DemandePanneInconnuController::class, 'getAllDemandeByUser']);
Route::get('/demandes/{demande}/pieces-choisies', [DemandePanneInconnuController::class, 'getPiecesChoisies']);
Route::put('/demandes/{demande}/save-selections', [DemandePanneInconnuController::class, 'saveSelections']);
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


Route::get('/notificationsPrix/demandes-client/{clientId}', [NotificationPrixController::class, 'getNotificationsByClientDemande']);

    Route::get('/notificationsPrix/unread-count/{clientId}', [NotificationPrixController::class, 'getUnreadCount']);

    Route::patch('/notificationsPrix/{clientId}/read', [NotificationPrixController::class, 'markAsRead']);

    Route::patch('/notificationsPrix/read-all/{clientId}', [NotificationPrixController::class, 'markAllAsRead']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notificationsPrix', [NotificationPrixController::class, 'index']);
    Route::delete('/notificationsPrix/{id}', [NotificationPrixController::class, 'destroy']);

});
Route::post('/profil-technicien', [UserController::class, 'updateProfilTechnicien']);
Route::put('/clients/{id}', [UserController::class, 'updateClient']);
