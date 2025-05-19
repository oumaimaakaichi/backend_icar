<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des catalogues</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .modal-content {
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Sidebar -->
    @include('Sidebar.sidebar')
    <div class="container mt-5" >
        <h1 class="text-center mb-4"  style="margin-top: 50px">List of Catalogs</h1>
        <!-- Champ de recherche -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search ...">
        </div>
        <!-- Bouton pour ouvrir la popup d'ajout -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCatalogueModal" style="background-color:#6c7584">
            <i class="fas fa-plus"></i> Add a Catalog
        </button>
        <!-- Tableau pour afficher la liste des catalogues -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Car Type</th>
                    <th>Piece Name</th>
                    <th>Piece Number</th>
                    <th>Country of Manufacture</th>
                    <th>Part Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="catalogueTable">
                @foreach ($catalogues as $catalogue)
                    <tr>
                        <td class="searchable">{{ $catalogue->entreprise }}</td>
                        <td class="searchable">{{ $catalogue->type_voiture }}</td>
                        <td class="searchable">{{ $catalogue->nom_piece }}</td>
                        <td>{{ $catalogue->num_piece }}</td>
                        <td>{{ $catalogue->paye_fabrication }}</td>
                        <td>
                            @if ($catalogue->photo_piece)
                                <img src="{{ asset('storage/' . $catalogue->photo_piece) }}" alt="Photo" width="50">
                            @else
                                Pas de photo
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCatalogueModal{{ $catalogue->id }}"  data-bs-toggle="tooltip"
                                data-bs-placement="top" title="edit catalog"  >
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('catalogues.destroy', $catalogue->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce catalogue ?')"  data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete catalog">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Boutons de pagination -->
        <div class="d-flex " style="margin-left: 50%">
            <button id="prevBtn" class="btn btn-secondary" disabled><i class="fas fa-arrow-left"></i></button>&nbsp;
            <button id="nextBtn" class="btn btn-secondary"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- Popup pour ajouter un catalogue -->
    <div class="modal fade" id="addCatalogueModal" tabindex="-1" aria-labelledby="addCatalogueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCatalogueModalLabel">
                        <i class="fas fa-plus-circle"></i> Add a Catalog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('catalogues.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-building"></i> Company</label>
                                <input type="text" name="entreprise" class="form-control" placeholder="Enter company name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-car"></i> Car Type</label>
                                <input type="text" name="type_voiture" class="form-control" placeholder="Enter car type" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-cogs"></i> Part Name</label>
                                <input type="text" name="nom_piece" class="form-control" placeholder="Enter part name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-hashtag"></i> Part Number</label>
                                <input type="number" name="num_piece" class="form-control" placeholder="Enter part number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-globe"></i> Country of Manufacture</label>
                                <input type="text" name="paye_fabrication" class="form-control" placeholder="Enter country" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-image"></i> Part Photo</label>
                                <input type="file" name="photo_piece" class="form-control">
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup pour modifier un catalogue -->
    @foreach ($catalogues as $catalogue)
    <div class="modal fade" id="editCatalogueModal{{ $catalogue->id }}" tabindex="-1" aria-labelledby="editCatalogueModalLabel{{ $catalogue->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editCatalogueModalLabel{{ $catalogue->id }}">
                        <i class="fas fa-edit"></i> Edit Catalog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('catalogues.update', $catalogue->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-building"></i> Company</label>
                                <input type="text" name="entreprise" class="form-control" value="{{ $catalogue->entreprise }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-car"></i> Car Type</label>
                                <input type="text" name="type_voiture" class="form-control" value="{{ $catalogue->type_voiture }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-cogs"></i> Part Name</label>
                                <input type="text" name="nom_piece" class="form-control" value="{{ $catalogue->nom_piece }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-hashtag"></i> Part Number</label>
                                <input type="number" name="num_piece" class="form-control" value="{{ $catalogue->num_piece }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-globe"></i> Country of Manufacture</label>
                                <input type="text" name="paye_fabrication" class="form-control" value="{{ $catalogue->paye_fabrication }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-image"></i> Part Photo</label>
                                <input type="file" name="photo_piece" class="form-control">
                                @if ($catalogue->photo_piece)
                                    <img src="{{ asset('storage/' . $catalogue->photo_piece) }}" alt="Current Photo" width="50" class="mt-2">
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        </script>
    <script>
        // Fonction de recherche
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#catalogueTable tr");

            rows.forEach(row => {
                let text = row.querySelectorAll(".searchable");
                let match = Array.from(text).some(td => td.textContent.toLowerCase().includes(filter));
                row.style.display = match ? "" : "none";
            });
        });

        // Fonction de pagination
        let currentPage = 0;
        const rowsPerPage = 5;
        const rows = document.querySelectorAll("#catalogueTable tr");

        function showPage(page) {
            rows.forEach((row, index) => {
                row.style.display = (index >= page * rowsPerPage && index < (page + 1) * rowsPerPage) ? "" : "none";
            });
            document.getElementById("prevBtn").disabled = page === 0;
            document.getElementById("nextBtn").disabled = (page + 1) * rowsPerPage >= rows.length;
        }

        document.getElementById("prevBtn").addEventListener("click", () => {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.getElementById("nextBtn").addEventListener("click", () => {
            if ((currentPage + 1) * rowsPerPage < rows.length) {
                currentPage++;
                showPage(currentPage);
            }
        });

        showPage(currentPage);
    </script>
</body>
</html>
