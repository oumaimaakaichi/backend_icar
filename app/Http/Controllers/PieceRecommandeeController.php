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
        // Vérifier si c'est une soumission de main d'œuvre seule
        if ($request->has('main_oeuvre_seule') && $request->main_oeuvre_seule == 1) {
            $validated = $request->validate([
                'demande_id' => 'required|exists:demandes,id',
                'prix_main_oeuvre_seule' => 'required|numeric|min:0',
                'main_oeuvre_seule' => 'required|boolean'
            ]);

            $demande = Demande::findOrFail($validated['demande_id']);

            // Créer une entrée avec uniquement la main d'œuvre
            $recommandation = PieceRecommandee::create([
                'demande_id' => $validated['demande_id'],
                'pieces' => [],
                'main_oeuvre_seule' => true,
                'prix_main_oeuvre_seule' => $validated['prix_main_oeuvre_seule']
            ]);

            // Notification
            NotificationPrix::create([
                'id' => (string) Str::uuid(),
                'type' => "Recommended labor",
                'notifiable_type' => get_class($demande->client),
                'notifiable_id' => $demande->client->id,
                'data' => [
                    'demande_id' => $validated['demande_id'],
                    'message' => 'Only labor has been recommended for your request',
                    'main_oeuvre_seule' => true,
                    'prix_main_oeuvre' => $validated['prix_main_oeuvre_seule'],
                    'pieces' => []
                ],
                'read_at' => null,
            ]);

            // ✅ Redirection avec succès
            return redirect()
                ->route('responsable_piece.demande')
                ->with('success', 'Successfully recommended labor');

        } else {
            // Cas avec pièces
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

            if (!$demande->client) {
                return back()->with('error', 'Client introuvable pour cette demande');
            }

            $recommandation = PieceRecommandee::create([
                'demande_id' => $validated['demande_id'],
                'pieces' => $validated['pieces'],
                'main_oeuvre_seule' => false
            ]);

            NotificationPrix::create([
                'id' => (string) Str::uuid(),
                'type' => 'Recommended parts',
                'notifiable_type' => get_class($demande->client),
                'notifiable_id' => $demande->client->id,
                'data' => [
                    'demande_id' => $validated['demande_id'],
                    'message' => 'Parts have been recommended for your request',
                    'pieces' => $validated['pieces'],
                    'main_oeuvre_seule' => false
                ],
                'read_at' => null,
            ]);

            // ✅ Redirection avec succès
            return redirect()
                ->route('reponsable_piece.demandes')
                ->with('success', 'Parts successfully recommended');
        }

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        \Log::error('Erreur lors de l\'enregistrement : ' . $e->getMessage());
        return back()->with('error', 'Erreur serveur : '.$e->getMessage());
    }
}


  public function getByDemandeId($demandeId)
{
    $pieceRecommandee = PieceRecommandee::where('demande_id', $demandeId)->first();

    if (!$pieceRecommandee) {
        return response()->json(['message' => 'Aucune pièce recommandée trouvée'], 404);
    }

    // Cas où seule la main d'œuvre est recommandée
    if ($pieceRecommandee->main_oeuvre_seule) {
        return response()->json([
            'main_oeuvre_seule' => true,
            'prix_main_oeuvre' => $pieceRecommandee->prix_main_oeuvre_seule,
            'demande_id' => $demandeId,
            'pieces' => [] // Tableau vide pour indiquer aucune pièce
        ]);
    }

    // Cas normal avec des pièces recommandées
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
        'main_oeuvre_seule' => false,
        'pieces' => $piecesDetails,
        'demande_id' => $demandeId
    ]);
}
}
