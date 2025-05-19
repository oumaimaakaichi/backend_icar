<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Atelier</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Inscription Atelier</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('atelier.inscription.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nom Commercial -->
            <label class="block">Nom Commercial</label>
            <input type="text" name="nom_commercial" required class="input-field">

            <!-- Numéro Registre Commerce -->
            <label class="block">Numéro de Registre de Commerce</label>
            <input type="number" name="num_registre_commerce" required class="input-field">

            <!-- Numéro Fiscal -->
            <label class="block">Numéro Fiscal</label>
            <input type="number" name="num_fiscal" required class="input-field">

            <!-- Email -->
            <label class="block">Email</label>
            <input type="email" name="email" required class="input-field">

            <!-- Mot de passe -->
            <label class="block">Mot de passe</label>
            <input type="password" name="password" required minlength="8" class="input-field">

            <!-- Confirmation du mot de passe -->
            <label class="block">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="input-field">

            <!-- Ville -->
            <label class="block">Ville</label>
            <input type="text" name="ville" required class="input-field">

            <!-- Site Web -->
            <label class="block">Site Web</label>
            <input type="url" name="site_web" class="input-field">

            <!-- Nom de la Banque -->
            <label class="block">Nom de la Banque</label>
            <input type="text" name="nom_banque" required class="input-field">

            <!-- Numéro IBAN -->
            <label class="block">Numéro IBAN</label>
            <input type="text" name="num_IBAN" required class="input-field">

            <!-- Nom du Directeur -->
            <label class="block">Nom du Directeur</label>
            <input type="text" name="nom_directeur" required class="input-field">

            <!-- Numéro de Contact -->
            <label class="block">Numéro de Contact</label>
            <input type="text" name="num_contact" required class="input-field">

            <!-- Spécialisation du Centre -->
            <label class="block">Spécialisation du Centre</label>
            <input type="text" name="specialisation_centre" required class="input-field">

            <!-- Type Entreprise -->
            <label class="block">Type d'Entreprise</label>
            <select name="type_entreprise" required class="input-field">
                <option value="1">SARL</option>
                <option value="2">EURL</option>
                <option value="3">SA</option>
            </select>

            <!-- Document -->
            <label class="block">Document (PDF, Word, etc.)</label>
            <input type="file" name="document" accept=".pdf,.doc,.docx" class="input-field">

            <!-- Photos du Centre -->
            <label class="block">Photos du Centre</label>
            <input type="file" name="photos_centre" accept="image/*" class="input-field">

            <!-- Nombre de Techniciens -->
            <label class="block">Nombre de Techniciens</label>
            <input type="number" name="nbr_techniciens" required min="0" class="input-field">

            <!-- Techniciens -->
            <label class="block">Techniciens</label>
            <input type="text" name="techniciens" class="input-field">

            <!-- Actif -->
            <label class="flex items-center space-x-2 mt-3">
                <input type="checkbox" name="is_active" checked class="h-4 w-4 text-blue-600">
                <span>Activer l'atelier</span>
            </label>

            <!-- Bouton de Soumission -->
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 mt-6">
                S'inscrire
            </button>
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="{{ route('atelier.login.form') }}" class="text-blue-500 hover:underline">Connectez-vous ici</a>
                </p>
            </div>
        </form>
    </div>

    <style>
        .input-field {
            display: block;
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            focus:border-blue-500 focus:ring focus:ring-blue-200;
        }
    </style>
</body>
</html>
