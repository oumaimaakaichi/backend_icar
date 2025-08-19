
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4361ee 0%, #4361ee 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);

            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-soft: 0 8px 32px rgba(31, 38, 135, 0.37);
            --shadow-hover: 0 15px 35px rgba(31, 38, 135, 0.5);

            --text-primary: #2d3748;
            --text-secondary: #718096;
            --bg-light: #f7fafc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* Animated background particles */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 40px; height: 40px; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 100px; height: 100px; left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 50px; height: 50px; left: 60%; animation-delay: 4s; }
        .particle:nth-child(6) { width: 70px; height: 70px; left: 80%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(-60px) rotate(240deg); }
        }

        /* Glass morphism container */
        .glass-container {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-soft);
            padding: 2rem;

            transition: all 0.3s ease;
        }

        .glass-container:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }

        /* Header styling */
        .page-header {
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem;

            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #000000, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;

        }

        .page-subtitle {
            color: rgba(78, 76, 76, 0.8);
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Control section */
        .controls-section {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;

            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Modern buttons */
        .btn-modern {
            position: relative;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-primary-modern {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-success-modern {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-warning-modern {
            background: var(--warning-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(67, 233, 123, 0.4);
        }

        .btn-danger-modern {
            background: var(--danger-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(250, 112, 154, 0.4);
        }

        .btn-secondary-modern {
            background: var(--dark-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(44, 62, 80, 0.4);
        }

        /* Modern table */
        .table-modern {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .table-modern thead th {
            background: var(--primary-gradient);
            color: rgb(252, 250, 250);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
            border: none;
        }

        .table-modern tbody td {
            padding: 1.25rem 1rem;
            border: none;
            vertical-align: middle;
            background: rgba(255,255,255,0.8);
            transition: all 0.3s ease;
        }

        .table-modern tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .table-modern tbody tr:hover td {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.02);
        }

        /* Status badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .status-inactive {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
        }

        /* Action buttons */
        .action-btn {
            width: 45px;
            height: 45px;
            border-radius: 50px;
            border: none;
            margin: 0 0.25rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .action-btn:hover {
            transform: translateY(-3px) scale(1.1);
        }

        /* Modern modals */
        .modal-modern .modal-content {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .modal-modern .modal-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 2rem;
        }

        .modal-modern .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-modern .modal-body {
            padding: 2rem;
        }

        /* Modern form inputs */
        .form-modern {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-modern .form-control {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-modern .form-control:focus {
            background: rgba(255,255,255,0.95);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }

        .form-modern .form-label {
            font-weight: 600;
            color: var(--text-primary);

            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modern pagination */
        .pagination-modern {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 0.5rem;
            display: inline-flex;
        }

        .pagination-modern .page-link {
            background: transparent;
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .pagination-modern .page-item.active .page-link {
            background: var(--primary-gradient);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transform: scale(1.1);
        }

        .pagination-modern .page-link:hover:not(.active) {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .glass-container {
                margin: 1rem;
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .controls-section {
                padding: 1rem;
            }

            .table-responsive {
                border-radius: 15px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>
      @include('Sidebar.sidebarAtelier')
    <!-- Background particles -->


    <div class="container-fluid py-4" style="margin-top: 50px">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
           <h1 class="page-title">
    <i class="bi bi-people-fill me-3"></i>
    Client Management
</h1>
<p class="page-subtitle">Manage your clients efficiently</p>

        </div>

        <!-- Main Content -->
        <div class="glass-container animate-fade-in animate-delay-1">
            <!-- Controls Section -->


            <!-- Employees Table -->
            <div class="table-responsive animate-fade-in animate-delay-2">
                <div class="table-modern">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="bi bi-person me-2"></i>First Name</th>
<th><i class="bi bi-person-badge me-2"></i>Last Name</th>
<th><i class="bi bi-envelope me-2"></i>Email</th>
<th><i class="bi bi-telephone me-2"></i>Phone</th>
<th><i class="bi bi-check-circle me-2"></i>Status</th>
<th><i class="bi bi-gear me-2"></i>Actions</th>

                            </tr>
                        </thead>
                        <tbody id="employeesTableBody">
                            @if($employees->count())
                                @foreach($employees as $employee)
                                <tr>
                                    <td><strong>{{ $employee->nom }}</strong></td>
                                    <td>{{ $employee->prenom }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>
                                        <span class="status-badge {{ $employee->isActive ? 'status-active' : 'status-inactive' }}">
                                            {{ $employee->isActive ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="action-btn btn-warning-modern edit-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal"
                                            data-id="{{ $employee->id }}"
                                            data-email="{{ $employee->email }}"
                                            data-phone="{{ $employee->phone }}"
                                            data-adresse="{{ $employee->adresse }}"
                                            title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        @if ($employee->isActive == 0)
                                            <button class="action-btn btn-success-modern accept-btn"
                                                data-id="{{ $employee->id }}"
                                                title="Activate">
                                                <i class="bi bi-toggle-off"></i>
                                            </button>
                                        @else
                                            <button class="action-btn btn-secondary-modern refuse-btn"
                                                data-id="{{ $employee->id }}"
                                                title="Desactivate">
                                                <i class="bi bi-toggle-on"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="alert alert-info border-0" style="background: rgba(79, 172, 254, 0.1);">
                                            <i class="bi bi-info-circle me-2"></i>Aucun employé trouvé pour votre atelier.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($employees->count())
            <div class="d-flex justify-content-between align-items-center mt-4 animate-fade-in animate-delay-3">
                <div class="text-muted">
                    <strong>Affichage {{ $employees->firstItem() }} à {{ $employees->lastItem() }} sur {{ $employees->total() }} entrées</strong>
                </div>
                <nav>
                    <ul class="pagination pagination-modern mb-0">
                        @if ($employees->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $employees->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                            @if ($page == $employees->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

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
            @endif
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade modal-modern" id="addEmployeeModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-plus-fill me-3" style="font-size: 1.5rem;"></i>
                        <h5 class="modal-title">Ajouter un Nouvel Employé</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('atelier.employes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="atelier_id" value="{{ auth()->id() }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-modern">
                                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-modern">
                                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-modern">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-modern">
                                    <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-modern">
                            <label class="form-label">Adresse <span class="text-danger">*</span></label>
                            <input type="text" name="adresse" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-modern btn-primary-modern">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade modal-modern" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-gear me-3" style="font-size: 1.5rem;"></i>
                        <h5 class="modal-title">Modifier l'Employé</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="userId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-modern">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-modern">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" name="phone" class="form-control" id="phone">
                                </div>
                            </div>
                        </div>
                        <div class="form-modern">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control" id="adresse">
                        </div>
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="button" class="btn btn-modern btn-secondary-modern" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-modern btn-primary-modern">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour
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
