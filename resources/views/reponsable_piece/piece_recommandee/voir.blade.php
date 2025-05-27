@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">
                <i class="fas fa-cogs me-2"></i>
                Pièces recommandées pour la demande #{{ $pieceRecommandee->demande_id }}
            </h2>
        </div>

        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($pieceRecommandee->pieces as $piece)
                    <div class="col">
                        <div class="card h-100 border-primary">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-cog me-2 text-primary"></i>
                                    Pièce #{{ $piece['idPiece'] }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-tag me-2 text-muted"></i> Prix Original</span>
                                        <span class="badge bg-secondary rounded-pill">{{ $piece['prixOriginal'] }} FCFA</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-shopping-cart me-2 text-muted"></i> Prix Commercial</span>
                                        <span class="badge bg-success rounded-pill">{{ $piece['prixCommercial'] }} FCFA</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-tools me-2 text-muted"></i> Main d'œuvre</span>
                                        <span class="badge bg-info rounded-pill">{{ $piece['prix_main_oeuvre'] }} FCFA</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-info-circle me-1"></i> Détails
                                </button>
                                <button class="btn btn-primary btn-sm float-end">
                                    <i class="fas fa-cart-plus me-1"></i> Commander
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 p-3 bg-light rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Récapitulatif
                    </h5>
                    <div>
                        <span class="fw-bold">Total estimé :</span>
                        <span class="h5 text-primary ms-2">XXX FCFA</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button class="btn btn-outline-secondary me-2">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button>
                <button class="btn btn-success">
                    <i class="fas fa-paper-plane me-1"></i> Envoyer au client
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .badge {
        font-size: 0.9em;
    }
</style>
@endsection
