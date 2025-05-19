<!DOCTYPE html>
<html>
<head>
    <title>Liste des Techniciens</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Style amélioré pour la pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background-color: #3a7bd5;
            border-color: #3a7bd5;
            color: white;
        }

        .pagination .page-link {
            color: #3a7bd5;
            border-radius: 5px;
            padding: 6px 12px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #3a7bd5;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Styles pour les modales */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ff9a00 0%, #ffd700 100%);
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

        .btn-warning {
            background-color: #ff9a00;
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background-color: #e68a00;
        }

        .border-warning {
            border-color: #ff9a00 !important;
        }

        .text-warning {
            color: #ff9a00 !important;
        }

        /* Style pour le tableau */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #9ca4b0;
            color: white;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(58, 123, 213, 0.1);
        }

        /* Style pour les boutons d'action */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Style pour le statut */
        .text-primary {
            color: #3a7bd5 !important;
        }

        .text-success {
            color: #28a745 !important;
        }
    </style>
</head>
<body class="bg-light">
    @include('Sidebar.sidebarAtelier')
    <div class="container py-5" style="margin-top: 50px">
        <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i>My Workshop Technicians</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTechnicienModal">
                <i class="bi bi-plus-circle me-2"></i>Add a Technician
            </button>
        </div>
        @if($techniciens->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Specialty</th>
                            <th>Years of Experience</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($techniciens as $tech)
                        <tr>
                            <td>{{ $tech->nom ?? $tech->name }}</td>
                            <td>{{ $tech->prenom ?? '' }}</td>
                            <td>{{ $tech->extra_data['specialite'] ?? 'Non spécifié' }}</td>
                            <td>{{ $tech->extra_data['annee_experience'] ?? 'Non spécifié' }} années</td>
                            <td class="{{ $tech->isActive == 0 ? 'text-primary' : 'text-success' }}">
                                {{ $tech->isActive == 0 ? 'Désactivé ' : 'Activé' }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-technicien"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editTechnicienModal"
                                        data-id="{{ $tech->id }}"
                                        data-nom="{{ $tech->nom }}"
                                        data-prenom="{{ $tech->prenom }}"
                                        data-email="{{ $tech->email }}"
                                        data-phone="{{ $tech->phone }}"
                                        data-adresse="{{ $tech->adresse }}"
                                        data-specialite="{{ $tech->extra_data['specialite'] }}"
                                        data-annee_experience="{{ $tech->extra_data['annee_experience'] }}"
                                        title="Éditer">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                @if ($tech->isActive == 0)
                                    <button class="btn btn-success btn-sm accept-btn me-1"
                                            data-id="{{ $tech->id }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Activate User">
                                        <i class="fas fa-toggle-off"></i>
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm refuse-btn"
                                            data-id="{{ $tech->id }}"
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

            <!-- Pagination améliorée -->
            @if($techniciens->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $techniciens->firstItem() }} to {{ $techniciens->lastItem() }} of {{ $techniciens->total() }} entries
                </div>

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($techniciens->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
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
                        @if ($techniciens->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $techniciens->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            @endif

        @else
            <div class="alert alert-info">
                Aucun technicien trouvé pour votre atelier.
            </div>
        @endif
    </div>

    <!-- Modal d'ajout -->
    <div class="modal fade" id="addTechnicienModal" tabindex="-1" aria-labelledby="addTechnicienModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <!-- Header avec dégradé de couleur -->
                <div class="modal-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-cog fa-xl me-3"></i>
                        <h5 class="modal-title fs-4 fw-bold" id="addTechnicienModalLabel">Ajouter un Nouveau Technicien</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Corps du formulaire -->
                <div class="modal-body p-4">
                    <form action="{{ route('techniciens.storee') }}" method="POST" id="technicienForm">
                        @csrf
                        <input type="hidden" name="atelier_id" value="{{ Auth::id() }}">

                        <!-- Section Informations de base -->
                        <div class="mb-4">
                            <h6 class="mb-3 border-bottom pb-2">
                                <i class="fas fa-id-card me-2"></i>Informations Personnelles
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control  border-2 rounded-3" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" class="form-control  border-2 rounded-3" required>
                                </div>
                            </div>
                        </div>

                        <!-- Section Contact -->
                        <div class="mb-4">
                            <h6 class=" mb-3 border-bottom pb-2">
                                <i class="fas fa-address-book me-2"></i>Coordonnées
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0  border-2 rounded-end-3" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Téléphone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="phone" class="form-control border-start-0  border-2 rounded-end-3" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Adresse <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" name="adresse" class="form-control border-start-0  border-2 rounded-end-3" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Expertise -->
                        <div class="mb-4">
                            <h6 class=" mb-3 border-bottom pb-2">
                                <i class="fas fa-tools me-2"></i>Expertise Technique
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Spécialité</label>
                                    <select name="specialite" class="form-select  border-2 rounded-3">
                                        <option value="">Sélectionner...</option>
                                        <option value="Mécanique générale">Mécanique générale</option>
                                        <option value="Électricité automobile">Électricité automobile</option>
                                        <option value="Carrosserie">Carrosserie</option>
                                        <option value="Diagnostic électronique">Diagnostic électronique</option>
                                        <option value="Climatisation">Climatisation</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Années d'expérience</label>
                                    <input type="number" name="annee_experience" class="form-control  border-2 rounded-3" min="0" max="50">
                                </div>
                            </div>
                        </div>

                        <!-- Pied de page avec boutons -->
                        <div class="modal-footer border-0 pt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de modification -->
    <div class="modal fade" id="editTechnicienModal" tabindex="-1" aria-labelledby="editTechnicienModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <!-- En-tête avec dégradé orange -->
                <div class="modal-header bg-gradient-warning text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-edit fa-xl me-3"></i>
                        <h5 class="modal-title fs-4 fw-bold" id="editTechnicienModalLabel">Modifier le Technicien</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Corps du formulaire -->
                <div class="modal-body p-4">
                    <form id="editTechnicienForm" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_technicien_id" name="id">

                        <!-- Section Informations personnelles -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-warning mb-3 border-bottom pb-2">
                                <i class="fas fa-id-card-alt me-2"></i>Informations Personnelles
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_nom" name="nom" class="form-control  border-2 rounded-3" required>
                                    <div class="invalid-feedback">Veuillez saisir le nom</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_prenom" name="prenom" class="form-control  border-2 rounded-3" required>
                                    <div class="invalid-feedback">Veuillez saisir le prénom</div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Contact -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-warning mb-3 border-bottom pb-2">
                                <i class="fas fa-address-card me-2"></i>Coordonnées
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        <input type="email" id="edit_email" name="email" class="form-control border-start-0  border-2 rounded-end-3" required>
                                        <div class="invalid-feedback">Email invalide</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Téléphone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                        <input type="text" id="edit_phone" name="phone" class="form-control border-start-0  border-2 rounded-end-3" required>
                                        <div class="invalid-feedback">Téléphone requis</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Adresse <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" id="edit_adresse" name="adresse" class="form-control border-start-0  border-2 rounded-end-3" required>
                                        <div class="invalid-feedback">Adresse requise</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Expertise -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-warning mb-3 border-bottom pb-2">
                                <i class="fas fa-tools me-2"></i>Expertise Technique
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Spécialité</label>
                                    <select id="edit_specialite" name="specialite" class="form-select  border-2 rounded-3">
                                        <option value="">Sélectionner...</option>
                                        <option value="Mécanique générale">Mécanique générale</option>
                                        <option value="Électricité automobile">Électricité automobile</option>
                                        <option value="Carrosserie">Carrosserie</option>
                                        <option value="Diagnostic électronique">Diagnostic électronique</option>
                                        <option value="Climatisation">Climatisation</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Années d'expérience</label>
                                    <input type="number" id="edit_annee_experience" name="annee_experience" class="form-control  border-2 rounded-3" min="0" max="50">
                                </div>
                            </div>
                        </div>

                        <!-- Pied de page avec boutons -->
                        <div class="modal-footer border-0 pt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm fw-bold">
                                <i class="fas fa-sync-alt me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>

                    <!-- Message de feedback -->
                    <div id="updateMessage" class="alert alert-dismissible fade show mt-3 mb-0" style="display: none;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <span id="updateMessageText"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Remplir le formulaire de modification avec les données du technicien
            document.querySelectorAll('.edit-technicien').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nom = this.getAttribute('data-nom');
                    const prenom = this.getAttribute('data-prenom');
                    const email = this.getAttribute('data-email');
                    const phone = this.getAttribute('data-phone');
                    const adresse = this.getAttribute('data-adresse');
                    const specialite = this.getAttribute('data-specialite');
                    const annee_experience = this.getAttribute('data-annee_experience');

                    document.getElementById('edit_technicien_id').value = id;
                    document.getElementById('edit_nom').value = nom;
                    document.getElementById('edit_prenom').value = prenom;
                    document.getElementById('edit_email').value = email;
                    document.getElementById('edit_phone').value = phone;
                    document.getElementById('edit_adresse').value = adresse;
                    document.getElementById('edit_specialite').value = specialite;
                    document.getElementById('edit_annee_experience').value = annee_experience;

                    // Mettre à jour l'action du formulaire
                    document.getElementById('editTechnicienForm').action = `/users/${id}`;
                });
            });

            // Gérer la soumission du formulaire de modification
            document.getElementById('editTechnicienForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const updateMessage = document.getElementById('updateMessage');

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    updateMessage.style.display = 'block';
                    if (data.success) {
                        updateMessage.className = 'alert alert-success alert-dismissible fade show mt-3 mb-0';
                        updateMessage.innerHTML = `
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Succès!</strong> ${data.message}
                        `;
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        updateMessage.className = 'alert alert-danger alert-dismissible fade show mt-3 mb-0';
                        updateMessage.innerHTML = `
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Erreur!</strong> ${data.message || 'Erreur lors de la mise à jour'}
                        `;
                    }
                })
                .catch(error => {
                    updateMessage.style.display = 'block';
                    updateMessage.className = 'alert alert-danger alert-dismissible fade show mt-3 mb-0';
                    updateMessage.innerHTML = `
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>Erreur!</strong> Une erreur s'est produite lors de la mise à jour
                    `;
                    console.error('Error:', error);
                });
            });
        });

        // Safe CSRF token getter
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }

        // Activation handler
        document.querySelectorAll('.accept-btn').forEach(button => {
            button.addEventListener('click', async function() {
                if (!confirm('Are you sure you want to activate this technician?')) return;

                try {
                    const userId = this.dataset.id;
                    const response = await fetch(`/users/${userId}/activate`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCSRFToken(),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include'
                    });

                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                    const data = await response.json();
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || "Activation failed");
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert(`Error: ${error.message}`);
                }
            });
        });

        // Deactivation handler
        document.querySelectorAll('.refuse-btn').forEach(button => {
            button.addEventListener('click', async function() {
                if (!confirm('Are you sure you want to deactivate this technician?')) return;

                try {
                    const userId = this.dataset.id;
                    const response = await fetch(`/users/${userId}/desactivate`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': getCSRFToken(),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'include'
                    });

                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                    const data = await response.json();
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || "Deactivation failed");
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert(`Error: ${error.message}`);
                }
            });
        });
    </script>
</body>
</html>
