<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light d-flex">

    <!-- Sidebar -->
    @include('Sidebar.sidebar')

    <div class="container py-5" style="margin-top: 50px">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4"><b>List of Customers</b></h2>

            <!-- Barre de recherche -->
            <div class="d-flex mb-4">
                <select id="searchCriteria" class="form-select w-auto me-2">
                    <option value="nom">First Name</option>
                    <option value="prenom">Last Name</option>
                    <option value="phone">Numéro de télephone </option>
                </select>
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>

            @if (isset($employee) && $employee->count() > 0)
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTable">
                        @foreach ($employee as $user)
                            <tr>
                                <td>{{ $user->nom }}</td>
                                <td>{{ $user->prenom }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->adresse }}</td>
                                <td>{{ $user->role }}</td>
                                <td class="{{ $user->isActive == 0 ? 'text-primary' : 'text-success' }}">
                                    {{ $user->isActive == 0 ? 'Désactivé ' : 'Activé' }}
                                </td>
                                <td>
                                    <!-- Bouton Édition avec Tooltip -->
                                    <button class="btn btn-warning btn-sm edit-btn me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal"
                                            data-id="{{ $user->id }}"
                                            data-email="{{ $user->email }}"
                                            data-phone="{{ $user->phone }}"
                                            data-adresse="{{ $user->adresse }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Bouton Suppression avec Tooltip -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline me-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Confirm Deletion?')"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Delete User">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                    <!-- Bouton Activation/Désactivation avec Tooltip -->
                                    @if ($user->isActive == 0)
                                        <button class="btn btn-success btn-sm accept-btn me-1"
                                                data-id="{{ $user->id }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Activate User">
                                            <i class="fas fa-toggle-off"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-sm refuse-btn"
                                                data-id="{{ $user->id }}"
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
                <div class="d-flex justify-content-center">
                    <button id="prevPage" class="btn btn-outline-primary me-2">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <span id="pageNumber" class="align-self-center">1</span>
                    <button id="nextPage" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            @else
            <p class="text-center">No user found.</p>

            @endif

        </div>
    </div>
    <div class="modal fade" id="suspendUserModal" tabindex="-1" aria-labelledby="suspendUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Suspend Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="suspendUserId">
                    <div class="mb-3">
                        <label for="suspendReason" class="form-label">Reason for Suspension</label>
                        <textarea id="suspendReason" class="form-control" required></textarea>
                    </div>
                    <button type="button" class="btn btn-danger w-100" id="confirmSuspend">Suspend</button>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL D'ÉDITION -->
       <!-- Popup pour modifier un utilisateur -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        </script>
    <!-- SCRIPT POUR REMPLIR LA MODAL ET APPELER L'API -->
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

        //activer employee
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
                            alert(data.message);
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

        // search employee
        document.getElementById('searchInput').addEventListener('input', function() {
    let searchValue = this.value.toLowerCase();
    let criteria = document.getElementById('searchCriteria').value;
    let rows = document.querySelectorAll('#employeeTable tr');

    rows.forEach(row => {
        let cellIndex;
        switch (criteria) {
            case 'nom':
                cellIndex = 1;
                break;
            case 'prenom':
                cellIndex = 2;
                break;
            case 'email':
                cellIndex = 3;
                break;
            case 'phone':
                cellIndex = 4;
                break;
            default:
                cellIndex = 1;
        }

        let cell = row.querySelector(`td:nth-child(${cellIndex})`);
        if (cell) {
            let text = cell.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        }
    });
});
        document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.suspend-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('suspendUserId').value = this.getAttribute('data-id');
            });
        });
        document.getElementById('confirmSuspend').addEventListener('click', function () {
            let userId = document.getElementById('suspendUserId').value;
            let reason = document.getElementById('suspendReason').value;

            if (!reason.trim()) {
                alert("Veuillez entrer une raison !");
                return;
            }

            fetch(`/users/${userId}/suspend`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ reason })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                setTimeout(() => location.reload(), 1000);
            })
            .catch(error => {
                alert("Une erreur s'est produite.");
            });
        });
    });
    </script>


 <script>

    // limiter nombre des employee affichee
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
