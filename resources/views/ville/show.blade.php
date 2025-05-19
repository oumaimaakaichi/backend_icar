<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la ville - {{ $ville->nomville }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #villeMap {
            height: 500px;
            width: 100%;
            border-radius: 0.5rem;
            margin-top: 1rem;
            z-index: 1;
        }
        .leaflet-popup-content {
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-indigo-800 text-white shadow-lg">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-city mr-3"></i>
                        Détails de la ville
                    </h1>
                    <a href="{{ url()->previous() }}" class="bg-white text-indigo-800 px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Retour
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                <!-- Ville Info -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                        Informations sur la ville
                    </h2>
                    <div class="mt-4 pl-10">
                        <p class="text-lg">
                            <span class="font-bold">Nom :</span> {{ $ville->nomville }}
                        </p>

                    </div>
                </div>

                <!-- Map Section -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-map-marked-alt text-indigo-600 mr-2"></i>
                        Localisation sur la carte
                    </h2>
                    <div id="villeMap"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser la carte avec la position de la ville
            const map = L.map('villeMap').setView([{{ $ville->latitude }}, {{ $ville->longitude }}], 13);

            // Ajouter la couche de tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Ajouter un marqueur pour la ville
            L.marker([{{ $ville->latitude }}, {{ $ville->longitude }}])
                .addTo(map)
                .bindPopup("<b>{{ $ville->nomville }}</b><br>Position de la ville")
                .openPopup();

            // Ajouter un cercle pour mieux visualiser la position
            L.circle([{{ $ville->latitude }}, {{ $ville->longitude }}], {
                color: '#4361ee',
                fillColor: '#3f37c9',
                fillOpacity: 0.3,
                radius: 500
            }).addTo(map);
        });
    </script>
</body>
</html>
