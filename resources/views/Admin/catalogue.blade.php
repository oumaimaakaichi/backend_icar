<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts Catalog | AutoMaintenance</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color:  #567288;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--secondary-color) 100%);
            color: white;
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .main-content {

            margin-left: 250px;
            transition: all 0.3s;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            width: 1300px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
width:100%
        }

        .table thead th {
            background-color: #567288;
            color: white;
            border: none;
            font-weight: 500;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .btn-primary {
            background-color: #567288;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
        }

        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
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
            border: 1px solid #e0e0e0;
            box-shadow: none;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .modal-content {
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
            background-color: #f8f9fa;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 6px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 3px;
            transition: all 0.2s;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .part-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .part-photo-lg {
            width: 100px;
            height: 100px;
        }

        .page-title {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
         
            border-radius: 2px;
        }





        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->

        @include('Sidebar.sidebar')



        <div class="container py-5" style="margin-top: 50px">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: 40px">
                    <h3 class="page-title" >Parts Catalog Management</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCatalogueModal" style="background-color:  #567288">
                        <i class="fas fa-plus me-2"></i>Add Part
                    </button>
                </div>

                <!-- Search and Filter Row -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by company, part name or car type...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex">
                            <select class="form-select me-2">
                                <option selected>Filter by Company</option>
                                <option>All Companies</option>
                                <option>Toyota</option>
                                <option>Honda</option>
                                <option>BMW</option>
                            </select>
                            <select class="form-select">
                                <option selected>Filter by Car Type</option>
                                <option>All Types</option>
                                <option>Sedan</option>
                                <option>SUV</option>
                                <option>Truck</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Catalog Table -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Car Type</th>
                                        <th>Part Name</th>
                                        <th>Part #</th>
                                        <th>Origin</th>
                                        <th>Photo</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="catalogueTable">
                                    @foreach ($catalogues as $catalogue)
                                        <tr>
                                            <td class="searchable">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded me-2 p-1">
                                                        <i class="fas fa-building text-primary fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $catalogue->entreprise }}</h6>
                                                        <small class="text-muted">Last update: {{ date('m/d/Y', strtotime($catalogue->updated_at)) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="searchable">
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-car me-1 text-primary"></i>
                                                    {{ $catalogue->type_voiture }}
                                                </span>
                                            </td>
                                            <td class="searchable">{{ $catalogue->nom_piece }}</td>
                                            <td><code>{{ $catalogue->num_piece }}</code></td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-globe me-1 text-primary"></i>
                                                    {{ $catalogue->paye_fabrication }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($catalogue->photo_piece)
                                                    <img src="{{ asset('storage/' . $catalogue->photo_piece) }}" alt="Part Photo" class="part-photo">
                                                @else
                                                    <div class="avatar-sm bg-light rounded p-1">
                                                        <i class="fas fa-image text-muted fs-4"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <button type="button" class="action-btn btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCatalogueModal{{ $catalogue->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('catalogues.destroy', $catalogue->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this catalog item?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing <span id="startItem">1</span> to <span id="endItem">{{ min(10, count($catalogues)) }}</span> of <span id="totalItems">{{ count($catalogues) }}</span> entries
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item disabled" id="prevBtn">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item" id="nextBtn">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Catalog Modal -->
    <div class="modal fade" id="addCatalogueModal" tabindex="-1" aria-labelledby="addCatalogueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCatalogueModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Add New Part to Catalog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('catalogues.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-building me-2 text-primary"></i>Company</label>
                                <input type="text" name="entreprise" class="form-control" placeholder="Enter company name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-car me-2 text-primary"></i>Car Type</label>
                                <select name="type_voiture" class="form-select" required>
                                    <option value="" selected disabled>Select car type</option>
                                    <option value="Sedan">Sedan</option>
                                    <option value="SUV">SUV</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Hatchback">Hatchback</option>
                                    <option value="Coupe">Coupe</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-cogs me-2 text-primary"></i>Part Name</label>
                                <input type="text" name="nom_piece" class="form-control" placeholder="Enter part name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-hashtag me-2 text-primary"></i>Part Number</label>
                                <input type="text" name="num_piece" class="form-control" placeholder="Enter part number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-globe me-2 text-primary"></i>Country of Manufacture</label>
                                <select name="paye_fabrication" class="form-select" required>
                                    <option value="" selected disabled>Select country</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Japan">Japan</option>
                                    <option value="USA">USA</option>
                                    <option value="China">China</option>
                                    <option value="South Korea">South Korea</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-image me-2 text-primary"></i>Part Photo</label>
                                <input type="file" name="photo_piece" class="form-control" accept="image/*">
                                <small class="text-muted">Max file size: 2MB (JPEG, PNG)</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Add Part
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Catalog Modals -->
    @foreach ($catalogues as $catalogue)
    <div class="modal fade" id="editCatalogueModal{{ $catalogue->id }}" tabindex="-1" aria-labelledby="editCatalogueModalLabel{{ $catalogue->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCatalogueModalLabel{{ $catalogue->id }}">
                        <i class="fas fa-edit me-2"></i>Edit Part: {{ $catalogue->nom_piece }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('catalogues.update', $catalogue->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-building me-2 text-primary"></i>Company</label>
                                <input type="text" name="entreprise" class="form-control" value="{{ $catalogue->entreprise }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-car me-2 text-primary"></i>Car Type</label>
                                <select name="type_voiture" class="form-select" required>
                                    <option value="Sedan" {{ $catalogue->type_voiture == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="SUV" {{ $catalogue->type_voiture == 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="Truck" {{ $catalogue->type_voiture == 'Truck' ? 'selected' : '' }}>Truck</option>
                                    <option value="Hatchback" {{ $catalogue->type_voiture == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="Coupe" {{ $catalogue->type_voiture == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-cogs me-2 text-primary"></i>Part Name</label>
                                <input type="text" name="nom_piece" class="form-control" value="{{ $catalogue->nom_piece }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-hashtag me-2 text-primary"></i>Part Number</label>
                                <input type="text" name="num_piece" class="form-control" value="{{ $catalogue->num_piece }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-globe me-2 text-primary"></i>Country of Manufacture</label>
                                <select name="paye_fabrication" class="form-select" required>
                                    <option value="Germany" {{ $catalogue->paye_fabrication == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="Japan" {{ $catalogue->paye_fabrication == 'Japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="USA" {{ $catalogue->paye_fabrication == 'USA' ? 'selected' : '' }}>USA</option>
                                    <option value="China" {{ $catalogue->paye_fabrication == 'China' ? 'selected' : '' }}>China</option>
                                    <option value="South Korea" {{ $catalogue->paye_fabrication == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><i class="fas fa-image me-2 text-primary"></i>Part Photo</label>
                                <input type="file" name="photo_piece" class="form-control" accept="image/*">
                                @if ($catalogue->photo_piece)
                                    <div class="mt-2 d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $catalogue->photo_piece) }}" alt="Current Photo" class="part-photo-lg me-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_photo" id="removePhoto{{ $catalogue->id }}">
                                            <label class="form-check-label small" for="removePhoto{{ $catalogue->id }}">
                                                Remove current photo
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Part
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Update pagination info
            updatePaginationInfo();
        });

        // Search functionality
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#catalogueTable tr");

            rows.forEach(row => {
                let text = row.querySelectorAll(".searchable");
                let match = Array.from(text).some(td => td.textContent.toLowerCase().includes(filter));
                row.style.display = match ? "" : "none";
            });

            updatePaginationInfo();
        });

        // Pagination variables
        let currentPage = 1;
        const rowsPerPage = 10;
        const rows = document.querySelectorAll("#catalogueTable tr");
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        // Show page function
        function showPage(page) {
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            rows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex && row.style.display !== "none") {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });

            // Update pagination controls
            document.getElementById("prevBtn").classList.toggle("disabled", page === 1);
            document.getElementById("nextBtn").classList.toggle("disabled", page === totalPages);

            // Update pagination info
            updatePaginationInfo();
        }

        // Previous page button
        document.querySelector("#prevBtn a").addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        // Next page button
        document.querySelector("#nextBtn a").addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Update pagination information
        function updatePaginationInfo() {
            const visibleRows = Array.from(rows).filter(row => row.style.display !== "none");
            const startItem = (currentPage - 1) * rowsPerPage + 1;
            const endItem = Math.min(currentPage * rowsPerPage, visibleRows.length);

            document.getElementById("startItem").textContent = startItem;
            document.getElementById("endItem").textContent = endItem;
            document.getElementById("totalItems").textContent = visibleRows.length;
        }

        // Initialize the first page
        showPage(currentPage);
    </script>
</body>
</html>
