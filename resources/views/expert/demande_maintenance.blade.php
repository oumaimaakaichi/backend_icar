<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Maintenance</title>
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-color: #5a5c69;
        }

        body {
            background-color: #f8f9fc;
            color: var(--text-color);
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .main-container {

            padding: 40px;
            transition: all 0.3s;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 1rem 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 0 0 15px 15px;
        }

        table.dataTable {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .table thead th {
            border-bottom: 2px solid #e3e6f0;
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
            transform: translateX(2px);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.3rem;
            min-width: 30px;
        }

        .btn-view {
            background-color: #1cc88a;
            color: white;
        }

        .btn-view:hover {
            background-color: #17a673;
            color: white;
        }

        .btn-edit {
            background-color: #36b9cc;
            color: white;
        }

        .btn-edit:hover {
            background-color: #2c9faf;
            color: white;
        }

        .btn-delete {
            background-color: #e74a3b;
            color: white;
        }

        .btn-delete:hover {
            background-color: #be2617;
            color: white;
        }

        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.35rem;
        }

        .badge-pending {
            background-color: #f6c23e;
            color: #1f1d1b;
        }

        .badge-completed {
            background-color: #1cc88a;
            color: white;
        }

        .badge-cancelled {
            background-color: #e74a3b;
            color: white;
        }

        h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }

        h1:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .alert {
            border-radius: 10px;
            box-shadow: 0 0.15rem 0.5rem 0 rgba(58, 59, 69, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        @media (max-width: 768px) {
            .main-container {
                margin-left: 0;
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarExpert')

    <div class="main-container">
        <div class="container-fluid" style="margin-top: 80px">
            <h2 style="margin-bottom: 50px">Maintenance Requests</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-black">
                        <i class="fas fa-clipboard-list me-2" style="color: black"></i>Liste des demandes
                    </h6>
                    <div>
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-download me-1"></i> Exporter
                        </button>
                        <button class="btn btn-sm btn-light" >
                            <i class="fas fa-filter me-1"></i> Filtres
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="demandesTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>

                                    <th>Type de Service</th>
                                    <th>Type d'Assistance</th>
                                    <th>Maintenance</th>
                                    <th>Voiture</th>
                                    <th>Pièce</th>

                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($demandes as $demande)
                                <tr>

                                    <td>{{ $demande->type_service }}</td>
                                    <td>{{ $demande->type_assistance }}</td>
                                    <td>{{ $demande->type_maintenance }}</td>
                                    <td>{{ $demande->type_voiture }}</td>
                                    <td>{{ $demande->piece_rechange }}</td>

                                    <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="status-badge badge-pending">
                                            <i class="fas fa-clock me-1"></i> En attente
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-view" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x mb-3" style="color: #dddfeb;"></i>
                                        <p class="text-muted">Aucune demande trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#demandesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
                },

            });

            // Fermer automatiquement les alertes après 5 secondes
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
</body>
</html>
