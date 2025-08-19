<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3730a3;
            --success-color: #059669;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --secondary-color: #6b7280;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fefefe 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-header {
            background: linear-gradient(135deg,white 0%, white 100%);
            color: black;
            border-radius: 20px 20px 0 0;
            border: 2px solid #f4f6f6;
            padding: 0.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="4"/></g></svg>') repeat;
            opacity: 0.3;
        }

        .page-header h2 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 700;
            font-size: 2.5rem;
        }



        .form-select, .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 0.5rem 0rem;
            font-weight: 500;
            transition: all 0.3s ease;

        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #667eea 100%);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--primary-hover) 0%, #5a67d8 100%);
        }

        .table-container {
            margin: 1.5rem;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table {
            margin: 0;
            border: none;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%,var(--primary-color) 100%);
            color: white;
            border: none;
            padding: 0.75rem 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            position: relative;
        }

        .table thead th:first-child {
            border-top-left-radius: 15px;
        }

        .table thead th:last-child {
            border-top-right-radius: 15px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-weight: 500;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(5, 150, 105, 0.1);
            color: var(--success-color);
        }

        .status-inactive {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-sm {
            padding: 0.5rem;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .btn-warning {
            background: var(--warning-color);
            color: white;
        }

        .btn-warning:hover {
            background: #b45309;
            transform: scale(1.1);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
            transform: scale(1.1);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: #047857;
            transform: scale(1.1);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: scale(1.1);
        }

        .pagination-controls {
            background: white;
            padding: 1rem;
            margin: 0.75rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: var(--card-shadow);
        }

        .pagination-controls button {
            background: grey;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .pagination-controls button:hover {
            transform: scale(1.1);
            background: var(--primary-hover);
        }

        .pagination-controls span {
            margin: 0 0.5rem;
            font-weight: 600;
            color: grey;
            font-size: 1rem;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-hover-shadow);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #667eea 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            border: none;
            padding: 1.5rem 2rem;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border: none;
            padding: 1rem 2rem 2rem;
        }

        .tooltip-inner {
            background-color: var(--primary-color);
            font-size: 0.85rem;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .bs-tooltip-top .tooltip-arrow::before {
            border-top-color: var(--primary-color);
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: var(--secondary-color);
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .search-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .action-buttons {
                flex-wrap: wrap;
            }

            .table-container {
                overflow-x: auto;
            }
        }

         .search-controls {
        width: 100%;
    }

    .search-controls .form-control {
        min-width: 200px;
    }

    @media (max-width: 768px) {
        .search-controls {
            flex-direction: column;
            gap: 10px !important;
        }

        .search-controls > * {
            width: 100% !important;
        }
    }
    </style>
</head>
<body class="d-flex">
    <!-- Sidebar -->
    @include('Sidebar.sidebar')

    <div class="container-fluid py-4" style="margin-top: 70px">
        <div class="main-container">
            <!-- Header -->
           <div class="page-header">
    <h3><i class="fas fa-users me-3"></i>Technician Management</h3>
</div>

<br/>
            <!-- Search Section -->
            <div class="search-section" style="margin-left: 20px">
    <div class="search-controls d-flex align-items-center gap-3">
        <select id="searchCriteria" class="form-select flex-grow-0" style="width: 150px;">
            <option value="nom">Last Name</option>
            <option value="prenom">First Name</option>
            <option value="email">Email</option>
        </select>
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un technicien...">
        <button class="btn btn-primary flex-shrink-0" data-bs-toggle="modal" data-bs-target="#addTechnicienModal" style="margin-right: 20px">
            <i class="fas fa-plus me-2"></i>New Technician
        </button>
    </div>
</div>


            @if (isset($users) && $users->count() > 0)
            <!-- Table Container -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                              <th><i class="fas fa-user me-2"></i>First Name</th>
                    <th><i class="fas fa-user-tag me-2"></i>Last Name</th>
                    <th><i class="fas fa-envelope me-2"></i>Email</th>
                    <th><i class="fas fa-phone me-2"></i>Phone</th>
                    <th><i class="fas fa-map-marker-alt me-2"></i>Address</th>
                    <th><i class="fas fa-toggle-on me-2"></i>Status</th>
                    <th><i class="fas fa-cogs me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTable">
                        @foreach ($users as $user)
                            <tr>
                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->prenom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->adresse }}</td>
                        <td>
                            <span class="status-badge {{ $user->isActive == 0 ? 'status-inactive' : 'status-active' }}">
                                {{ $user->isActive == 0 ? 'Inactive' : 'Active' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm edit-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-id="{{ $user->id }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}"
                                        data-adresse="{{ $user->adresse }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Edit technician">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Confirm deletion?')"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Delete technician">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                                <!-- Activate/Deactivate Button -->
                                @if ($user->isActive == 0)
                                    <button class="btn btn-success btn-sm accept-btn"
                                            data-id="{{ $user->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Activate technician">
                                        <i class="fas fa-toggle-off"></i>
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm refuse-btn"
                                            data-id="{{ $user->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Deactivate technician">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-controls">
                <button id="prevPage">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span id="pageNumber">1</span>
                <button id="nextPage">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            @else
                <div class="no-data">
                    <i class="fas fa-users-slash"></i>
                    <h3>Aucun technicien trouvé</h3>
                    <p>Commencez par ajouter votre premier technicien</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Modification -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">
                        <i class="fas fa-user-edit me-2"></i>Update Technician
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="userId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>New email
                                </label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Entrer le nouvel email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>New phone
                                </label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Entrer le nouveau téléphone" required>
                            </div>
                            <div class="col-12">
                                <label for="adresse" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>New address
                                </label>
                                <input type="text" id="adresse" name="adresse" class="form-control" placeholder="Entrer la nouvelle adresse" required>
                            </div>
                        </div>
                    </form>
                    <div id="updateMessage" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" form="editUserForm" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajout Technicien -->
    <div class="modal fade" id="addTechnicienModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>New Technician
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('techniciens.storeTech') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" name="adresse" class="form-control" required>
                            </div>
                          <div class="col-md-6">
    <label class="form-label">Specialty <span class="text-danger">*</span></label>
    <select name="specialite" class="form-select" required>
        <option value="" selected disabled>Select a specialty</option>
        @foreach($specialisations as $specialite)
            <option value="{{ $specialite->nom_specialite }}">{{ $specialite->nom_specialite }}</option>
        @endforeach
    </select>
</div>

                            <div class="col-md-6">
                                <label class="form-label">years of experience</label>
                                <input type="number" name="annee_experience" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Animation d'entrée pour les lignes du tableau
            const rows = document.querySelectorAll('#employeeTable tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        //modifier les information d'un techniciens
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let userId = this.getAttribute('data-id');
                    let userEmail = this.getAttribute('data-email');
                    let userPhone = this.getAttribute('data-phone');
                    let userAdresse = this.getAttribute('data-adresse');
                    document.getElementById('userId').value = userId;
                    document.getElementById('email').value = userEmail;
                    document.getElementById('phone').value = userPhone;
                    document.getElementById('adresse').value = userAdresse;
                });
            });

            // Gérer la soumission du formulaire avec fetch
            document.getElementById('editUserForm').addEventListener('submit', function (event) {
                event.preventDefault();
                let userId = document.getElementById('userId').value;
                let email = document.getElementById('email').value;
                let phone = document.getElementById('phone').value;
                let adresse = document.getElementById('adresse').value;
                let updateMessage = document.getElementById('updateMessage');
                fetch(`/users/${userId}/update-email-phone`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email, phone, adresse })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        updateMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        updateMessage.innerHTML = `<div class="alert alert-danger">Erreur lors de la mise à jour.</div>`;
                    }
                })
                .catch(error => {
                    updateMessage.innerHTML = `<div class="alert alert-danger">Une erreur s'est produite.</div>`;
                });
            });
        });

        //désactivé employee
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.refuse-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let userId = this.getAttribute('data-id');
                    fetch(`/users/${userId}/desactivate`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            alert("Erreur lors de l'activation.");
                        }
                    })
                    .catch(error => {
                        alert("Une erreur s'est produite.");
                    });
                });
            });
        });

        // activer un compte
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.accept-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let userId = this.getAttribute('data-id');
                    fetch(`/users/${userId}/activate`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            alert("Erreur lors de l'activation.");
                        }
                    })
                    .catch(error => {
                        alert("Une erreur s'est produite.");
                    });
                });
            });
        });

        //chercher par nom , prenom et email
        document.getElementById('searchInput').addEventListener('input', function() {
            let searchValue = this.value.toLowerCase();
            let criteria = document.getElementById('searchCriteria').value;
            let rows = document.querySelectorAll('#employeeTable tr');
            rows.forEach(row => {
                let cell = row.querySelector(`td:nth-child(${criteria === 'nom' ? 1 : criteria === 'prenom' ? 2 : 3})`);
                let text = cell.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        //limiter nombre des techniciens affiches
        document.addEventListener("DOMContentLoaded", function () {
            let rows = document.querySelectorAll('#employeeTable tr');
            let currentPage = 1;
            let rowsPerPage = 6;
            function showPage(page) {
                let start = (page - 1) * rowsPerPage;
                let end = start + rowsPerPage;
                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? '' : 'none';
                });
                document.getElementById("pageNumber").textContent = page;
            }
            document.getElementById("prevPage").addEventListener("click", function () {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });
            document.getElementById("nextPage").addEventListener("click", function () {
                if (currentPage < Math.ceil(rows.length / rowsPerPage)) {
                    currentPage++;
                    showPage(currentPage);
                }
            });
            showPage(currentPage);
        });
    </script>
</body>
</html>
