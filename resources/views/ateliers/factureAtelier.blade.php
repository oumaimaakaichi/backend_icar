<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factures de l'Atelier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        .badge-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-unpaid {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-partially-paid {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .action-btns .btn {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .total-amount {
            font-weight: bold;
            color: #2c3e50;
        }
        .card {
            border-radius: 10px;
        }
        .table th {
            white-space: nowrap;
        }
        .filter-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .filter-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #495057;
        }
        @media (max-width: 768px) {
            .action-btns .btn {
                margin-bottom: 5px;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
            .filter-section {
                padding: 10px;
            }
        }
    </style>
</head>
<body class="bg-light">
    @include('Sidebar.sidebarAtelier')

    <div class="container py-4" style="margin-top: 60px ">
        <div class="card shadow p-3 p-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                <h2 class="mb-3 mb-md-0"><i class="bi bi-receipt me-2"></i>&nbsp;Factures </h2>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFactureModal">
                        <i class="bi bi-plus-circle me-2"></i>Créer une Facture
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Section des filtres -->
            <div class="filter-section mb-4">
                <h5 class="filter-title"><i class="bi bi-funnel me-2"></i>Filtrer les factures</h5>
                <form id="filterForm" method="GET" action="{{ route('factures.index') }}">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="filter_client" class="form-label">Client</label>
                            <select class="form-select" id="filter_client" name="user_id">
                                <option value="">Tous les clients</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('user_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->nom }} {{ $client->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filter_status" class="form-label">Statut</label>
                            <select class="form-select" id="filter_status" name="status">
                                <option value="">Tous les statuts</option>
                                <option value="payé" {{ request('status') == 'payé' ? 'selected' : '' }}>Payée</option>
                                <option value="impayée" {{ request('status') == 'impayée' ? 'selected' : '' }}>Impayée</option>
                                <option value="partiellement payée" {{ request('status') == 'partiellement payée' ? 'selected' : '' }}>Partiellement payée</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="filter_date_start" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="filter_date_start" name="date_start" value="{{ request('date_start') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="filter_date_end" class="form-label">Date de fin</label>
                            <input type="date" class="form-control" id="filter_date_end" name="date_end" value="{{ request('date_end') }}">
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-filter me-1"></i>Filtrer
                            </button>
                            <a href="{{ route('factures.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Réinitialiser
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            @if($factures->count())
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Type Facture</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Remise</th>
                                <th>Taxe</th>
                                <th>Montant total</th>
                                <th>Statut</th>
                                <th class="text-end">Actions &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($factures as $facture)
                            <tr>
                                <td>{{ $facture->type_service }}</td>
                                <td>{{ $facture->client->nom ?? 'N/A' }} {{ $facture->client->prenom ?? 'N/A' }}</td>
                                <td>{{ $facture->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $facture->remise }} €</td>
                                <td>{{ $facture->taxe }} €</td>
                                <td class="total-amount">{{ number_format($facture->montant_total, 2, ',', ' ') }} €</td>
                                <td>
                                    @if($facture->status == 'payé')
                                        <span class="status-badge badge-paid">
                                            <i class="bi bi-check-circle-fill me-1"></i>Payée
                                        </span>
                                    @elseif($facture->status == 'partiellement payée')
                                        <span class="status-badge badge-partially-paid">
                                            <i class="bi bi-currency-exchange me-1"></i>Partiel
                                        </span>
                                    @else
                                        <span class="status-badge badge-unpaid">
                                            <i class="bi bi-exclamation-circle-fill me-1"></i>Impayée
                                        </span>
                                    @endif
                                </td>
                                <td class="action-btns text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('factures.show', $facture->id) }}" class="btn btn-sm btn-info me-2" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <button class="btn btn-sm btn-danger me-2 delete-facture" data-id="{{ $facture->id }}" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <a href="{{ route('factures.download', $facture->id) }}" class="btn btn-sm btn-secondary" title="Télécharger">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    @if($factures->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $factures->links() }}
                    </div>
                    @endif
                </div>
                @endif

        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteFactureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cette facture ? Cette action est irréversible.</p>
                    <p class="text-muted">Toutes les données associées à cette facture seront également supprimées.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteFactureForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour créer une facture -->
    <div class="modal fade" id="createFactureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Créer une nouvelle facture</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createFactureForm" method="POST" action="{{ route('factures.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="type_service" class="form-label">Type de service</label>
                                <select class="form-select" id="type_service" name="type_service" required>
                                    <option value="" selected disabled>Sélectionnez un service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->nomService }}">{{ $service->nomService }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="client_id" class="form-label">Client</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="" selected disabled>Sélectionnez un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="prix" class="form-label">Prix (€)</label>
                                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                            </div>
                            <div class="col-md-4">
                                <label for="remise" class="form-label">Remise (€)</label>
                                <input type="number" step="0.01" class="form-control" id="remise" name="remise" value="0" required>
                            </div>
                            <div class="col-md-4">
                                <label for="taxe" class="form-label">Taxe (€)</label>
                                <input type="number" step="0.01" class="form-control" id="taxe" name="taxe" value="0" required>
                            </div>
                            <input type="hidden" name="atelier_id" value="{{ Auth::user()->id }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la suppression
            const deleteButtons = document.querySelectorAll('.delete-facture');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteFactureModal'));
            const deleteForm = document.getElementById('deleteFactureForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const factureId = this.getAttribute('data-id');
                    deleteForm.action = `/factures/${factureId}`;
                    deleteModal.show();
                });
            });

            // Alertes auto-fermantes
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150);
                }, 5000);
            }

            // Calcul automatique du montant total lors de la création
            const prixInput = document.getElementById('prix');
            const remiseInput = document.getElementById('remise');
            const taxeInput = document.getElementById('taxe');

            if (prixInput && remiseInput && taxeInput) {
                [prixInput, remiseInput, taxeInput].forEach(input => {
                    input.addEventListener('input', function() {
                        // Cette fonction pourrait être utilisée pour afficher un aperçu du total
                        // mais dans notre cas, le calcul est fait côté serveur
                    });
                });
            }
        });

        // Dans votre script
        async function handleFormSubmit(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...';

                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) throw new Error(data.message || 'Erreur serveur');

                // Succès
                const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                modal.hide();

                // Afficher un message de succès
                showAlert('success', 'Facture créée avec succès');

                // Recharger après 1.5s
                setTimeout(() => window.location.reload(), 1500);

            } catch (error) {
                console.error('Error:', error);
                showAlert('danger', error.message || 'Erreur lors de la création');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            const container = document.querySelector('.container.py-4');
            container.prepend(alertDiv);

            // Auto-dismiss after 5s
            setTimeout(() => {
                alertDiv.classList.add('fade');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }

        document.getElementById('createFactureForm')?.addEventListener('submit', handleFormSubmit);
    </script>
</body>
</html>
