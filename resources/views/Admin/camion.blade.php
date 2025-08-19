<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Camions</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        :root {
            --primary-color: #4361ee; /* Cadet blue */
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
        }

        .container {
            padding-top: 20px;
            padding-bottom: 50px;
        }

        .page-header {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            width: 1200px;
        }

        #tableCamions {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        #tableCamions thead th {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
        }

        #tableCamions tbody tr {
            transition: all 0.2s ease;
        }

        #tableCamions tbody tr:hover {
            background-color: rgba(95, 158, 160, 0.1);
            transform: translateY(-1px);
        }

        #tableCamions td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
            text-align: center;
        }

        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .badge-nord {
            background-color: #17a2b8;
            color: white;
        }

        .badge-sud {
            background-color: #28a745;
            color: white;
        }

        .badge-est {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-ouest {
            background-color: #fd7e14;
            color: white;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #4d8688;
            border-color: #4d8688;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 30px;
            border: 1px solid #dee2e6;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        .modal-title i {
            margin-right: 10px;
        }

        .pagination-controls {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination-controls .btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 15px;
            }

            #tableCamions {
                display: block;
                overflow-x: auto;
            }

            #tableCamions thead th,
            #tableCamions td {
                padding: 10px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('Sidebar.sidebar')

        <!-- Main Content -->
        <div class="container" style="margin-top: 70px ; margin-right:60px">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-truck"></i> Truck Management</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterCamionModal">
                        <i class="fas fa-plus me-2"></i>Add Truck
                    </button>
                </div>
            </div>

            <!-- Search Boxes -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchNomCamion" class="form-control" placeholder="Search by truck name...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-compass"></i>
                        <input type="text" id="searchDirection" class="form-control" placeholder="Search by direction...">
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Table Container -->
            <div class="table-container">
                <table class="table table-hover" id="tableCamions">
                    <thead>
                        <tr>
                            <th>Truck</th>
                            <th>Location</th>
                            <th>Map Link</th>
                            <th>Agreement Date</th>
                            <th>Direction</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="CamionTable">
                        @foreach ($camions as $camion)
                            <tr>
                                <td class="camion-nom fw-bold">{{ $camion->nom_camion }}</td>
                                <td>{{ $camion->emplacement }}</td>
                                <td>
                                    <a href="{{ $camion->lien_map }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-map-marked-alt me-1"></i> View Map
                                    </a>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($camion->date_accord)) }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($camion->direction) }}">
                                        {{ $camion->direction }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('camions.show', $camion->id) }}" class="btn btn-sm btn-outline-secondary action-btn" title="Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-warning action-btn btn-edit-camion"
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
                                                data-bs-toggle="modal" data-bs-target="#modifierCamionModal"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('camions.destroy', $camion->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger action-btn"
                                                    onclick="return confirm('Are you sure you want to delete this truck?')"
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

                <!-- Pagination -->
                <div class="pagination-controls">
                    <button id="prevBtn" class="btn btn-outline-secondary" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="nextBtn" class="btn btn-outline-secondary">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Truck Modal -->
    <div class="modal fade" id="ajouterCamionModal" tabindex="-1" aria-labelledby="ajouterCamionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajouterCamionModalLabel">
                        <i class="fas fa-truck"></i> Add New Truck
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAjoutCamion" action="{{ route('camions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-truck me-2"></i>Truck Name</label>
                                    <input type="text" name="nom_camion" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-users me-2"></i>Technicians</label>
                                    <select name="techniciens[]" class="form-select" multiple required>
                                        @foreach ($techniciens as $technicien)
                                            <option value="{{ $technicien->id }}">{{ $technicien->nom }} {{ $technicien->prenom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-truck-moving me-2"></i>Truck Type</label>
                                    <input type="text" name="type_camion" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Location</label>
                                    <input type="text" name="emplacement" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-building me-2"></i>Company Name</label>
                                    <input type="text" name="nom_entreprise" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Agreement Date</label>
                                    <input type="date" name="date_accord" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-compass me-2"></i>Direction</label>
                                    <select name="direction" class="form-select" required>
                                        <option value="Nord">North</option>
                                        <option value="Sud">South</option>
                                        <option value="Est">East</option>
                                        <option value="Ouest">West</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map-pin me-2"></i>Truck Location</label>
                            <div id="map"></div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map me-2"></i>Map Link</label>
                            <input type="url" name="lien_map" class="form-control" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Save Truck
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Truck Modal -->
    <div class="modal fade" id="modifierCamionModal" tabindex="-1" aria-labelledby="modifierCamionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modifierCamionModalLabel">
                        <i class="fas fa-edit me-2"></i>Update Truck
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCamionForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editCamionId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-truck me-2"></i>Truck Name</label>
                                    <input type="text" name="nom_camion" id="editNomCamion" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-truck-moving me-2"></i>Truck Type</label>
                                    <input type="text" name="type_camion" id="editTypeCamion" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Location</label>
                                    <input type="text" name="emplacement" id="editEmplacementCamion" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-building me-2"></i>Company Name</label>
                                    <input type="text" name="nom_entreprise" id="editNomEntreprise" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>Agreement Date</label>
                                    <input type="date" name="date_accord" id="editDateAccord" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-compass me-2"></i>Direction</label>
                                    <select name="direction" id="editDirection" class="form-select" required>
                                        <option value="Nord">North</option>
                                        <option value="Sud">South</option>
                                        <option value="Est">East</option>
                                        <option value="Ouest">West</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map-pin me-2"></i>Position</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="editLatitude" class="form-label">Latitude</label>
                                    <input type="text" id="editLatitude" name="latitude" class="form-control" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="editLongitude" class="form-label">Longitude</label>
                                    <input type="text" id="editLongitude" name="longitude" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map me-2"></i>Map Link</label>
                            <input type="url" name="lien_map" id="editLienMap" class="form-control" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Update Truck
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        $(document).ready(function () {
            // Map initialization
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

            // Edit truck modal handling
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

            // Table filtering
            $('#searchNomCamion, #searchDirection').on('input', function() {
                var searchNom = $('#searchNomCamion').val().toLowerCase();
                var searchDirection = $('#searchDirection').val().toLowerCase();

                $('#CamionTable tr').each(function() {
                    var nomMatch = $(this).find('.camion-nom').text().toLowerCase().includes(searchNom);
                    var directionMatch = $(this).find('.badge').text().toLowerCase().includes(searchDirection);

                    $(this).toggle(nomMatch && directionMatch);
                });

                // Reset pagination when filtering
                currentPage = 0;
                showPage(currentPage);
            });

            // Pagination
            let currentPage = 0;
            const rowsPerPage = 5;
            const rows = $("#CamionTable tr");

            function showPage(page) {
                const filteredRows = rows.filter(':visible');

                filteredRows.hide();
                filteredRows.slice(page * rowsPerPage, (page + 1) * rowsPerPage).show();

                $('#prevBtn').prop('disabled', page === 0);
                $('#nextBtn').prop('disabled', (page + 1) * rowsPerPage >= filteredRows.length);
            }

            $('#prevBtn').click(function() {
                if (currentPage > 0) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            $('#nextBtn').click(function() {
                const filteredRows = rows.filter(':visible');
                if ((currentPage + 1) * rowsPerPage < filteredRows.length) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            // Initialize
            showPage(currentPage);
        });
    </script>
</body>
</html>
