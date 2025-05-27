<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes par Atelier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .demande-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }
        .demande-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .status-Non_assigné {
    background-color: #0d6efd; /* bleu bootstrap */
    color: white;
}

.status-Assigné {
    background-color: #198754; /* vert bootstrap */
    color: white;
}

        .status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-Nouvelle_demande {
            background-color: #b1c7f3;
            color: #121517;
              font-weight: bold;
        }
        .status-Une_offre_a_été_faite {
            background-color: #fff3cd;
            font-weight: bold;
            color: #161614;
        }
        .status-offre_acceptee {
            background-color: #d4edda;
            color: #155724;
        }
        .status-Assignée {
            background-color: rgb(142, 169, 142);
            color: #141414;
        }
        .piece-indicator {
            color: #fd7e14;
        }
        .rdv-date {
            font-weight: 600;
            color: #198754;
        }
    </style>
</head>
<body>
        @include('Sidebar.sidebarAtelier')
    <div class="container py-4"  style="margin-top:40px">
        <div class="d-flex justify-content-between align-items-center mb-4">


        </div>

        @if($demandes->isEmpty())
            <div class="alert alert-info">
                Aucune demande trouvée pour cet atelier
            </div>
        @else
            <div class="row" style="margin-left: 90px">


                <div class="col-md-9">
                    @foreach($demandes as $demande)
                        <div class="card demande-card mb-3" data-status="{{ $demande->status }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">
                                        Demande #{{ $demande->id }}
                                        @if($demande->has_piece_recommandee)
                                            <i class="fas fa-tools piece-indicator ms-2" title="Pièces recommandées"></i>
                                        @endif
                                    </h5>
                                    <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                        {{ str_replace('_', ' ', $demande->status) }}
                                    </span>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1">
                                            <strong>Client:</strong>
                                            {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                        </p>
                                        <p class="mb-1"><strong>Téléphone:</strong> {{ $demande->client->phone }}</p>
                                        <p class="mb-1">
                                            <strong>Véhicule:</strong>
                                            {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1">
                                            <strong>Service:</strong> {{ $demande->servicePanne->titre }}
                                        </p>
                                        <p class="mb-1">
                                            <strong>Catégorie:</strong> {{ $demande->servicePanne->categoryPane->titre }}
                                        </p>
                                        <p class="mb-1">
                                            <strong>Forfait:</strong> {{ $demande->forfait->nomForfait }}
                                        </p>
                                    </div>


                                </div>

                                <hr class="my-2">

                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Créée le {{ $demande->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    @if($demande->date_maintenance)
                                        <span class="rdv-date">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            RDV: {{ $demande->date_maintenance->format('d/m/Y H:i') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 d-flex justify-content-end">
                                    <a href="{{ route('ateliers.show', $demande->id) }}" class="btn btn-sm btn-outline-primary me-2">
    <i class="fas fa-eye me-1"></i> Détails
</a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('applyFilter').addEventListener('click', function() {
            const status = document.getElementById('statusFilter').value;
            const cards = document.querySelectorAll('.demande-card');

            cards.forEach(card => {
                if(status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
