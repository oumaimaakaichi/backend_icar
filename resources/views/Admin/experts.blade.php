<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Technicians Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
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
            background: rgba(255,255,255,0.2);
            border: none;
            color: var(--white);
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
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-light);
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
            background: linear-gradient(135deg,#567288 0%,#567288 100%);
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
    <!-- Sidebar placeholder -->
    @include('Sidebar.sidebar')

    <div class="container" style="margin-top: 90px ;margin-right:80px">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-users me-2"></i>Experts Management</h1>
            <p>Manage and supervise all experts in your organization</p>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="success-message">
            <i class="fas fa-check-circle"></i>
            <span class="message-text" id="messageText"></span>
            <button class="close-btn" onclick="hideSuccessMessage()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Controls -->
        <div class="controls">
            <div class="search-group">
                <select id="searchCriteria" class="form-select" style="width: 140px;">
                    <option value="nom">Last Name</option>
                    <option value="prenom">First Name</option>
                    <option value="email">Email</option>
                </select>
                <input type="text" id="searchInput" class="form-control" placeholder="Search a customer...">
            </div>
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTechnicienModal" style="background-color: #567288">
                <i class="fas fa-plus"></i>New Expert
            </button>
        </div>

        @if (isset($experts) && $experts->count() > 0)
        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>LOGO</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTable">
                    @foreach ($experts as $user)
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
            <button id="prevPage" class="pagination-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span class="page-info">Page <span id="pageNumber">1</span></span>
            <button id="nextPage" class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        @else
        <div class="table-container">
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h3>No technicians found</h3>
                <p>Start by adding your first technician</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>Edit Expert
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="userId">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="required">*</span></label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Address <span class="required">*</span></label>
                            <input type="text" id="adresse" name="adresse" class="form-control" required>
                        </div>
                    </form>
                    <div id="updateMessage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editUserForm" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addTechnicienModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #35677d">
                    <h5 class="modal-title" style="color: white">
                        <i class="fas fa-user-plus me-2"></i>New Expert
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('techniciens.storeTech') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="required">*</span></label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="required">*</span></label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="required">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address <span class="required">*</span></label>
                                <input type="text" name="adresse" class="form-control" required>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-user-form');
            const userName = this.getAttribute('data-user-name');
            const button = this;

            Swal.fire({
                title: 'Delete User Account',
                html: `
                    <div class="text-center">
                        <div style="font-size: 4rem; color: #ef4444; margin-bottom: 1rem;">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <p>Are you sure you want to delete <strong>${userName}</strong>?</p>
                        <p style="color: #ef4444; font-size: 0.9rem;">
                            <i class="fas fa-exclamation-triangle"></i>
                            This action cannot be undone
                        </p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Confirm Deletion',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Désactiver le bouton
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    // Animation de suppression avec compteur
                    let timerInterval;
                    Swal.fire({
                        title: 'Deleting User',
                        html: 'The page will reload automatically in <b></b> milliseconds.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector('b');
                            timerInterval = setInterval(() => {
                                timer.textContent = Swal.getTimerLeft();
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        // Soumettre le formulaire et recharger
                        fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => {
                            if (response.ok) {
                                window.location.reload();
                            } else {
                                Swal.fire('Error!', 'Delete failed', 'error');
                                button.disabled = false;
                                button.innerHTML = '<i class="fas fa-trash-alt"></i>';
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Network error', 'error');
                            button.disabled = false;
                            button.innerHTML = '<i class="fas fa-trash-alt"></i>';
                        });
                    });
                }
            });
        });
    });
});
</script>
    <script>
        // Success message functions
        function showSuccessMessage(message) {
            const successMsg = document.getElementById('successMessage');
            const messageText = document.getElementById('messageText');

            messageText.textContent = message;
            successMsg.classList.remove('hide');
            successMsg.classList.add('show');

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
                        updateMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        updateMessage.innerHTML = `<div class="alert alert-danger">Update error.</div>`;
                    }
                })
                .catch(error => {
                    updateMessage.innerHTML = `<div class="alert alert-danger">An error occurred.</div>`;
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
                            showSuccessMessage('Expert deactivated successfully!');
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
                            showSuccessMessage('Expert activated successfully!');
                            setTimeout(() => location.reload(), 1500);
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

        // Search functionality
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

        // Pagination
        document.addEventListener("DOMContentLoaded", function () {
            let rows = document.querySelectorAll('#employeeTable tr');
            let currentPage = 1;
            let rowsPerPage = 5;

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
    </script>
</body>
</html>
