<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PieceRecommandee;
use App\Models\Catalogue;
use App\Models\Demande;
use App\Models\User;
use App\Models\NotificationPrix;
use Illuminate\Support\Str;

use App\Notifications\PieceRecommandeeNotification;

class PieceRecommandeeController extends Controller
{
    public function formAjouter($demandeId)
    {
        $pieces = Catalogue::all();
        return view('reponsable_piece.piece_recommandee.ajouter', compact('demandeId', 'pieces'));
    }

    public function index()
    {
        return response()->json(PieceRecommandee::with('demande')->get());
    }

    public function voir($demandeId)
    {
        $pieceRecommandee = PieceRecommandee::where('demande_id', $demandeId)->firstOrFail();
        return view('reponsable_piece.piece_recommandee.voir', compact('pieceRecommandee'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'demande_id' => 'required|exists:demandes,id',
                'pieces' => 'required|array',
                'pieces.*.idPiece' => 'required|exists:catalogues,id',
                'pieces.*.prixOriginal' => 'required|numeric',
                'pieces.*.prixCommercial' => 'required|numeric',
                'pieces.*.datedisponibiliteOriginale' => 'required|date',
                'pieces.*.dateDisponibiliteComercial' => 'required|date',
                'pieces.*.disponibiliteOriginal' => 'required|boolean',
                'pieces.*.disponibilitCommercial' => 'required|boolean',
                'pieces.*.prix_main_oeuvre' => 'required|numeric',
            ]);

            $demande = Demande::findOrFail($validated['demande_id']);

            // Assurez-vous que le client existe
            if (!$demande->client) {
                return response()->json(['error' => 'Client introuvable pour cette demande'], 404);
            }

            $recommandation = PieceRecommandee::create([
                'demande_id' => $validated['demande_id'],
                'pieces' => $validated['pieces'],
            ]);

            // Créer et envoyer la notification
            $notification = new PieceRecommandeeNotification(
                $validated['demande_id'],
                $validated['pieces']
            );


NotificationPrix::create([
    'id' => (string) Str::uuid(),
    'type' => \App\Notifications\PieceRecommandeeNotification::class,
    'notifiable_type' => get_class($demande->client),
    'notifiable_id' => $demande->client->id,
    'data' => [
        'demande_id' => $validated['demande_id'],
        'message' => 'Des pièces ont été recommandées pour votre demande',
        'pieces' => $validated['pieces'],
    ],
    'read_at' => null,
]);

            // Log pour debug
            \Log::info('Notification envoyée pour la demande: ' . $validated['demande_id']);

            return response()->json([
                'message' => 'Pièces recommandées avec succès',
                'data' => $recommandation,
                'notification_sent' => true
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Erreur de validation',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Erreur serveur',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getByDemandeId($demandeId)
    {
        $pieceRecommandee = PieceRecommandee::where('demande_id', $demandeId)->first();

        if (!$pieceRecommandee) {
            return response()->json(['message' => 'Aucune pièce recommandée trouvée'], 404);
        }

        $piecesDetails = [];
        foreach ($pieceRecommandee->pieces as $piece) {
            $cataloguePiece = Catalogue::find($piece['idPiece']);
            if ($cataloguePiece) {
                $piecesDetails[] = [
                    'original' => [
                        'photo' => $cataloguePiece->photo_piece,
                        'prix' => $piece['prixOriginal'],
                        'date_disponibilite' => $piece['datedisponibiliteOriginale'],
                        'disponibilite' => (bool)$piece['disponibiliteOriginal'],
                        'prix_main_oeuvre' => $piece['prix_main_oeuvre']
                    ],
                    'commercial' => [
                        'photo' => $cataloguePiece->photo_piece,
                        'prix' => $piece['prixCommercial'],
                        'date_disponibilite' => $piece['dateDisponibiliteComercial'],
                        'disponibilite' => (bool)$piece['disponibilitCommercial'],
                        'prix_main_oeuvre' => $piece['prix_main_oeuvre']
                    ],
                    'info' => [
                        'nom' => $cataloguePiece->nom_piece,
                        'num_piece' => $cataloguePiece->num_piece,
                        'entreprise' => $cataloguePiece->entreprise,
                        'idPiece' => $cataloguePiece->id
                    ]
                ];
            }
        }

        return response()->json([
            'pieces' => $piecesDetails,
            'demande_id' => $demandeId
        ]);
    }
}
