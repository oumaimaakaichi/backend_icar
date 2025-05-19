<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use App\Services\SmsService;
use App\Notifications\SendVerificationCode;
use Illuminate\Support\Facades\Notification;
class UserController extends Controller
{
    // Lister tous les utilisateurs
    public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('users.index', compact('users'));
    }
    public function storee(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'atelier_id' => 'required|exists:users,id',
            'specialite' => 'nullable|string',
            'annee_experience' => 'nullable|integer'
        ]);

        $technicien = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt('password'),
            'role' => 'technicien',
            'adresse' => $request->adresse,
           'atelier_id' => $request->atelier_id,
            'extra_data' => [
                'specialite' => $request->specialite,
                'annee_experience' => $request->annee_experience
            ]
        ]);

        return redirect()->route('atelierss.techniciensAtelier')->with('success', 'Technicien ajouté avec succès!');
    }
    //crréer nouvelle utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,technicien,employe,expert',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour l'image
            'photo_carte_identite' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour l'image de la carte d'identité

        ]);

        $extraData = [];

        // Gestion de l'image pour les techniciens et experts
        if ($request->role === 'technicien' || $request->role === 'expert') {
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public'); // Stocke l'image dans le dossier `storage/app/public/photos`
                $photoPath = str_replace('\\', '/', $photoPath); // Remplace les barres obliques inversées
                $extraData['photo'] = $photoPath;
            }

            $extraData = array_merge($extraData, [
                'specialite' => $request->specialite,
                'qualifications' => $request->qualifications,
                'annee_experience' => $request->annee_experience,
                'marque_voiture' => $request->marque_voiture,
            ]);

            if ($request->role === 'technicien') {
                $extraData['responsable_direct'] = $request->responsable_direct;
                $request->validate([
                    'atelier_id' => 'required|exists:ateliers,id',
                ]);
            }
        }

        // Gestion de l'image de la carte d'identité pour les employés
        if ($request->role === 'employe') {
            $request->validate([
                'entreprise_contractante_id' => 'required|exists:entreprises_contractante,id',
            ]);

            if ($request->hasFile('photo_carte_identite')) {
                $carteIdentitePath = $request->file('photo_carte_identite')->store('carte_identite', 'public');
                $carteIdentitePath = str_replace('\\', '/', $carteIdentitePath);
                $extraData['photo_carte_identite'] = $carteIdentitePath;
            }

            $extraData = array_merge($extraData, [
                'nom_entreprise' => $request->nom_entreprise,
                'email_employe' => $request->email_employe,
                'carte_professionnel' => $request->carte_professionnel,
            ]);
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'adresse' => $request->adresse,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'extra_data' => $extraData,
            'isActive' => false, // Par défaut false
            'atelier_id' => $request->atelier_id, // <-- ici on ajoute l'association*
            'entreprise_contractante_id' => $request->entreprise_contractante_id, // Ajout du champ
        ]);

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user]);
    }

    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
    }

    // Afficher un utilisateur spécifique   (get user par id )
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,' . $id,
            'phone' => 'sometimes|string|min:6',
            'password' => 'sometimes|string|min:6',
        ]);

        $user->update([
            'nom' => $request->nom ?? $user->nom,
            'prenom' => $request->prenom ?? $user->prenom,
            'email' => $request->email ?? $user->email,
            'phone' => $request->phone ?? $user->phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json(['message' => 'Utilisateur mis à jour', 'user' => $user]);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }
    // modifier les informations d'un utilisateur
    public function updateEmailPhoneAndAddress(Request $request, $id)
    {
        $request->validate([
            'email' => 'sometimes|string|email|unique:users,email,' . $id,
            'phone' => 'sometimes|string|max:255',
            'adresse' => 'sometimes|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $data = [];
        if ($request->has('email')) {
            $data['email'] = $request->email;
        }
        if ($request->has('phone')) {
            $data['phone'] = $request->phone;
        }
        if ($request->has('adresse')) {
            $data['adresse'] = $request->adresse;
        }

        if (!empty($data)) {
            $user->update($data);
            return response()->json(['message' => 'Email, téléphone et/ou adresse mis à jour avec succès', 'user' => $user]);
        }

        return response()->json(['message' => 'Aucune modification apportée'], 400);
    }

    //activer un user
    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['isActive' => true]);

        return response()->json(['message' => 'Utilisateur activé avec succès', 'user' => $user]);
    }
     //désactiver un user
     public function désactivateUser($id)
     {
         $user = User::findOrFail($id);
         $user->update(['isActive' => false]);

         return response()->json(['message' => 'Utilisateur désactivé avec succès', 'user' => $user]);
     }

    //suspend
        public function suspend(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->suspended = true;
        $user->suspension_reason = $request->input('reason');
        $user->save();

        return response()->json(['message' => 'Employé suspendu avec succès !']);
    }

    //api delete technicien


      public function destroyTechnicien(User $technicien)
      {
          // Vérifier que le technicien appartient bien à l'atelier de l'utilisateur connecté
          if ($technicien->atelier_id !== Auth::id()) {
              abort(403, 'Action non autorisée');
          }

          $technicien->delete();

          return redirect()->route('techniciensAtelier')
                           ->with('success', 'Technicien supprimé avec succès');
      }

// statistique
      public function statistiques()
      {
          $atelierId = Auth::id();

          $stats = [
              'techniciens' => [
                  'total' => User::where('atelier_id', $atelierId)
                               ->where('role', 'technicien')
                               ->count(),
                  'actifs' => User::where('atelier_id', $atelierId)
                               ->where('role', 'technicien')
                               ->where('isActive', true)
                               ->count(),
                  'inactifs' => User::where('atelier_id', $atelierId)
                                 ->where('role', 'technicien')
                                 ->where('isActive', false)
                                 ->count()
              ],
              'employes' => [
                  'total' => User::where('atelier_id', $atelierId)
                              ->where('role', 'employe')
                              ->count(),
                  'actifs' => User::where('atelier_id', $atelierId)
                               ->where('role', 'employe')
                               ->where('isActive', true)
                               ->count(),
                  'inactifs' => User::where('atelier_id', $atelierId)
                                 ->where('role', 'employe')
                                 ->where('isActive', false)
                                 ->count()
              ],
              'total_personnel' => User::where('atelier_id', $atelierId)
                                    ->whereIn('role', ['technicien', 'employe'])
                                    ->count(),
              'recentActivities' => [] // Vous pouvez ajouter des données d'activité ici
          ];

          return view('ateliers.statistiqueAtelier', compact('stats'));
      }

// Add these methods to your UserController
public function approveUser($id)
{
    $user = User::findOrFail($id);
    $user->update([
        'status' => User::STATUS_APPROVED,
        'rejection_reason' => null // Clear any previous rejection reason
    ]);

    return response()->json([
        'message' => 'User approved successfully',
        'user' => $user
    ]);
}

//rejeter
public function rejectUser(Request $request, $id)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:255'
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'status' => User::STATUS_REJECTED,
        'rejection_reason' => $request->rejection_reason
    ]);

    return response()->json([
        'message' => 'User rejected successfully',
        'user' => $user
    ]);
}




// Statistiques pour l'entreprise contractante
public function statistiquesEntreprise()
{
    $entrepriseId = Auth::id();

    $stats = [
        'employes' => [
            'total' => User::where('entreprise_contractante_id', $entrepriseId)
                         ->where('role', 'employe')
                         ->count(),
            'approuves' => User::where('entreprise_contractante_id', $entrepriseId)
                              ->where('role', 'employe')
                              ->where('status', User::STATUS_APPROVED)
                              ->count(),
            'rejetes' => User::where('entreprise_contractante_id', $entrepriseId)
                           ->where('role', 'employe')
                           ->where('status', User::STATUS_REJECTED)
                           ->count(),
            'en_attente' => User::where('entreprise_contractante_id', $entrepriseId)
                               ->where('role', 'employe')
                               ->where('status', User::STATUS_PENDING)
                               ->count(),
            'actifs' => User::where('entreprise_contractante_id', $entrepriseId)
                         ->where('role', 'employe')
                         ->where('isActive', true)
                         ->count(),
            'inactifs' => User::where('entreprise_contractante_id', $entrepriseId)
                             ->where('role', 'employe')
                             ->where('isActive', false)
                             ->count()
        ],
        'total_personnel' => User::where('entreprise_contractante_id', $entrepriseId)
                              ->where('role', 'employe')
                              ->count(),
    ];

    return view('entreprise.statistique', compact('stats'));
}






public function storeTechnicien(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'adresse' => 'required|string',
        'atelier_id' => 'required|string',
        'role' => 'required|string|in:technicien',

        // Ces champs seront stockés dans extra_data
        'specialite' => 'nullable|string',
        'qualifications' => 'nullable|string',
        'annee_experience' => 'nullable|string',
        'responsable_direct' => 'nullable|string',
    ]);

    // Préparer les données supplémentaires pour extra_data
    $extraData = [
        'specialite' => $validated['specialite'] ?? null,
        'qualifications' => $validated['qualifications'] ?? null,
        'annee_experience' => $validated['annee_experience'] ?? null,
        'responsable_direct' => $validated['responsable_direct'] ?? null,
    ];

    $user = new User();
    $user->fill([
        'nom' => $validated['nom'],
        'prenom' => $validated['prenom'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'adresse' => $validated['adresse'],
        'phone' => $validated['phone'],
        'atelier_id' => $validated['atelier_id'],
        'role' => $validated['role'],
        'extra_data' => $extraData,
        'isActive' => false, // Par défaut false
    ]);

    $user->save();

    return response()->json(['message' => 'Technicien ajouté avec succès'], 200);
}






public function sendCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $code = rand(1000, 9999);

    VerificationCode::updateOrCreate(
        ['email' => $request->email],
        ['code' => $code]
    );

    // Envoi du code par email
    Notification::route('mail', $request->email)
        ->notify(new SendVerificationCode($code));

    return response()->json(['message' => 'Code envoyé par email.']);
}

public function registerClient(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|unique:users,phone',
        'adresse' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
        'code' => 'required|string|size:4',
    ]);

    // Vérifier le code (adapté pour email au lieu de phone)
    $verification = VerificationCode::where('email', $validated['email'])
        ->where('code', $validated['code'])
        ->where('created_at', '>', now()->subMinutes(15))
        ->first();

    if (!$verification) {
        return response()->json([
            'success' => false,
            'message' => 'Code incorrect ou expiré'
        ], 400);
    }

    // Créer l'utilisateur
    $user = User::create([
        'nom' => $validated['nom'],
        'prenom' => $validated['prenom'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'adresse' => $validated['adresse'],
        'password' => Hash::make($validated['password']),
        'role' => 'Client',
    ]);

    // Supprimer le code utilisé
    $verification->delete();

    return response()->json([
        'success' => true,
        'message' => 'Compte créé avec succès',
        'user' => $user
    ]);
}

    }

