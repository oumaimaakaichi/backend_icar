<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes pour Expert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

@include('Sidebar.sidebarExpert')

<div class="container mt-4">
    <h2 class="mb-4" style="margin-top: 70px">Liste des Demandes</h2>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
                <select id="statusFilter" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="Nouvelle_demande">Nouvelle demande</option>
                    <option value="Assignée">Assignée</option>
                    <option value="Une_offre_a_été_faite">Une_offre_a_été_faite</option>

                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" id="clientSearch" class="form-control" placeholder="Rechercher par nom client...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Client</th>
                    <th>Voiture</th>
                    <th>Service</th>
                    <th>Catégorie</th>
                    <th>Pack</th>
                    <th>Type</th>
                    <th>Date Maintenance</th>
                    <th>Pièces</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                <tr>
                    <td>{{ $demande['client_prenom'] }} {{ $demande['client_nom'] }}</td>
                    <td>{{ $demande['voiture_model'] }} </td>
                    <td>{{ $demande['service_titre'] }}</td>
                    <td>{{ $demande['categorie_titre'] }}</td>
                    <td>{{ $demande['forfait_titre'] }}</td>
                    <td>{{ $demande['type_emplacement'] }}</td>
                    <td>{{ $demande['date_maintenance'] ?? 'N/A' }}</td>
                    <td>
                        @if($demande['has_piece_recommandee'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle-fill text-danger"></i>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $demande['status'] == 'pending' ? 'bg-warning' :
                                        ($demande['status'] == 'accepted' ? 'bg-success' :
                                        ($demande['status'] == 'rejected' ? 'bg-danger' :
                                        ($demande['status'] == 'completed' ? 'bg-primary' : 'bg-secondary'))) }}">
                            {{ $demande['status'] }}
                        </span>
                    </td>
                    <td>
                        <div>
                            <a href="{{ route('expert.show', $demande['id']) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-eye me-1"></i> Détails
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $demandes->links('pagination::bootstrap-5') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filtre par statut
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const search = document.getElementById('clientSearch').value.trim();
        let url = "{{ route('expert.demandes') }}";
        const params = [];

        if (status) params.push(`status=${status}`);
        if (search) params.push(`search=${search}`);

        window.location.href = url + (params.length ? '?' + params.join('&') : '');
    });

    // Filtre par nom client (avec délai)
    let searchTimer;
    document.getElementById('clientSearch').addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            const search = this.value.trim();
            const status = document.getElementById('statusFilter').value;
            let url = "{{ route('expert.demandes') }}";
            const params = [];

            if (status) params.push(`status=${status}`);
            if (search) params.push(`search=${search}`);

            window.location.href = url + (params.length ? '?' + params.join('&') : '');
        }, 500);
    });

    // Pré-remplir les filtres s'ils existent dans l'URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        const searchParam = urlParams.get('search');

        if (statusParam) {
            document.getElementById('statusFilter').value = statusParam;
        }

        if (searchParam) {
            document.getElementById('clientSearch').value = searchParam;
        }
    });
</script>

</body>
</html>
