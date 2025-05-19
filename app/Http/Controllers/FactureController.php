<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Facture;
use App\Models\Atelier;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class FactureController extends Controller
{

    //select
    public function index(Request $request)
    {
        $query = Facture::where('atelier_id', Auth::id())
                ->with('client');

        // Filtre par type de service
        if ($request->has('type_service') && $request->type_service) {
            $query->where('type_service', $request->type_service);
        }

        // Filtre par client
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filtre par statut
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filtre par date
        if ($request->has('date_start') && $request->date_start) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }

        if ($request->has('date_end') && $request->date_end) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        // Ajout de la pagination (10 éléments par page)
        $factures = $query->orderBy('created_at', 'desc')->paginate(3);

        $services = Service::all();
        $clients = User::where('atelier_id', Auth::id())->where('role', 'Client')->get();

        return view('ateliers.factureAtelier', compact('factures', 'services', 'clients'));
    }
    //create
    public function create()
    {
        $ateliers = Atelier::all();
        $clients = User::all();
        return view('factures.create', compact('ateliers', 'clients'));
    }

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_service' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'remise' => 'required|numeric|min:0',
            'taxe' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'atelier_id' => 'required|exists:ateliers,id'
        ]);

        try {
            $montant_total = ($validated['prix'] - $validated['remise']) + $validated['taxe'];

            $facture = Facture::create([
                ...$validated,
                'montant_total' => $montant_total,
                'status' => 'impayée' // Valeur par défaut
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Facture créée avec succès',
                'data' => $facture
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur création facture: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la facture',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // select facture par atelier
    public function getFacturesByConnectedAtelier()
    {
        $user = Auth::user();
        $clients = User::where('role', 'client') ->where('atelier_id', $user->id)->get();
        $services = Service::where('isVisible', true)->get(); // Récupère seulement les services visibles

        $factures = Facture::with(['atelier', 'client'])
                    ->where('atelier_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(3);

        return view('ateliers.factureAtelier', compact('factures', 'clients', 'services'));
    }
    //télecharger  facture

    public function downloadPdf($id)
    {
        $facture = Facture::with(['atelier', 'client'])->findOrFail($id);

        $pdf = Pdf::loadView('ateliers.pdf', compact('facture'));

        return $pdf->download('facture-'.$facture->numero.'.pdf');
    }

  // supprimer une facture
    public function destroy($id)
    {
        try {
            $facture = Facture::where('atelier_id', Auth::id())->findOrFail($id);

            $facture->delete();

            return view('ateliers.factureAtelier');

        } catch (\Exception $e) {
            \Log::error('Erreur suppression facture: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la facture',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
