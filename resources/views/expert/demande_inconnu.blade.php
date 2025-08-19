<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes Expert | GaragePro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        .container-main {
            margin-top: 10px;
            padding: 2rem;
            transition: all 0.3s;
        }

        @media (max-width: 992px) {
            .container-main {
                margin-left: 0;
                padding: 1rem;
            }
        }

        .page-title {
            color: var(--dark);
            font-weight: 700;
            position: relative;
            padding-bottom: 0.75rem;
            margin-top: 1rem;
        }

        .page-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--success));
            border-radius: 2px;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .table th {
            padding: 1rem 1.25rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            vertical-align: middle;
        }

        .table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .badge-status {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            font-size: 0.75rem;
            border-radius: 8px;
            min-width: 100px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .badge-new {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .badge-assigned {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning);
        }

        .badge-offer {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        .badge-completed {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .client-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 600;
            margin-right: 0.75rem;
        }

        .btn-action {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
        }

        .btn-details {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            border: none;
        }

        .btn-details:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-contact {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: none;
        }

        .btn-contact:hover {
            background-color: #28a745;
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .pagination .page-link {
            color: var(--dark);
            border-radius: 8px;
            margin: 0 4px;
            border: none;
            padding: 0.5rem 1rem;
        }

        .empty-state {
            padding: 3rem;
            text-align: center;
            background: white;
            border-radius: 12px;
        }

        .empty-icon {
            font-size: 4rem;
            color: #e9ecef;
            margin-bottom: 1.5rem;
        }

        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .indicator-new {
            background-color: var(--primary);
        }

        .indicator-assigned {
            background-color: var(--warning);
        }

        .indicator-offer {
            background-color: var(--success);
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .form-control, .form-select {
            border-radius: 8px !important;
            padding: 0.75rem 1rem;
        }
    </style>
</head>
<body>

@include('Sidebar.sidebarExpert')
<div class="container py-5" style="margin-top: 0px">
    <div class="p-4 d-flex justify-content-between align-items-center mb-4" style="background-color: transparent">
         <h2 class="page-title">Unknown Issue Requests</h2>
        <div>
            <span class="me-3 text-muted small"><span class="status-indicator indicator-new"></span> New</span>
            <span class="me-3 text-muted small"><span class="status-indicator indicator-assigned"></span> Assigned</span>
            <span class="text-muted small"><span class="status-indicator indicator-offer"></span> Offer</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="statusFilter" class="form-label small text-muted mb-1">Status</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-filter"></i></span>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Nouvelle_demande">New Request</option>
                        <option value="Assignée">Assigned</option>
                        <option value="Une_offre_a_été_faite">Offer Made</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label for="dateFilter" class="form-label small text-muted mb-1">Date</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    <input type="date" id="dateFilter" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <label for="clientSearch" class="form-label small text-muted mb-1">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="clientSearch" class="form-control" placeholder="Client, car...">
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        @if(count($demandes) > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Car</th>

                    <th>Description</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="client-avatar">
                                {{ substr($demande['client_prenom'], 0, 1) }}{{ substr($demande['client_nom'], 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $demande['client_prenom'] }} {{ $demande['client_nom'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $demande['voiture_model'] }}</div>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">{{ $demande['description_probleme'] }}</span>
                    </td>
                    <td>
                        <span class="badge bg-info bg-opacity-10 text-info"><i class="fas fa-home me-1"></i> {{$demande['type_emplacement']}}</span>
                    </td>
                    <td>
                        @if($demande['date_maintenance'])
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($demande['date_maintenance'])->format('d/m/Y') }}</div>
                        @else
                            <span class="text-muted">To Schedule</span>
                        @endif
                    </td>
                    <td>
                        @if($demande['status'] == 'Nouvelle_demande')
                            <span class="badge-status badge-new"><i class="fas fa-clock me-1"></i> New</span>
                        @elseif($demande['status'] == 'Assignée')
                            <span class="badge-status badge-assigned"><i class="fas fa-user-check me-1"></i> Assigned</span>
                        @elseif($demande['status'] == 'Une_offre_a_été_faite')
                            <span class="badge-status badge-offer"><i class="fas fa-file-invoice me-1"></i> Offer Made</span>
                        @elseif($demande['status'] == 'completed')
                            <span class="badge-status badge-completed"><i class="fas fa-check-circle me-1"></i> Completed</span>
                        @else
                            <span class="badge bg-secondary">{{ $demande['status'] }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('expert.show2', $demande['id']) }}" class="btn-action btn-details">
                                <i class="fas fa-eye me-1"></i> Details
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-clipboard-list empty-icon"></i>
            <h4 class="mb-2">No requests found</h4>
            <p class="text-muted mb-4">No requests match your search criteria</p>
            <button class="btn btn-primary" onclick="resetFilters()">
                <i class="fas fa-sync-alt me-2"></i> Reset Filters
            </button>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if(count($demandes) > 0)
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted small">
            Showing <span class="fw-semibold">{{ $demandes->firstItem() }}</span> to <span class="fw-semibold">{{ $demandes->lastItem() }}</span> of <span class="fw-semibold">{{ $demandes->total() }}</span> requests
        </div>
        <div>
            {{ $demandes->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>


<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="contactModalLabel">Contacter le client</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="contactMethod" class="form-label">Méthode de contact</label>
                        <select class="form-select" id="contactMethod">
                            <option value="email">Email</option>
                            <option value="phone">Téléphone</option>
                            <option value="sms">SMS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="messageContent" class="form-label">Message</label>
                        <textarea class="form-control" id="messageContent" rows="5" placeholder="Rédigez votre message ici..."></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="sendCopy">
                        <label class="form-check-label" for="sendCopy">
                            M'envoyer une copie
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Envoyer le message</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filtre par statut
    document.getElementById('statusFilter').addEventListener('change', function() {
        applyFilters();
    });

    // Filtre par date
    document.getElementById('dateFilter').addEventListener('change', function() {
        applyFilters();
    });

    // Filtre par recherche
    let searchTimer;
    document.getElementById('clientSearch').addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            applyFilters();
        }, 500);
    });

    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        const date = document.getElementById('dateFilter').value;
        const search = document.getElementById('clientSearch').value.trim();

        let url = "{{ route('expert.demandes') }}";
        const params = [];

        if (status) params.push(`status=${status}`);
        if (date) params.push(`date=${date}`);
        if (search) params.push(`search=${search}`);

        window.location.href = url + (params.length ? '?' + params.join('&') : '');
    }

    function resetFilters() {
        document.getElementById('statusFilter').value = '';
        document.getElementById('dateFilter').value = '';
        document.getElementById('clientSearch').value = '';
        applyFilters();
    }

    // Pré-remplir les filtres s'ils existent dans l'URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('status')) {
            document.getElementById('statusFilter').value = urlParams.get('status');
        }

        if (urlParams.get('date')) {
            document.getElementById('dateFilter').value = urlParams.get('date');
        }

        if (urlParams.get('search')) {
            document.getElementById('clientSearch').value = urlParams.get('search');
        }
    });
</script>

</body>
</html>
