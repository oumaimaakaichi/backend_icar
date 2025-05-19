<!DOCTYPE html>
<html>
<head>
    <title>Liste des Techniciens</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-left: 250px; /* Ajustez selon la largeur de votre sidebar */
        }
    </style>
</head>
<body class="bg-light">
    @include('sidebarAtelier')

    <div class="container mt-5">
        <h2 class="mb-4"><i class="bi bi-people-fill me-2"></i>Techniciens de mon Atelier</h2>

        @if($techniciens->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($techniciens as $tech)
                        <tr>
                            <td>{{ $tech->nom ?? $tech->name }}</td>
                            <td>{{ $tech->prenom ?? '' }}</td>
                            <td>{{ $tech->email }}</td>
                            <td>{{ $tech->phone ?? 'Non renseigné' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-warning" title="Éditer">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Aucun technicien trouvé pour votre atelier.
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
