<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes pour Expert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

            @include('Sidebar.sidebarExpert')

    <div class="container mt-4">
        <h2 class="mb-4"  style="margin-top: 70px">Liste des Demandes</h2>

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
    <div class="mt-3 d-flex justify-content-end">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
