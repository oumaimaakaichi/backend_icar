<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Demande;
use App\Models\DemandePanneInconnu;
use App\Models\VerificationCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpertAccountCreated;
use App\Mail\TechnicienAccountCreated;
use App\Mail\NewClientRegistrationAdminNotification;
use Illuminate\Support\Facades\Auth;
use App\Services\SmsService;
use App\Notifications\SendVerificationCode;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;


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

    // Générer un mot de passe aléatoire
    $randomPassword = Str::random(10); // 10 caractères aléatoires

    $technicien = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => bcrypt($randomPassword), // Enregistrer le mot de passe hashé
        'role' => 'technicien',
        'adresse' => $request->adresse,
        'atelier_id' => $request->atelier_id,
        'extra_data' => [
            'specialite' => $request->specialite,
            'annee_experience' => $request->annee_experience
        ]
    ]);

    // Envoyer l'email avec le mot de passe
    Mail::to($technicien->email)->send(new TechnicienAccountCreated($technicien, $randomPassword));

    return redirect()->route('atelierss.techniciensAtelier')->with('success', 'Technicien ajouté avec succès! Un email avec les informations de connexion a été envoyé.');
}


public function updateProfilTechnicien(Request $request)
{
    try {
        // Log incoming request for debugging
        \Log::info('Update profile request received', [
            'data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        // Validation des données
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'email' => 'sometimes|email|unique:users,email,'.$request->id,
            'phone' => 'sometimes|string|max:20',
            'password' => 'sometimes|string|min:6',
            'specialite' => 'sometimes|string',
            'qualifications' => 'sometimes|string',
            'annee_experience' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            \Log::warning('Validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        // Récupérer l'utilisateur
        $user = User::find($request->id);

        if (!$user) {
            \Log::error('User not found', ['id' => $request->id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        \Log::info('User found', ['user_id' => $user->id, 'email' => $user->email]);

        // Mettre à jour les champs de base
        if ($request->has('email')) {
            $user->email = $request->email;
            \Log::info('Email updated', ['new_email' => $request->email]);
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
            \Log::info('Phone updated', ['new_phone' => $request->phone]);
        }

        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
            \Log::info('Password updated');
        }

        // Mettre à jour les données extra
        $extraData = $user->extra_data ?? [];

        if ($request->has('specialite')) {
            $extraData['specialite'] = $request->specialite;
            \Log::info('Specialite updated', ['specialite' => $request->specialite]);
        }

        if ($request->has('qualifications')) {
            $extraData['qualifications'] = $request->qualifications;
            \Log::info('Qualifications updated', ['qualifications' => $request->qualifications]);
        }

        if ($request->has('annee_experience')) {
            $extraData['annee_experience'] = $request->annee_experience;
            \Log::info('Experience updated', ['annee_experience' => $request->annee_experience]);
        }

        $user->extra_data = $extraData;

        // Sauvegarder les modifications
        $saved = $user->save();

        if (!$saved) {
            \Log::error('Failed to save user', ['user_id' => $user->id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Échec de la sauvegarde'
            ], 500);
        }

        \Log::info('User profile updated successfully', ['user_id' => $user->id]);

        // Recharger l'utilisateur depuis la base de données
        $user->refresh();

        return response()->json([
            'status' => 'success',
            'message' => 'Profil mis à jour avec succès',
            'user' => $user
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Exception in updateProfilTechnicien', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur interne s\'est produite'
        ], 500);
    }
}


public function updateClient(Request $request, $id)
{
    // Valider les données
    $validated = $request->validate([
        'email' => 'required|email|unique:users,email,'.$id,
        'phone' => 'required|string|max:20',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    try {
        // Trouver l'utilisateur par ID
        $user = User::findOrFail($id);

        // Mettre à jour les champs
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Retourner la réponse
        return response()->json([
            'status' => 'success',
            'message' => 'Profil mis à jour avec succès',
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'phone' => $user->phone,
                'isActive' => $user->isActive,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
        ], 500);
    }
}
// Ajoutez cette méthode pour tester la connectivité
public function healthCheck()
{
    try {
        // Test simple de la base de données
        $userCount = User::count();

        return response()->json([
            'status' => 'success',
            'message' => 'API is working',
            'timestamp' => now(),
            'database' => 'connected',
            'users_count' => $userCount
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

// Middleware CORS personnalisé si nécessaire


 public function storeTech(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'adresse' => 'required|string|max:255',
        'specialite' => 'nullable|string',
        'annee_experience' => 'nullable|integer'
    ]);

    // Générer un mot de passe aléatoire
    $randomPassword = Str::random(10); // 10 caractères aléatoires

    $technicien = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => bcrypt($randomPassword), // Enregistrer le mot de passe hashé
        'role' => 'technicien',
        'adresse' => $request->adresse,
        'extra_data' => [
            'specialite' => $request->specialite,
            'annee_experience' => $request->annee_experience
        ]
    ]);

    // Envoyer l'email avec le mot de passe
    Mail::to($technicien->email)->send(new TechnicienAccountCreated($technicien, $randomPassword));

    return redirect()->route('atelierss.techniciensAtelier')->with('success', 'Technicien ajouté avec succès! Un email avec les informations de connexion a été envoyé.');
}
   public function storeExpert(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'adresse' => 'required|string|max:255',
        'specialite' => 'nullable|string',
        'annee_experience' => 'nullable|integer',
        'qualifications' => 'nullable|string',
    ]);

    // Générer un mot de passe aléatoire
    $randomPassword = Str::random(10); // 10 caractères aléatoires

    $expert = User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => bcrypt($randomPassword), // Enregistrer le mot de passe hashé
        'role' => 'expert',
        'adresse' => $request->adresse,
        'extra_data' => [
            'specialite' => $request->specialite,
            'annee_experience' => $request->annee_experience,
              'qualifications' => $request->qualifications
        ]
    ]);

    // Envoyer l'email avec le mot de passe
    Mail::to($expert->email)->send(new ExpertAccountCreated($expert, $randomPassword));

    return redirect()->route('experts')->with('success', 'expert ajouté avec succès! Un email avec les informations de connexion a été envoyé.');
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
public function getTechniciensSansAtelier()
{
    $techniciens = User::role('technicien')
        ->whereNull('atelier_id')
        ->where('isActive', true)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $techniciens,
    ]);
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
   public function edit()
{
    $user = Auth::user();
    return view('profile.edit', compact('user'));
}
   public function editAdmin()
{
    $user = Auth::user();
    return view('profile.admin-profil', compact('user'));
}


   public function editResponsable()
{
    $user = Auth::user();
    return view('profile.responsablePiéce', compact('user'));
}
public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email,' . $user->id,
        'phone' => 'required|string|min:6',
        'password' => 'nullable|string|min:6|confirmed',
        'specialite' => 'required|string|max:255',
        'annee_experience' => 'required|integer|min:0',
        'qualifications' => 'required|string',
    ]);

    $updateData = [
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'phone' => $request->phone,
    ];

    if ($request->password) {
        $updateData['password'] = Hash::make($request->password);
    }

    // Mise à jour des données spécifiques à l'expert
    $extraData = $user->extra_data ?? [];
    $extraData = array_merge($extraData, [
        'specialite' => $request->specialite,
        'annee_experience' => $request->annee_experience,
        'qualifications' => $request->qualifications,
    ]);

    $updateData['extra_data'] = $extraData;

    $user->update($updateData);

    return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès');
}
public function showRequestChoice()
{
    return view('reponsable_piece.choice');
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

    // Statistiques existantes
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
                        ->where('role', 'Client')
                        ->count(),
            'actifs' => User::where('atelier_id', $atelierId)
                         ->where('role', 'Client')
                         ->where('isActive', true)
                         ->count(),
            'inactifs' => User::where('atelier_id', $atelierId)
                           ->where('role', 'Client')
                           ->where('isActive', false)
                           ->count()
        ],
        'total_personnel' => User::where('atelier_id', $atelierId)
                              ->whereIn('role', ['technicien', 'Client'])
                              ->count(),
'demandesIN' => [
            'total' => DemandePanneInconnu::where('atelier_id', $atelierId)->count(),
            'en_attente' => DemandePanneInconnu::where('atelier_id', $atelierId)
                                 ->where('status', 'en_attente')
                                 ->count(),
            'assignees' => DemandePanneInconnu::where('atelier_id', $atelierId)
                                ->where('status', 'Assignée')
                                ->count(),

        ],

        // NOUVELLES STATISTIQUES DES DEMANDES
        'demandes' => [
            'total' => Demande::where('atelier_id', $atelierId)->count(),
            'en_attente' => Demande::where('atelier_id', $atelierId)
                                 ->where('status', 'Nouvelle_demande')
                                 ->count(),
            'assignees' => Demande::where('atelier_id', $atelierId)
                                ->where('status', 'Assignée')
                                ->count(),
            'terminees' => Demande::where('atelier_id', $atelierId)
                                ->where('status', 'Terminée')
                                ->count(),
            'annulees' => Demande::where('atelier_id', $atelierId)
                               ->where('status', 'Annulée')
                               ->count(),
        ],

        // Statistiques par mois pour l'année en cours
        'demandes_par_mois' => Demande::where('atelier_id', $atelierId)
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->mois => $item->total];
            })
            ->toArray(),

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

    $code = random_int(0,99);

    VerificationCode::updateOrCreate(
        ['email' => $request->email],
        ['code' => $code]
    );

    // Envoi du code par email
    Notification::route('mail', $request->email)
        ->notify(new SendVerificationCode($code));

    return response()->json(['message' => 'Code sent by email.']);
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
        'code' => 'required|string|size:2',
    ]);

    // Vérifier le code (adapté pour email au lieu de phone)
    $verification = VerificationCode::where('email', $validated['email'])
        ->where('code', $validated['code'])
        ->where('created_at', '>', now()->subMinutes(15))
        ->first();

    if (!$verification) {
        return response()->json([
            'success' => false,
            'message' => 'Incorrect or expired code'
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

    // Envoyer un email à l'administrateur
    try {
        Mail::to('oumaimaakaichi00@gmail.com')->send(new NewClientRegistrationAdminNotification($user));
    } catch (\Exception $e) {
        \Log::error('Failed to send admin notification email: ' . $e->getMessage());
    }

    return response()->json([
        'success' => true,
        'message' => 'Account created successfully',
        'user' => $user
    ]);
}



public function getTechniciensSansAteliers()
{
    $techniciens = User::where('role', 'technicien')
        ->whereNull('atelier_id')
        ->where('isActive', true)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $techniciens,
    ]);
}
public function forgotPassword(Request $request)
{
    try {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email invalide ou inexistant'
            ], 400);
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        // Generate new random password
        $newPassword = Str::random(10);

        // Update user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Send new password via email
        try {
            Mail::to($user->email)->send(new \App\Mail\ForgotPasswordMail($user, $newPassword));
        } catch (\Exception $mailException) {
            // Log email error but continue
            \Log::error('Failed to send forgot password email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $mailException->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de l\'envoi de l\'email'
            ], 500);
        }

        \Log::info('Password reset successful', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Un nouveau mot de passe a été envoyé à votre adresse email'
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Exception in forgotPassword', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Une erreur interne s\'est produite'
        ], 500);
    }

}

}
