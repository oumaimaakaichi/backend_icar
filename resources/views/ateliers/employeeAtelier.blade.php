<!DOCTYPE html>
<html>
<head>
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .modal-header {
            padding: 1rem 2rem;
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }
        .form-control, .form-select {
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #00d2ff;
            box-shadow: 0 0 0 0.25rem rgba(58, 123, 213, 0.25);
        }
        .btn-primary {
            background-color: #3a7bd5;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2a6bc4;
        }
        .bg-gradient-warning {
            background: linear-gradient(135deg, #ff9a00 0%, #ffd700 100%);
        }
        .table thead th {
            background-color: #9ca4b0;
            color: white;
            vertical-align: middle;
        }
        .btn-warning {
            background-color: #ff9a00;
            border: none;
            color: white;
        }
        .btn-warning:hover {
            background-color: #e68a00;
        }
        .pagination .page-item .page-link {
            color: #3a7bd5;
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 5px;
        }
        .pagination .page-item.active .page-link {
            background-color: #3a7bd5;
            border-color: #3a7bd5;
            color: white;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }
        .pagination .page-link:hover:not(.active) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">
    @include('Sidebar.sidebarAtelier')
    <div class="container py-5" style="margin-top: 50px">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i>My Workshop Clients</h2>
                <div class="d-flex">
                    <div class="me-3">
                        <select class="form-select form-select-sm" id="perPage" onchange="changePerPage(this)">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="bi bi-plus-circle me-2"></i>Add an Employee
                    </button>
                </div>
            </div>

            @if($employees->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead  >
                            <tr>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->nom }}</td>
                                <td>{{ $employee->prenom }}</td>
                                <td>{{ $employee->extra_data['nom_entreprise'] ?? 'N/A' }}</td>
                                <td>{{ $employee->phone}}</td>
                                <td class="{{ $employee->isActive ? 'text-success' : 'text-primary' }}">
                                    {{ $employee->isActive ? 'Active' : 'Inactive' }}
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-id="{{ $employee->id }}"
                                        data-email="{{ $employee->email }}"
                                        data-phone="{{ $employee->phone }}"
                                        data-adresse="{{ $employee->adresse }}"
                                        title="edit User"
                                        >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if ($employee->isActive == 0)
                                    <button class="btn btn-success btn-sm accept-btn me-1"
                                            data-id="{{ $employee->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Activate User">
                                        <i class="fas fa-toggle-off"></i>
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm refuse-btn"
                                            data-id="{{ $employee->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Deactivate User">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            @if ($employees->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $employees->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                                @if ($page == $employees->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($employees->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $employees->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @else
                <div class="alert alert-info">
                    No employees found for your workshop.
                </div>
            @endif
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-plus fa-xl me-3"></i>
                        <h5 class="modal-title fs-4 fw-bold">Add New Employee</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="{{ route('atelier.employes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="atelier_id" value="{{ auth()->id() }}">

                        <div class="mb-4">
                            <h6 class="mb-3 border-bottom pb-2">
                                <i class="fas fa-id-card me-2"></i>Personal Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control border-2 rounded-3" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" class="form-control border-2 rounded-3" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class=" mb-3 border-bottom pb-2">
                                <i class="fas fa-address-book me-2"></i>Contact Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0 border-2 rounded-end-3" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="phone" class="form-control border-start-0 border-2 rounded-end-3" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" name="adresse" class="form-control border-start-0 border-2 rounded-end-3" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editUserModalLabel">
                        <i class="fas fa-user-edit"></i> Edit Employee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="userId">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> New Email
                                </label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter new email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> New Phone
                                </label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter new phone number" required>
                            </div>
                            <div class="col-12">
                                <label for="adresse" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> New Address
                                </label>
                                <input type="text" id="adresse" name="adresse" class="form-control" placeholder="Enter new address" required>
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
                    <div id="updateMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Function to change items per page
        function changePerPage(select) {
            const perPage = select.value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }
    </script>

    <script>
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
                event.preventDefault(); // Empêcher la soumission classique du formulaire

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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function getCSRFToken() {
                return document.querySelector('meta[name="csrf-token"]')?.content || '';
            }

            document.querySelectorAll('.accept-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    try {
                        const userId = this.dataset.id;
                        const response = await fetch(`/users/${userId}/activate`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': getCSRFToken(),
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Activation failed');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    }
                });
            });

            document.querySelectorAll('.refuse-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    try {
                        const userId = this.dataset.id;
                        const response = await fetch(`/users/${userId}/desactivate`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': getCSRFToken(),
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Deactivation failed');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    }
                });
            });
        });
    </script>
</body>
</html>
