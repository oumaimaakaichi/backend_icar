<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Demandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
      <div class="sidebar-container">
        @include('Sidebar.responsablePiece')
    </div>
    <div class="container mt-5" >
        <h1 class="mb-4" style="margin-top: 100px">Liste des Demandes</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                          <th>Client</th>
                        <th>Téléphone</th>
                        <th>Service</th>
                        <th>Catégorie</th>

                        <th>Voiture</th>
                        <th>Forfait</th>
                        <th>Date</th>
                          <th>Action</th>
                    </tr>
                </thead>
                <tbody id="demandes-table">
                    <!-- Les données seront chargées ici via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    fetch("{{ url('/api/demandes') }}")
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('demandes-table');

            data.forEach(demande => {
                const row = document.createElement('tr');

                let actionButton;

                if (!demande.has_piece_recommandee) {
                    // Bouton pour ajouter les pièces
                    actionButton = `
                        <i class="bi bi-plus-circle text-primary"
                           style="cursor: pointer;"
                           title="Ajouter les pièces"
                           onclick="window.location.href='/piece-recommandee/ajouter/${demande.id}'"></i>`;
                } else {
                    // Bouton pour voir les pièces existantes
                    actionButton = `
                        <i class="bi bi-eye text-success"
                           style="cursor: pointer;"
                           title="Voir les pièces recommandées"
                           onclick="window.location.href='/piece-recommandee/voir/${demande.id}'"></i>`;
                }

                row.innerHTML = `
                    <td>${demande.client_prenom || ''} ${demande.client_nom || ''}</td>
                    <td>${demande.client_phone || 'N/A'}</td>
                    <td>${demande.service_titre || 'N/A'}</td>
                    <td>${demande.categorie_titre || 'N/A'}</td>
                    <td>${demande.voiture_model || 'N/A'} (${demande.voiture_serie || 'N/A'})</td>
                    <td>${demande.forfait_titre || 'N/A'}</td>
                    <td>${demande.created_at}</td>
                    <td>${actionButton}</td>
                `;

                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement des demandes:', error);
        });
});

    </script>
</body>
</html>
