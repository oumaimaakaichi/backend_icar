<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Technicians Management - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #567288;
            --primary-light: #567288;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --secondary: #6b7280;
            --dark: #1f2937;
            --light: #f8fafc;
            --white: #ffffff;
            --border: #e5e7eb;
            --radius: 8px;
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Header */
        .header {
            background: var(--white);
            border-radius: var(--radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
        }

        .header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .header p {
            color: var(--secondary);
            margin: 0.5rem 0 0 0;
            font-size: 0.9rem;
        }

        /* Success Message */
        .success-message {
            background: linear-gradient(135deg, var(--success), #059669);
            color: var(--white);
            border-radius: var(--radius);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            display: none;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
            border-left: 4px solid #047857;
        }

        .success-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.1) 75%);
            background-size: 20px 20px;
            animation: moveStripes 2s linear infinite;
            opacity: 0.3;
        }

        @keyframes moveStripes {
            0% { transform: translateX(-20px); }
            100% { transform: translateX(0); }
        }

        .success-message i {
            font-size: 1.2rem;
            background: rgba(255,255,255,0.2);
            padding: 0.5rem;
            border-radius: 50%;
            animation: bounceIn 0.6s ease-out;
        }

        .success-message .message-text {
            font-weight: 500;
            font-size: 0.95rem;
            flex: 1;
        }

        .success-message .close-btn {
            background: white;
            border: none;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-message .close-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOutUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .success-message.show {
            display: flex;
            animation: slideInDown 0.5s ease-out;
        }

        .success-message.hide {
            animation: slideOutUp 0.3s ease-in forwards;
        }

        /* Controls */
        .controls {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-group {
            display: flex;
            gap: 0.5rem;
            flex: 1;
            min-width: 300px;
        }

        .form-select, .form-control {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: var(--white);
        }

        .form-select:focus, .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
        }

        .btn {
            border-radius: var(--radius);
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #567288;
            color: var(--white);
        }

        .btn-primary:hover {
            background:#567288;
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
        }

        .btn-success {
            background: var(--success);
            color: var(--white);
        }

        .btn-warning {
            background: var(--warning);
            color: var(--white);
        }

        .btn-danger {
            background: var(--danger);
            color: var(--white);
        }

        .btn-secondary {
            background: var(--secondary);
            color: var(--white);
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        /* Table */
        .table-container {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table {
            margin: 0;
            width: 100%;
        }

         .table thead th {
            background: linear-gradient(135deg, #567288 0%,#567288 100%);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            position: relative;
        }

        .table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 0.875rem;
        }

        .table tbody tr:hover {
            background-color: rgb(37 99 235 / 0.03);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Avatar/Logo */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            color: white;
            background-color: #567288;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-active {
            background: rgb(16 185 129 / 0.1);
            color: var(--success);
        }

        .status-inactive {
            background: rgb(107 114 128 / 0.1);
            color: var(--secondary);
        }

        /* Actions */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            transition: all 0.2s;
        }

        /* Pagination */
        .pagination-container {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1rem;
            margin-top: 2rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .pagination-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .pagination-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .page-info {
            color: var(--secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: var(--light);
            border-bottom: 1px solid var(--border);
            border-radius: var(--radius) var(--radius) 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 1rem 1.5rem;
            background: var(--light);
            border-radius: 0 0 var(--radius) var(--radius);
        }

        /* Form */
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-size: 0.875rem;
        }

        .required {
            color: var(--danger);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--secondary);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }

        /* Focus styles for accessibility */
        .btn:focus,
        .form-control:focus,
        .form-select:focus,
        .action-btn:focus,
        .pagination-btn:focus,
        .close-btn:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Skip link for keyboard navigation */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--primary);
            color: white;
            padding: 8px;
            border-radius: var(--radius);
            z-index: 10000;
            text-decoration: none;
        }

        .skip-link:focus {
            top: 6px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .btn {
                border: 2px solid;
            }

            .table tbody tr {
                border-bottom: 2px solid var(--border);
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }

            .success-message {
                animation: none;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-group {
                min-width: auto;
            }

            .table-container {
                overflow-x: auto;
            }

            .action-buttons {
                flex-wrap: wrap;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table tbody tr {
            animation: fadeInUp 0.3s ease-out;
        }
    </style>
</head>
<body>
    <!-- Skip link for keyboard users -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Sidebar placeholder -->
    @include('Sidebar.sidebar')

    <div class="container" style="margin-top: 90px ;margin-right:80px" id="main-content" tabindex="-1">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-users me-2" aria-hidden="true"></i>Technicians Management</h1>
            <p>Manage and supervise all technicians in your organization</p>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="success-message" role="alert" aria-live="polite">
            <i class="fas fa-check-circle" aria-hidden="true"></i>
            <span class="message-text" id="messageText"></span>
            <button class="close-btn" onclick="hideSuccessMessage()" aria-label="Close notification">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Controls -->
        <div class="controls">
            <div class="search-group">
                <label for="searchCriteria" class="visually-hidden">Search criteria</label>
                <select id="searchCriteria" class="form-select" style="width: 140px;">
                    <option value="nom">Last Name</option>
                    <option value="prenom">First Name</option>
                    <option value="email">Email</option>
                </select>
                <label for="searchInput" class="visually-hidden">Search technicians</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Search a technician..." aria-label="Search technicians">
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTechnicienModal" style="background-color: #567288">
                <i class="fas fa-plus" aria-hidden="true"></i>New Technician
            </button>
        </div>

        @if (isset($users) && $users->count() > 0)
        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <caption class="visually-hidden">List of technicians with their details and actions</caption>
                <thead>
                    <tr>
                        <th scope="col">Logo</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTable">
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="avatar" aria-label="Initials of {{ $user->nom }} {{ $user->prenom }}">
                                {{ strtoupper(substr($user->nom, 0, 1) . substr($user->prenom, 0, 1)) }}
                            </div>
                        </td>
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
                                <button class="action-btn btn-warning edit-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-id="{{ $user->id }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}"
                                        data-adresse="{{ $user->adresse }}"
                                        aria-label="Edit technician {{ $user->nom }} {{ $user->prenom }}">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </button>

                               <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-user-form">
    @csrf
    @method('DELETE')
    <button type="button"
            class="action-btn btn-danger delete-user-btn"
            data-user-name="{{ $user->nom }} {{ $user->prenom }}">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>


                                @if ($user->isActive == 0)
                                    <button class="action-btn btn-success accept-btn"
                                            data-id="{{ $user->id }}"
                                            aria-label="Activate technician {{ $user->nom }} {{ $user->prenom }}">
                                        <i class="fas fa-check" aria-hidden="true"></i>
                                    </button>
                                @else
                                    <button class="action-btn btn-secondary refuse-btn"
                                            data-id="{{ $user->id }}"
                                            aria-label="Deactivate technician {{ $user->nom }} {{ $user->prenom }}">
                                        <i class="fas fa-times" aria-hidden="true"></i>
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
        <div class="pagination-container">
            <button id="prevPage" class="pagination-btn" aria-label="Previous page">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </button>
            <span class="page-info">Page <span id="pageNumber">1</span></span>
            <button id="nextPage" class="pagination-btn" aria-label="Next page">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
        @else
        <div class="table-container">
            <div class="empty-state">
                <i class="fas fa-users-slash" aria-hidden="true"></i>
                <h3>No technicians found</h3>
                <p>Start by adding your first technician</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="editUserModalLabel">
                        <i class="fas fa-user-edit me-2" aria-hidden="true"></i>Edit Technician
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required aria-required="true">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="required">*</span></label>
                            <input type="text" id="phone" name="phone" class="form-control" required aria-required="true">
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Address <span class="required">*</span></label>
                            <input type="text" id="adresse" name="adresse" class="form-control" required aria-required="true">
                        </div>
                    </form>
                    <div id="updateMessage" role="alert" aria-live="polite"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUserForm" class="btn btn-primary">
                        <i class="fas fa-save me-2" aria-hidden="true"></i>Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addTechnicienModal" tabindex="-1" aria-labelledby="addTechnicienModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #35677d">
                    <h2 class="modal-title" id="addTechnicienModalLabel" style="color: white">
                        <i class="fas fa-user-plus me-2" aria-hidden="true"></i>New Technician
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white"></button>
                </div>
                <form action="{{ route('techniciens.storeTech') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="required">*</span></label>
                                <input type="text" name="nom" class="form-control" required aria-required="true">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="required">*</span></label>
                                <input type="text" name="prenom" class="form-control" required aria-required="true">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control" required aria-required="true">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="required">*</span></label>
                                <input type="text" name="phone" class="form-control" required aria-required="true">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address <span class="required">*</span></label>
                                <input type="text" name="adresse" class="form-control" required aria-required="true">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Specialty <span class="required">*</span></label>
                                <select name="specialite" class="form-select" required aria-required="true">
                                    <option value="" disabled selected>Select a specialty</option>
                                    @foreach($specialisations as $specialite)
                                        <option value="{{ $specialite->nom_specialite }}">{{ $specialite->nom_specialite }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Years of experience</label>
                                <input type="number" name="annee_experience" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2" aria-hidden="true"></i>Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-user-form');
            const userName = this.getAttribute('data-user-name');

            Swal.fire({
                title: 'Confirm Deletion',
                html: `Delete <strong>${userName}</strong>? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-4',
                    cancelButton: 'btn btn-secondary px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Afficher le loader
                    Swal.fire({
                        title: 'Deleting...',
                        html: 'Please wait while we remove the user',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Soumettre la requête AJAX
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: new FormData(form)
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network error');
                        return response.json();
                    })
                    .then(data => {
                        // Succès - cacher le loader et afficher le message de succès
                        Swal.fire({
                            title: 'Success!',
                            text: 'User deleted successfully',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Failed to delete user.', 'error');
                    });
                }
            });
        });
    });
});
</script>

<style>
.advanced-user-popup {
    border-radius: 20px !important;
    border: 1px solid #e5e7eb !important;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
}

.user-avatar-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto 1.5rem;
}

.user-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.user-info-item {
    display: flex;
    flex-direction: column;
}

.user-info-item label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.user-info-item span {
    font-weight: 500;
    color: #1f2937;
}

.user-name {
    font-weight: 600 !important;
    color: #111827 !important;
}

.deletion-warning {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: #fef2f2;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #ef4444;
}

.warning-icon {
    font-size: 1.5rem;
    color: #ef4444;
    margin-top: 0.25rem;
}

.warning-content h4 {
    color: #dc2626;
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
}

.warning-content p {
    color: #b91c1c;
    margin: 0;
    font-size: 0.9rem;
}

.advanced-delete-btn {
    background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
    color: white !important;
    border: none !important;
    border-radius: 10px !important;
    padding: 12px 28px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.advanced-delete-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4) !important;
}

.advanced-cancel-btn {
    background: #ffffff !important;
    color: #374151 !important;
    border: 2px solid #d1d5db !important;
    border-radius: 10px !important;
    padding: 12px 28px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
}

.advanced-cancel-btn:hover {
    background: #f9fafb !important;
    border-color: #9ca3af !important;
    transform: translateY(-2px) !important;
}
</style>
    <script>
        // Success message functions
        function showSuccessMessage(message) {
            const successMsg = document.getElementById('successMessage');
            const messageText = document.getElementById('messageText');

            messageText.textContent = message;
            successMsg.classList.remove('hide');
            successMsg.classList.add('show');

            // Set focus to the success message for screen readers
            successMsg.setAttribute('tabindex', '-1');
            successMsg.focus();

            // Auto hide after 4 seconds
            setTimeout(() => {
                hideSuccessMessage();
            }, 4000);
        }

        function hideSuccessMessage() {
            const successMsg = document.getElementById('successMessage');
            successMsg.classList.add('hide');

            setTimeout(() => {
                successMsg.classList.remove('show', 'hide');
            }, 300);
        }

        // Edit technician
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
                        updateMessage.innerHTML = `<div class="alert alert-success" role="alert">${data.message}</div>`;
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        updateMessage.innerHTML = `<div class="alert alert-danger" role="alert">Update error.</div>`;
                    }
                })
                .catch(error => {
                    updateMessage.innerHTML = `<div class="alert alert-danger" role="alert">An error occurred.</div>`;
                });
            });
        });

        // Deactivate technician
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
                            showSuccessMessage('Technician deactivated successfully!');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            alert("Deactivation error.");
                        }
                    })
                    .catch(error => {
                        alert("An error occurred.");
                    });
                });
            });
        });

        // Activate technician
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
                            showSuccessMessage('Technician activated successfully!');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            alert("Activation error.");
                        }
                    })
                    .catch(error => {
                        alert("An error occurred.");
                    });
                });
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            let searchValue = this.value.toLowerCase();
            let criteria = document.getElementById('searchCriteria').value;
            let rows = document.querySelectorAll('#employeeTable tr');

            rows.forEach(row => {
                let cellIndex = criteria === 'nom' ? 2 : criteria === 'prenom' ? 3 : 4;
                let cell = row.querySelector(`td:nth-child(${cellIndex})`);
                if (cell) {
                    let text = cell.textContent.toLowerCase();
                    row.style.display = text.includes(searchValue) ? '' : 'none';
                }
            });
        });

        // Pagination
        document.addEventListener("DOMContentLoaded", function () {
            let rows = document.querySelectorAll('#employeeTable tr');
            let currentPage = 1;
            let rowsPerPage = 4;

            function showPage(page) {
                let start = (page - 1) * rowsPerPage;
                let end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? '' : 'none';
                });

                document.getElementById("pageNumber").textContent = page;

                // Update button states
                document.getElementById("prevPage").disabled = page === 1;
                document.getElementById("nextPage").disabled = page === Math.ceil(rows.length / rowsPerPage);
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

        // Add keyboard navigation for action buttons
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideSuccessMessage();
            }
        });
    </script>
</body>
</html>
