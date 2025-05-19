<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PieceRecommandee;
use App\Models\Catalogue;
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

        $recommandation = PieceRecommandee::create([
            'demande_id' => $validated['demande_id'],
            'pieces' => $validated['pieces'],
        ]);

        return response()->json($recommandation, 201);
    } catch (\Exception $e) {
        \Log::error('Erreur lors de l’enregistrement : ' . $e->getMessage());
        return response()->json(['error' => 'Erreur serveur'], 500);
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
                    'disponibilite' => (bool)$piece['disponibiliteOriginal'], // Notez que j'ai changé le nom ici
                    'prix_main_oeuvre' => $piece['prix_main_oeuvre']
                ],
                'commercial' => [
                    'photo' => $cataloguePiece->photo_piece,
                    'prix' => $piece['prixCommercial'],
                    'date_disponibilite' => $piece['dateDisponibiliteComercial'],
                    'disponibilite' => (bool)$piece['disponibilitCommercial'], // Même nom que pour l'original
                    'prix_main_oeuvre' => $piece['prix_main_oeuvre']
                ],
                'info' => [
                    'nom' => $cataloguePiece->nom_piece,
                    'num_piece' => $cataloguePiece->num_piece,
                    'entreprise' => $cataloguePiece->entreprise,
                    'idPiece'=> $cataloguePiece->id
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
