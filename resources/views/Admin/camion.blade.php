<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Camions</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 300px;
            width: 100%;
            margin-bottom: 20px;
        }

        .modal-body {
            overflow: visible;
        }

        .table-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }

        .btn-sm {
            padding: 5px 10px;
        }

        .btn-info {
            background-color: cadetblue;
            border: none;
        }

        .btn-outline-primary {
            border: 1px solid #007bff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        #tableCamions {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        #tableCamions th {
            padding: 12px 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
        }

        #tableCamions td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }

        @media (max-width: 768px) {
            #tableCamions {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
@include('Sidebar.sidebar')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="margin-top: 50px">List of Trucks</h2>
        <button class="btn btn-primary" data-toggle="modal" data-target="#ajouterCamionModal" style="background-color: cadetblue">
            <i class="fas fa-plus"></i> Add a Truck
        </button>
    </div>

    <!-- Barre de recherche -->
    <div class="mb-3">
        <input type="text" id="searchNomCamion" class="form-control" placeholder="Search by truck name...">
    </div>
    <div class="mb-3">
        <input type="text" id="searchDirection" class="form-control" placeholder="Search by direction...">
    </div>

    <div class="table-responsive table-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped table-hover align-middle" id="tableCamions" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Truck</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">Map Link</th>
                    <th class="text-center">Agreement Date</th>
                    <th class="text-center">Direction</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="CamionTable">
                @foreach ($camions as $camion)
                    <tr>
                        <td class="text-center camion-nom">{{ $camion->nom_camion }}</td>
                        <td class="text-center">{{ $camion->emplacement }}</td>
                        <td class="text-center">
                            <a href="{{ $camion->lien_map }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-map-marked-alt me-1"></i> View Map
                            </a>
                        </td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($camion->date_accord)) }}</td>
                        <td class="text-center camion-direction">
                            <span class="badge bg-{{ $camion->direction === 'Nord' ? 'info' : ($camion->direction === 'Sud' ? 'success' : 'warning') }}">
                                {{ $camion->direction }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('camions.show', $camion->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle action-btn" title="Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-warning rounded-circle action-btn btn-edit-camion"
                                        data-id="{{ $camion->id }}"
                                        data-nom="{{ $camion->nom_camion }}"
                                        data-type="{{ $camion->type_camion }}"
                                        data-emplacement="{{ $camion->emplacement }}"
                                        data-latitude="{{ $camion->latitude }}"
                                        data-longitude="{{ $camion->longitude }}"
                                        data-lien="{{ $camion->lien_map }}"
                                        data-entreprise="{{ $camion->nom_entreprise }}"
                                        data-date="{{ $camion->date_accord }}"
                                        data-direction="{{ $camion->direction }}"
                                        data-toggle="modal" data-target="#modifierCamionModal"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('camions.destroy', $camion->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle action-btn"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce camion ?')"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex" style="margin-left: 50%">
            <button id="prevBtn" class="btn btn-secondary" disabled><i class="fas fa-arrow-left"></i></button>&nbsp;
            <button id="nextBtn" class="btn btn-secondary"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="ajouterCamionModal" tabindex="-1" aria-labelledby="ajouterCamionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: cadetblue">
                <h5 class="modal-title" id="ajouterCamionModalLabel">
                    <i class="fas fa-truck"></i> Add a Truck
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAjoutCamion" action="{{ route('camions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label><i class="fas fa-truck"></i> Truck Name</label>
                        <input type="text" name="nom_camion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-users"></i> Technicians</label>
                        <select name="techniciens[]" class="form-control" multiple required>
                            @foreach ($techniciens as $technicien)
                                <option value="{{ $technicien->id }}">{{ $technicien->nom }} {{ $technicien->prenom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-truck-moving"></i> Truck Type</label>
                        <input type="text" name="type_camion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Location</label>
                        <input type="text" name="emplacement" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-pin"></i> Truck Location</label>
                        <div id="map"></div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map"></i> Map Link</label>
                        <input type="url" name="lien_map" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Company Name</label>
                        <input type="text" name="nom_entreprise" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Agreement Date</label>
                        <input type="date" name="date_accord" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-compass"></i> Direction</label>
                        <select name="direction" class="form-control" required>
                            <option value="Nord">North</option>
                            <option value="Sud">South</option>
                            <option value="Est">East</option>
                            <option value="Ouest">West</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifier un Camion -->
<div class="modal fade" id="modifierCamionModal" tabindex="-1" aria-labelledby="modifierCamionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modifierCamionModalLabel">
                    <i class="fas fa-edit"></i> Update a Truck
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCamionForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="editCamionId">
                    <div class="form-group">
                        <label><i class="fas fa-truck"></i>Truck Name</label>
                        <input type="text" name="nom_camion" id="editNomCamion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-truck-moving"></i> Truck Type</label>
                        <input type="text" name="type_camion" id="editTypeCamion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Location</label>
                        <input type="text" name="emplacement" id="editEmplacementCamion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-pin"></i> Position</label>
                        <input type="text" id="editLatitude" name="latitude" class="form-control" readonly required>
                        <input type="text" id="editLongitude" name="longitude" class="form-control" readonly required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map"></i> Map Link</label>
                        <input type="url" name="lien_map" id="editLienMap" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Company Name</label>
                        <input type="text" name="nom_entreprise" id="editNomEntreprise" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Agreement Date</label>
                        <input type="date" name="date_accord" id="editDateAccord" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-compass"></i> Direction</label>
                        <select name="direction" id="editDirection" class="form-control" required>
                            <option value="Nord">North</option>
                            <option value="Sud">South</option>
                            <option value="Est">East</option>
                            <option value="Ouest">West</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    $(document).ready(function () {
        // Initialisation de la carte
        var map, marker;
        $('#ajouterCamionModal').on('shown.bs.modal', function () {
            if (!map) {
                map = L.map('map').setView([36.81897000, 10.16579000], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                marker = L.marker([36.81897000, 10.16579000], { draggable: true }).addTo(map);
                marker.on('dragend', function (event) {
                    var position = marker.getLatLng();
                    $('#latitude').val(position.lat);
                    $('#longitude').val(position.lng);
                });
                map.on('click', function (event) {
                    var latLng = event.latlng;
                    marker.setLatLng(latLng);
                    $('#latitude').val(latLng.lat);
                    $('#longitude').val(latLng.lng);
                });
                map.invalidateSize();
            } else {
                map.setView([36.81897000, 10.16579000], 12);
                marker.setLatLng([36.81897000, 10.16579000]);
            }
        });

        // Gestion de l'édition
        $('.btn-edit-camion').click(function () {
            var id = $(this).data('id');
            var nom = $(this).data('nom');
            var type = $(this).data('type');
            var emplacement = $(this).data('emplacement');
            var latitude = $(this).data('latitude');
            var longitude = $(this).data('longitude');
            var lien = $(this).data('lien');
            var entreprise = $(this).data('entreprise');
            var date = $(this).data('date');
            var direction = $(this).data('direction');

            $('#editCamionId').val(id);
            $('#editNomCamion').val(nom);
            $('#editTypeCamion').val(type);
            $('#editEmplacementCamion').val(emplacement);
            $('#editLatitude').val(latitude);
            $('#editLongitude').val(longitude);
            $('#editLienMap').val(lien);
            $('#editNomEntreprise').val(entreprise);
            $('#editDateAccord').val(date);
            $('#editDirection').val(direction);

            var updateUrl = "/camions/" + id;
            $('#editCamionForm').attr('action', updateUrl);
        });

        // Filtrage du tableau
        $('#searchNomCamion, #searchDirection').on('input', function() {
            var searchNom = $('#searchNomCamion').val().toLowerCase();
            var searchDirection = $('#searchDirection').val().toLowerCase();

            $('#CamionTable tr').each(function() {
                var nomMatch = $(this).find('.camion-nom').text().toLowerCase().includes(searchNom);
                var directionMatch = $(this).find('.camion-direction').text().toLowerCase().includes(searchDirection);

                $(this).toggle(nomMatch && directionMatch);
            });
        });

        // Pagination
        let currentPage = 0;
        const rowsPerPage = 5;
        const rows = $("#CamionTable tr");

        function showPage(page) {
            rows.hide();
            rows.slice(page * rowsPerPage, (page + 1) * rowsPerPage).show();
            $('#prevBtn').prop('disabled', page === 0);
            $('#nextBtn').prop('disabled', (page + 1) * rowsPerPage >= rows.length);
        }

        $('#prevBtn').click(function() {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        });

        $('#nextBtn').click(function() {
            if ((currentPage + 1) * rowsPerPage < rows.length) {
                currentPage++;
                showPage(currentPage);
            }
        });

        showPage(currentPage);
    });
</script>
</body>
</html>
