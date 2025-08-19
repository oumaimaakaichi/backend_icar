<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Techniciens | GaragePro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --primary-dark: #309ad3;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #f1f5f9;
            --border: #e2e8f0;
            --gradient-primary: linear-gradient(135deg, #309ad3 0%, #309ad3 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        }

        body {
            background-color: white;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--dark);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            vertical-align: middle;
            padding: 0.75rem 1rem;
        }

        .table tbody td {
            padding: 0.75rem 1.25rem;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: var(--primary-light);
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .btn-primary {
            background-color: "#309ad3";
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-warning {
            background-color: var(--warning);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e68a00;
        }

        .btn-success {
            background-color: var(--success);
            border: none;
        }

        .btn-secondary {
            background-color: var(--gray);
            border: none;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .modal-header {
            background: var(--gradient-primary);
            color: white;
        }

        .modal-warning .modal-header {
            background: var(--gradient-warning);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid var(--border);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .pagination .page-link {
            color: var(--primary);
            border-radius: 8px;
            margin: 0 3px;
            border: 1px solid var(--border);
        }

        .pagination .page-link:hover {
            background-color: var(--primary-light);
        }

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid var(--border);
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
                color: var(--gray);
            }

            .table tbody td:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body class="bg-light">
    @include('Sidebar.sidebarAtelier')

    <div class="container py-4" style="margin-top: 60px ; margin-right:60px">
        <!-- Header avec bouton d'ajout -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h1 class="h2 mb-0 fw-bold">
    Technician Management
</h1>


            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTechnicienModal">
                <i class="fas fa-plus me-2"></i>New Technician
            </button>
        </div>

        <!-- Carte principale -->
        <div class="card">


            <div class="card-body">
                @if($techniciens->count())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Technician</th>
                                  <th>Specialty</th>

                                    <th>Experience</th>
                                    <th>Statut</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($techniciens as $tech)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                {{ substr($tech->prenom ?? $tech->name, 0, 1) }}{{ substr($tech->nom, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $tech->prenom ?? '' }} {{ $tech->nom }}</div>
                                                <small class="text-muted">{{ $tech->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $tech->extra_data['specialite'] ?? 'Non spécifié' }}</td>
                                    <td>{{ $tech->extra_data['annee_experience'] ?? '0' }} years</td>
                                    <td>
                                        <span class="status-badge {{ $tech->isActive ? 'status-active' : 'status-inactive' }}">
                                            {{ $tech->isActive ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-outline-primary edit-technicien me-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTechnicienModal"
                                                    data-id="{{ $tech->id }}"
                                                    data-nom="{{ $tech->nom }}"
                                                    data-prenom="{{ $tech->prenom }}"
                                                    data-email="{{ $tech->email }}"
                                                    data-phone="{{ $tech->phone }}"
                                                    data-adresse="{{ $tech->adresse }}"
                                                    data-specialite="{{ $tech->extra_data['specialite'] ?? '' }}"
                                                    data-annee_experience="{{ $tech->extra_data['annee_experience'] ?? '' }}"
                                                    title="update">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if ($tech->isActive == 0)
                                                <button class="btn btn-sm btn-success accept-btn me-2"
                                                        data-id="{{ $tech->id }}"
                                                        title="Activate">
                                                    <i class="fas fa-toggle-off"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-secondary refuse-btn"
                                                        data-id="{{ $tech->id }}"
                                                        title="Desactivate">
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
                    @if($techniciens->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Display of {{ $techniciens->firstItem() }} à {{ $techniciens->lastItem() }} sur {{ $techniciens->total() }} technicians
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($techniciens->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $techniciens->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($techniciens->getUrlRange(1, $techniciens->lastPage()) as $page => $url)
                                    @if ($page == $techniciens->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($techniciens->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $techniciens->nextPageUrl() }}" rel="next">&raquo;</a>
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
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-cog fa-3x text-muted mb-3"></i>
                        <h5 class="fw-bold">Aucun technicien trouvé</h5>
                        <p class="text-muted">Commencez par ajouter votre premier technicien</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTechnicienModal">
                            <i class="fas fa-plus me-2"></i>Ajouter un technicien
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal d'ajout -->
    <div class="modal fade" id="addTechnicienModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>New Technician
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('techniciens.storee') }}" method="POST">
                    @csrf
                    <input type="hidden" name="atelier_id" value="{{ Auth::id() }}">

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
                                    <option value="" selected disabled>chose Specialty</option>
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
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-primary">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de modification -->
    <div class="modal fade modal-warning" id="editTechnicienModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>Update Technician
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTechnicienForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_technicien_id" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit_nom" name="nom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit_prenom" name="prenom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="edit_email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" id="edit_phone" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" id="edit_adresse" name="adresse" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Specialty <span class="text-danger">*</span></label>
                                <select id="edit_specialite" name="specialite" class="form-select" required>
                                    <option value="" selected disabled>chose a Specialty</option>
                                    @foreach($specialisations as $specialite)
                                        <option value="{{ $specialite->nom_specialite }}">{{ $specialite->nom_specialite }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Years of experience</label>
                                <input type="number" id="edit_annee_experience" name="annee_experience" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-warning"> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Remplir le formulaire de modification
        document.querySelectorAll('.edit-technicien').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('edit_technicien_id').value = id;
                document.getElementById('edit_nom').value = this.getAttribute('data-nom');
                document.getElementById('edit_prenom').value = this.getAttribute('data-prenom');
                document.getElementById('edit_email').value = this.getAttribute('data-email');
                document.getElementById('edit_phone').value = this.getAttribute('data-phone');
                document.getElementById('edit_adresse').value = this.getAttribute('data-adresse');
                document.getElementById('edit_annee_experience').value = this.getAttribute('data-annee_experience');

                // Sélectionner la spécialité
                const specialite = this.getAttribute('data-specialite');
                const select = document.getElementById('edit_specialite');
                Array.from(select.options).forEach(option => {
                    option.selected = option.value === specialite;
                });

                // Mettre à jour l'action du formulaire
                document.getElementById('editTechnicienForm').action = `/users/${id}`;
            });
        });

        // Gestion de l'activation/désactivation
        document.querySelectorAll('.accept-btn').forEach(button => {
            button.addEventListener('click', async function() {
                if (!confirm('Activer ce technicien ?')) return;

                const userId = this.getAttribute('data-id');
                try {
                    const response = await fetch(`/users/${userId}/activate`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'activation');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                }
            });
        });

        document.querySelectorAll('.refuse-btn').forEach(button => {
            button.addEventListener('click', async function() {
                if (!confirm('Désactiver ce technicien ?')) return;

                const userId = this.getAttribute('data-id');
                try {
                    const response = await fetch(`/users/${userId}/desactivate`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la désactivation');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Une erreur est survenue');
                }
            });
        });

        // Gestion de la soumission du formulaire de modification
        document.getElementById('editTechnicienForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alert('Technicien mis à jour avec succès');
                    location.reload();
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            }
        });
    </script>
</body>
</html>
