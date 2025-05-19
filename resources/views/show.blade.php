<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Camions</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    </head>
    <body>

   <!-- Sidebar -->
@include('Sidebar.sidebar')

<div class="container mt-4">
    <div class="card"   style="margin-top: 50px">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">🚛 Détails du Camion</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Truck Name</th>
                    <td>{{ $camion->nom_camion }}</td>
                </tr>
                <tr>
                    <th>Truck Type</th>
                    <td>{{ $camion->type_camion }}</td>
                </tr>
                <tr>
                    <th>Company Name </th>
                    <td>{{ $camion->nom_entreprise }}</td>
                </tr>
                <tr>
                    <th>Agreement Date</th>
                    <td>{{ \Carbon\Carbon::parse($camion->date_accord)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Direction</th>
                    <td>{{ $camion->direction }}</td>
                </tr>
                <tr>
                    <th>Latitude</th>
                    <td>{{ $camion->latitude }}</td>
                </tr>
                <tr>
                    <th>Longitude</th>
                    <td>{{ $camion->longitude }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-4 mb-4">
        <h4 class="text-center"> Truk Location</h4>
        <div id="map" style="height: 400px; border-radius: 10px;"></div>
    </div>

</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            var latitude = {{ $camion->latitude ?? 0 }};
            var longitude = {{ $camion->longitude ?? 0 }};
            var map = L.map('map').setView([latitude, longitude], 12);

            // Ajout des tuiles OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Ajout d'un marqueur à la position du camion
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup("<b>🚛 Truck Location</b><br>{{ $camion->nom_camion }}")
                .openPopup();
        }, 500);
    });
</script>

</body>
</html>
