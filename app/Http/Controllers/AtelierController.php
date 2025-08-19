<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Atelier;
use Illuminate\Support\Facades\Validator;

class AtelierController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */

public function availabilityView()
{
    if (!Auth::guard('atelier')->check()) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter');
    }

    $atelier = Auth::guard('atelier')->user();

    // Formatage initial des données
    $availability = $this->formatAvailabilityForView($atelier->availability ?? [
        'lundi' => [],
        'mardi' => [],
        'mercredi' => [],
        'jeudi' => [],
        'vendredi' => [],
        'samedi' => [],
        'dimanche' => []
    ]);

    return view('ateliers.availability', [
        'atelier' => $atelier,
        'availability' => $availability
    ]);
}
public function showAvailabilityForm()
{
    $atelier = Auth::guard('atelier')->Atelier();
    return view('ateliers.availability', compact('atelier'));
}
public function getAvailability($id)
{
    try {
        $atelier = Atelier::find($id);

        if (!$atelier) {
            return response()->json([
                'success' => false,
                'message' => 'Atelier non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'atelier_id' => $atelier->id,
            'availability' => $atelier->availability,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la récupération de la disponibilité',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function updateAvailability(Request $request)
{
    $atelier = Auth::guard('atelier')->user();

    // Validation des données
    $validated = $request->validate([
        'lundi' => 'nullable|array',
        'mardi' => 'nullable|array',
        'mercredi' => 'nullable|array',
        'jeudi' => 'nullable|array',
        'vendredi' => 'nullable|array',
        'samedi' => 'nullable|array',
        'dimanche' => 'nullable|array',
        'lundi.*.start' => 'required_with:lundi|date_format:H:i',
        'lundi.*.end' => 'required_with:lundi|date_format:H:i|after:lundi.*.start',
        // Répéter pour les autres jours...
    ]);

    // Formatage des données pour la base
    $formattedAvailability = [];
    foreach ($validated as $day => $slots) {
        $formattedAvailability[$day] = [];
        foreach ($slots as $slot) {
            $formattedAvailability[$day][] = $slot['start'].'-'.$slot['end'];
        }
    }

    // Mise à jour de l'atelier
    $atelier->availability = $formattedAvailability;
    $atelier->save();

    return response()->json([
        'success' => true,
        'message' => 'Disponibilités mises à jour avec succès',
        'availability' => $this->formatAvailabilityForView($formattedAvailability)
    ]);
}

// Nouvelle méthode helper pour formater les données pour la vue
private function formatAvailabilityForView($availability)
{
    $formatted = [];
    foreach ($availability as $day => $slots) {
        $formatted[$day] = [];
        foreach ($slots as $slot) {
            if (is_string($slot)) {
                list($start, $end) = explode('-', $slot);
                $formatted[$day][] = ['start' => $start, 'end' => $end];
            }
        }
    }
    return $formatted;
}   public function index(Request $request)
     {
         $query = Atelier::query();

         // Recherche par nom ou email
         if ($request->has('search') && $request->input('search') != '') {
             $search = $request->input('search');
             $query->where(function ($q) use ($search) {
                 $q->where('nom_commercial', 'like', '%' . $search . '%')
                   ->orWhere('email', 'like', '%' . $search . '%');
             });
         }

         // Récupérer les résultats
         $ateliers = $query->get();

         return view('ateliers.index', compact('ateliers'));
     }
    public function showInscriptionForm()
    {
        return view('inscriptionAtelier');
    }

    /**
     * Traite la soumission du formulaire d'inscription.
     */
    public function submitInscriptionForm(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom_commercial' => 'required|string',
            'num_registre_commerce' => 'required|numeric',
            'num_fiscal' => 'required|numeric',
            'ville' => 'required|string',
            'site_web' => 'nullable|url',
            'nom_banque' => 'required|string',
            'num_IBAN' => 'required|string', // IBAN peut contenir des lettres
            'nom_directeur' => 'required|string',
            'num_contact' => 'required|numeric',
            'specialisation_centre' => 'required|string',
            'type_entreprise' => 'required|integer',
            'document' => 'nullable|file|max:8000', // Si c'est un fichier
            'photos_centre' => 'nullable|image', // Si c'est une image
            'nbr_techniciens' => 'required|integer|min:0',
            'techniciens' => 'nullable|string', // Tableau JSON
           // Validation pour chaque élément du tableau
            'email' => 'required|email|unique:ateliers,email',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'nullable|boolean',
        ]);

        // Création de l'atelier
        Atelier::create([
            'nom_commercial' => $request->nom_commercial,
            'num_registre_commerce' => $request->num_registre_commerce,
            'num_fiscal' => $request->num_fiscal,
            'ville' => $request->ville,
            'site_web' => $request->site_web,
            'nom_banque' => $request->nom_banque,
            'num_IBAN' => $request->num_IBAN,
            'nom_directeur' => $request->nom_directeur,
            'num_contact' => $request->num_contact,
            'specialisation_centre' => $request->specialisation_centre,
            'type_entreprise' => $request->type_entreprise,
            'document' => $request->hasFile('document') ? $request->file('document')->store('documents') : null, // Gestion des fichiers
            'photos_centre' => $request->hasFile('photos_centre') ? $request->file('photos_centre')->store('photos') : null, // Gestion des images
            'nbr_techniciens' => $request->nbr_techniciens,
            'techniciens' => $request->techniciens, // Convertir le tableau en JSON
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash du mot de passe
            'is_active' => $request->is_active ?? true, // Par défaut actif
        ]);

        // Redirection avec message de succès
        return redirect()->route('atelier.inscription')->with('success', 'Inscription réussie !');
    }

    //activer Atelier
    public function activateAtelier($id)
{
    $atelier = Atelier::findOrFail($id);
    $atelier->is_active = 1;  // Activer
    $atelier->save();

    return response()->json(['message' => 'L\'atelier a été activé avec succès.']);
}
public function desactivateAtelier($id)
{
    $atelier = Atelier::findOrFail($id);
    $atelier->is_active = 0;  // Désactiver
    $atelier->save();

    return response()->json(['message' => 'L\'atelier a été désactivé avec succès.']);
}



public function getAllAteliers(Request $request)
{
    $query = Atelier::select('id', 'nom_commercial', 'ville')
        ->where('is_active', true); // Filtrer uniquement les ateliers actifs

    // Recherche par ville si le paramètre est fourni
    if ($request->has('ville') && !empty($request->ville)) {
        $query->where('ville', 'LIKE', '%' . $request->ville . '%');
    }

    // Pagination avec paramètres configurables
    $perPage = $request->get('per_page', 10); // Par défaut 10 éléments par page
    $perPage = min($perPage, 50); // Maximum 50 pour éviter la surcharge

    $ateliers = $query->orderBy('nom_commercial', 'asc')->paginate($perPage);

    return response()->json([
        'data' => $ateliers->items(),
        'current_page' => $ateliers->currentPage(),
        'last_page' => $ateliers->lastPage(),
        'per_page' => $ateliers->perPage(),
        'total' => $ateliers->total(),
        'from' => $ateliers->firstItem(),
        'to' => $ateliers->lastItem(),
        'has_more_pages' => $ateliers->hasMorePages()
    ]);
}









public function showProfile()
{
    $atelier = Auth::guard('atelier')->user();

    if (!$atelier) {
        return redirect()->route('login')->withErrors('Non autorisé.');
    }

    return view('profile.profileAtelier', compact('atelier'));
}

 public function show()
    {
        try {
            $atelier = Auth::guard('atelier')->user();

            if (!$atelier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Atelier non trouvé'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $atelier->id,
                    'nom_commercial' => $atelier->nom_commercial,
                    'num_registre_commerce' => $atelier->num_registre_commerce,
                    'num_fiscal' => $atelier->num_fiscal,
                    'ville' => $atelier->ville,
                    'site_web' => $atelier->site_web,
                    'nom_banque' => $atelier->nom_banque,
                    'num_IBAN' => $atelier->num_IBAN,
                    'nom_directeur' => $atelier->nom_directeur,
                    'num_contact' => $atelier->num_contact,
                    'specialisation_centre' => $atelier->specialisation_centre,
                    'type_entreprise' => $atelier->type_entreprise,
                    'document' => $atelier->document,
                    'photos_centre' => $atelier->photos_centre,
                    'nbr_techniciens' => $atelier->nbr_techniciens,
                    'email' => $atelier->email,
                    'is_active' => $atelier->is_active,
                    'availability' => $atelier->availability,
                    'created_at' => $atelier->created_at,
                    'updated_at' => $atelier->updated_at,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour le profil de l'atelier
     */
    public function update(Request $request)
    {
        try {
            $atelier = Auth::guard('atelier')->user();

            if (!$atelier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Atelier non trouvé'
                ], 404);
            }

            // Validation des données
            $validator = Validator::make($request->all(), [
                'nom_commercial' => 'sometimes|string|max:255',
                'num_registre_commerce' => 'sometimes|string|max:255',
                'num_fiscal' => 'sometimes|string|max:255',
                'ville' => 'sometimes|string|max:255',
                'site_web' => 'sometimes|nullable|url|max:255',
                'nom_banque' => 'sometimes|string|max:255',
                'num_IBAN' => 'sometimes|string|max:255',
                'nom_directeur' => 'sometimes|string|max:255',
                'num_contact' => 'sometimes|string|max:20',
                'specialisation_centre' => 'sometimes|string|max:500',
                'type_entreprise' => 'sometimes|string|max:255',
                'nbr_techniciens' => 'sometimes|integer|min:0',
                'email' => 'sometimes|email|unique:ateliers,email,' . $atelier->id,
                'password' => 'sometimes|string|min:8|confirmed',
                'availability' => 'sometimes|array',
                'document' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
                'photos_centre' => 'sometimes|array',
                'photos_centre.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validatedData = $validator->validated();

            // Traitement du document
            if ($request->hasFile('document')) {
                // Supprimer l'ancien document s'il existe
                if ($atelier->document) {
                    Storage::delete('public/documents/' . $atelier->document);
                }

                $document = $request->file('document');
                $documentName = time() . '_' . $document->getClientOriginalName();
                $document->storeAs('public/documents', $documentName);
                $validatedData['document'] = $documentName;
            }

            // Traitement des photos
            if ($request->hasFile('photos_centre')) {
                // Supprimer les anciennes photos s'il y en a
                if ($atelier->photos_centre) {
                    $oldPhotos = is_string($atelier->photos_centre) ?
                        json_decode($atelier->photos_centre, true) :
                        $atelier->photos_centre;

                    if (is_array($oldPhotos)) {
                        foreach ($oldPhotos as $oldPhoto) {
                            Storage::delete('public/photos/' . $oldPhoto);
                        }
                    }
                }

                $photoNames = [];
                foreach ($request->file('photos_centre') as $photo) {
                    $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/photos', $photoName);
                    $photoNames[] = $photoName;
                }
                $validatedData['photos_centre'] = json_encode($photoNames);
            }

            // Mise à jour des données
            $atelier->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Profil mis à jour avec succès',
                'data' => $atelier->fresh()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du profil',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour la disponibilité
     */


    /**
     * Changer le statut d'activation
     */
    public function toggleStatus(Request $request)
    {
        try {
            $atelier = Auth::guard('atelier')->user();

            if (!$atelier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Atelier non trouvé'
                ], 404);
            }

            $atelier->update([
                'is_active' => !$atelier->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'data' => [
                    'is_active' => $atelier->is_active
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du statut',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
