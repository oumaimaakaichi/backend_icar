<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Demande | GaragePro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3f37c9;
            --accent: #f72585;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #f1f3f5;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1e293b;
            line-height: 1.6;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            transform: translateY(-2px);
        }

        .header-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.75rem;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .badge-pill {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 500;
            color: var(--dark);
        }

        .divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.08);
            margin: 1.5rem 0;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
        }

        .btn-outline-modern {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-modern:hover {
            background: var(--primary-light);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .status-new {
            background-color: #e6f7ff;
            color: #1890ff;
        }

        .status-assigned {
            background-color: #fff7e6;
            color: #fa8c16;
        }

        .status-completed {
            background-color: #f6ffed;
            color: #52c41a;
        }

        .floating-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .floating-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 4px;
            background: var(--primary);
            border-radius: 4px;
        }

        .problem-description {
            background-color: var(--light-gray);
            border-radius: 12px;
            padding: 1.5rem;
            white-space: pre-line;
        }

        /* Styles ajoutés pour les techniciens et Meet */
        .technician-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .technician-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .technician-name {
            font-weight: 600;
            color: var(--dark);
        }

        .meet-btn {
            background: linear-gradient(135deg, #4285F4, #34A853);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .meet-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(66, 133, 244, 0.3);
            color: white;
        }

        .share-btn {
            background: linear-gradient(135deg, #8B5CF6, #6366F1);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .share-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(139, 92, 246, 0.3);
            color: white;
        }

        .share-btn.disabled {
            background: linear-gradient(135deg, #10B981, #059669);
            opacity: 1;
        }

        @media (max-width: 768px) {
            .avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .floating-btn {
                width: 48px;
                height: 48px;
                bottom: 1rem;
                right: 1rem;
            }
            /* Vous pouvez conserver ces styles */
.meet-btn {
    background: linear-gradient(135deg, #4285F4, #34A853);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.meet-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(66, 133, 244, 0.3);
    color: white;
}

.share-btn {
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.share-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(139, 92, 246, 0.3);
    color: white;
}

.share-btn.disabled {
    background: linear-gradient(135deg, #10B981, #059669);
    opacity: 1;
}
        }
    </style>
</head>
<body>

@include('Sidebar.sidebarExpert')

<div class="container py-4" style="margin-top: 60px">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Détails de la Demande</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('expert.demande_maintenanceInconnu') }}" class="text-decoration-none">Demandes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $demande->id }}</li>
                </ol>
            </nav>
        </div>
        <span class="status-badge status-new">
            <i class="fas fa-circle me-2" style="font-size: 8px;"></i>
            {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
        </span>
    </div>

    <div class="row">
        <!-- Client & Vehicle Info -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-4 h-100">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-3">
                        {{ substr($demande->client->prenom, 0, 1) }}{{ substr($demande->client->nom, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $demande->client->prenom }} {{ $demande->client->nom }}</h5>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="info-label">Contact</div>
                    <div class="info-value">
                        <a href="tel:{{ $demande->client->phone }}" class="text-decoration-none d-block mb-1">
                            <i class="fas fa-phone me-2"></i>{{ $demande->client->phone }}
                        </a>
                        <a href="mailto:{{ $demande->client->email }}" class="text-decoration-none d-block">
                            <i class="fas fa-envelope me-2"></i>{{ $demande->client->email }}
                        </a>
                    </div>
                </div>

                <div class="divider"></div>

                <h6 class="section-title mb-3">Véhicule</h6>

                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="info-label">Modèle</div>
                        <div class="info-value">{{ $demande->voiture->model }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="info-label">Série</div>
                        <div class="info-value">{{ $demande->voiture->serie ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Année</div>
                        <div class="info-value">{{ $demande->voiture->date_fabrication ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Couleur</div>
                        <div class="info-value">{{ $demande->voiture->couleur ?? '-' }}</div>
                    </div>
                </div>
                 <div class="divider"></div>
                <div class="glass-card p-4 mb-4">
                <h6 class="section-title">Description du problème</h6>
                <div class="problem-description">
                    {{ $demande->description_probleme }}
                </div>
            </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8 mb-4">


            <!-- Details Card -->
            <div class="glass-card p-4 mb-4">
                <h6 class="section-title">Détails de la demande</h6>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <div class="info-label">Type d'emplacement</div>
                        <div class="info-value">
                            <span class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-{{ $demande->type_emplacement == 'À domicile' ? 'home' : 'wrench' }} me-1"></i>
                                {{ $demande->type_emplacement }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">Date de maintenance</div>
                        <div class="info-value">
                            @if($demande->date_maintenance)
                                {{ \Carbon\Carbon::parse($demande->date_maintenance)->format('d/m/Y') }}
                                @if($demande->heure_maintenance)
                                    à {{ \Carbon\Carbon::parse($demande->heure_maintenance)->format('H:i') }}
                                @endif
                            @else
                                <span class="text-muted">À planifier</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-label">Date de création</div>
                        <div class="info-value">
                            {{ $demande->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Techniciens Assignés -->
  @if($demande->status === 'Nouvelle_demande')
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-plus"></i>
                        <h6 class="m-0 font-weight-bold">Assigner des techniciens</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre_techniciens" class="info-box-title">Nombre de techniciens</label>
                            <input type="number" min="1" max="{{ $techniciens->count() }}" class="form-control" id="nombre_techniciens" value="1">
                        </div>

                        <form id="assignTechniciensForm">
                            <div id="techniciens_select_container">
                                <div class="technician-select-container">
                                    <label>Technicien 1</label>
                                    <select class="form-select" name="techniciens[]" required>
                                        <option value="" disabled selected>Sélectionner un technicien</option>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit w-100 mt-3">
                                <i class="fas fa-user-plus"></i>Assigner
                            </button>
                        </form>
                    </div>
                </div>
@endif




<!-- Liste des pièces choisies -->
@if($demande->pieces_choisies )
    @php
        // Si vous n'utilisez pas la relation, utilisez la variable $catalogues passée depuis le contrôleur
        $catalogues = isset($catalogues) ? $catalogues : $demande->catalogues;
    @endphp

    <div class="glass-card p-4 mt-4">
        <h6 class="section-title">Pièces sélectionnées</h6>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pièce</th>
                        <th>Référence</th>
                        <th>Type véhicule</th>
<th>Action</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($catalogues as $catalogue)
        <tr>
            <td>{{ $catalogue->nom_piece }}</td>
            <td>{{ $catalogue->num_piece }}</td>
            <td>{{ $catalogue->type_voiture }}</td>
            <td>
            @if(isset($demande->main_oeuvre_pieces[$catalogue->id]))
                {{ number_format($demande->main_oeuvre_pieces[$catalogue->id], 2) }} DH
            @endif
            <button class="btn btn-sm btn-outline-primary add-main-oeuvre ms-2"
                    data-piece-id="{{ $catalogue->id }}"
                    data-piece-name="{{ $catalogue->nom_piece }}"
                    data-bs-toggle="modal"
                    data-bs-target="#mainOeuvreModal">
                <i class="fas fa-{{ isset($demande->main_oeuvre_pieces[$catalogue->id]) ? 'edit' : 'plus' }}"></i>
            </button>
        </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>
@else
    <div class="glass-card p-4 mt-4">
        <div class="alert alert-info">
            Aucune pièce sélectionnée pour cette demande.
        </div>
    </div>
@endif
 @if($demande && $demande->rapport)
                                <a href="{{ route('rapportt.downloadd', $demande->rapport->id) }}"
                                   class="btn btn-download-rapport btn-sm"
                                   download
                                   title="Télécharger le rapport">
                                    <i class="fas fa-file-pdf" style="color:black"></i> <b style="color: rgb(0, 0, 0)">Voir rapport</b>
                                </a>
                            @endif
@if($demande->techniciens && count($demande->techniciens) > 0)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fas fa-users-cog me-2"></i>
            <h6 class="m-0 font-weight-bold">Techniciens assignés</h6>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @foreach($demande->techniciens as $tech)
                    @php
                        $flux = App\Models\FluxDirect::where('demande_id', $demande->id)
                                    ->where('technicien_id', $tech['id'])
                                    ->first();
                        $demandeFlux = $flux ? $flux->demandeFlux : null;
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold mb-1">
                           <i class="fas fa-user-tie text-secondary me-2"></i>{{ $flux && $flux->techniciens ? $flux->techniciens->nom : $tech['nom'] }}

                            </div>

                            @if($demandeFlux && $flux && $flux->lien_meet)
                                @if($demandeFlux->permission)
                                    <button class="btn btn-sm btn-success mt-2" disabled>
                                        <i class="fas fa-check-circle me-1 text-white"></i> Partage autorisé
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-success mt-2 share-btn"
                                            data-flux-id="{{ $demandeFlux->id }}">
                                        <i class="fas fa-share-square me-1"></i> Autoriser le partage
                                    </button>
                                @endif
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif



  @if($demande->techniciens && count($demande->techniciens) > 0)        <!-- Lien Meet -->
<div class="glass-card p-4">
    <h6 class="section-title">Visioconférence d'examination</h6>

    @php
        $flux = \App\Models\FluxDirectInconnuPanne::where('demande_id', $demande->id)
    ->where('type_meet', 'Examination')
    ->first();
   $demandeFlux = $flux ? $flux->demandeFlux : null;
    @endphp

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-video me-2"></i> Lien de visioconférence de
             <b style="color: #059669">{{ $flux && $flux->techniciens ? $flux->techniciens->nom : $tech['nom'] }}</b>

        </div>
        <div class="d-flex gap-2">
            @if($flux && $flux->lien_meet )
            @if($demandeFlux)
                @if( $demandeFlux->permission)
                    <button class="share-btn disabled" disabled>
                        <i class="fas fa-check-circle me-1"></i> Partage autorisé
                    </button>
                @else
                    <button class="share-btn share-btn-action" data-flux-id="{{ $demandeFlux->id }}">
                        <i class="fas fa-share-square me-1"></i> Autoriser le partage
                    </button>
                @endif
              @else
              <span >Aucun demande de partage</span>

              @endif
@if($flux && $flux->ouvert )
                <a href="{{ $flux->lien_meet }}" target="_blank" class="meet-btn">
                    <i class="fas fa-video me-1"></i> Rejoindre Meet
                </a>
 @else
                <span class="badge bg-secondary">Vidéoconférence fermé</span>
            @endif
            @else
                <span class="badge bg-secondary">Aucun lien disponible</span>
            @endif
        </div>
    </div>
</div>


@endif
        </div>
    </div>




 @if ($demande->pieces_selectionnees)
    <div class="glass-card p-4">
        <h6 class="section-title">Visioconférence d'entretien</h6>
         @php
       $flux = \App\Models\FluxDirectInconnuPanne::where('demande_id', $demande->id)
    ->where('type_meet', 'Entretient')
    ->first();
  $demandeFlux = $flux ? $flux->demandeFlux : null;
    @endphp
        <div class="d-flex gap-2">

            @if ($flux && $flux->lien_meet )

                @if ($demandeFlux)
                    @if ($demandeFlux->permission)
                        <button class="share-btn disabled" disabled>
                            <i class="fas fa-check-circle me-1"></i> Partage autorisé
                        </button>
                    @else
                        <button class="share-btn share-btn-action" data-flux-id="{{ $demandeFlux->id }}">
                            <i class="fas fa-share-square me-1"></i> Autoriser le partage
                        </button>
                    @endif
                @else
                    <span>Aucune demande de partage</span>
                @endif

                @if ($flux->ouvert)
                    <a href="{{ $flux->lien_meet }}" target="_blank" class="meet-btn">
                        <i class="fas fa-video me-1"></i> Rejoindre Meet
                    </a>
                @else
                    <span class="badge bg-secondary">Vidéoconférence fermée</span>
                @endif

            @else
                <span class="badge bg-secondary">Aucun lien disponible</span>
            @endif

        </div>
    </div>
@endif

</div>

<!-- Floating Action Button -->
<a href="{{ route('expert.demandes') }}" class="floating-btn bg-primary text-white">
    <i class="fas fa-arrow-left"></i>
</a>
<!-- Modal pour ajouter le prix main d'œuvre -->
<div class="modal fade" id="mainOeuvreModal" tabindex="-1" aria-labelledby="mainOeuvreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mainOeuvreModalLabel">Ajouter prix main d'œuvre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="mainOeuvreForm">
                    <input type="hidden" id="pieceId" name="piece_id">
                    <div class="mb-3">
                        <label for="pieceName" class="form-label">Pièce</label>
                        <input type="text" class="form-control" id="pieceName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="prixMainOeuvre" class="form-label">Prix main d'œuvre (DH)</label>
                        <input type="number" step="0.01" class="form-control" id="prixMainOeuvre" name="prix" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="saveMainOeuvre">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const nombreInput = document.getElementById('nombre_techniciens');
    const container = document.getElementById('techniciens_select_container');
    const techniciens = @json($techniciens);

    function createSelect(index) {
        const div = document.createElement('div');
        div.classList.add('technician-select-container');

        const label = document.createElement('label');
        label.textContent = `Technicien ${index + 1}`;

        const select = document.createElement('select');
        select.classList.add('form-select');
        select.name = 'techniciens[]';
        select.required = true;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Sélectionner un technicien';
        select.appendChild(defaultOption);

        techniciens.forEach(t => {
            const option = document.createElement('option');
            option.value = t.id;
            option.textContent = (t.prenom ?? '') + ' ' + (t.nom ?? t.name);
            select.appendChild(option);
        });

        div.appendChild(label);
        div.appendChild(select);

        return div;
    }

    nombreInput.addEventListener('input', () => {
        let count = parseInt(nombreInput.value) || 1;
        if(count < 1) count = 1;
        if(count > techniciens.length) count = techniciens.length;

        container.innerHTML = '';
        for(let i = 0; i < count; i++) {
            container.appendChild(createSelect(i));
        }
    });

    document.getElementById('assignTechniciensForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const selects = this.querySelectorAll('select[name="techniciens[]"]');
        const techniciensData = Array.from(selects).map(select => {
            return {
                id_technicien: parseInt(select.value),
                nom: select.options[select.selectedIndex].text
            };
        });

        fetch("{{ route('demandes.updateTechniciensInconnu', $demande->id) }}", {
            method: 'put',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ techniciens: techniciensData }),
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message,
                    confirmButtonColor: 'var(--primary)',
                }).then(() => window.location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: data.message || 'Une erreur est survenue',
                    confirmButtonColor: 'var(--primary)',
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Erreur réseau',
                confirmButtonColor: 'var(--primary)',
            });
        });
    });
</script>
<script>
    // Enhanced copy function with modern toast notification
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 start-50 translate-middle-x mb-3';
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-body bg-success text-white rounded-pill px-4 py-2">
                        <i class="fas fa-check-circle me-2"></i>Numéro copié !
                    </div>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        });
    }

    // Dynamic status badge colors
    document.addEventListener('DOMContentLoaded', function() {
        const status = "{{ $demande->status }}";
        const statusBadge = document.querySelector('.status-badge');

        if (status === 'Nouvelle_demande') {
            statusBadge.className = 'status-badge status-new';
        } else if (status === 'Assignée') {
            statusBadge.className = 'status-badge status-assigned';
        } else if (status === 'Une_offre_a_été_faite') {
            statusBadge.className = 'status-badge status-completed';
        }

        // Gestion du partage avec le client
        document.querySelectorAll('.share-btn-action').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const fluxId = this.getAttribute('data-flux-id');

                Swal.fire({
                    title: 'Confirmer le partage',
                    text: "Voulez-vous vraiment autoriser le partage de ce lien avec le client?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4361ee',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, partager',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/demande-flux-inconnu/permission/${fluxId}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ permission: true })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire('Succès', 'Le partage a été autorisé', 'success');
                                // Mise à jour du bouton
                                this.classList.replace('share-btn', 'share-btn', 'disabled');
                                this.innerHTML = '<i class="fas fa-check-circle me-1"></i> Partage autorisé';
                                this.disabled = true;
                            } else {
                                Swal.fire('Erreur', data.message || "Erreur", 'error');
                            }
                        })
                        .catch(() => Swal.fire('Erreur', 'Erreur réseau', 'error'));
                    }
                });
            });
        });
    });
</script>
<script>
    // Gestion du modal pour ajouter le prix main d'œuvre
document.querySelectorAll('.add-main-oeuvre').forEach(btn => {
    btn.addEventListener('click', function() {
        const pieceId = this.getAttribute('data-piece-id');
        const pieceName = this.getAttribute('data-piece-name');

        document.getElementById('pieceId').value = pieceId;
        document.getElementById('pieceName').value = pieceName;
        document.getElementById('prixMainOeuvre').value = '';
    });
});

// Sauvegarde du prix
document.getElementById('saveMainOeuvre').addEventListener('click', function() {
    const pieceId = document.getElementById('pieceId').value;
    const prix = document.getElementById('prixMainOeuvre').value;
    const demandeId = {{ $demande->id }};

    if (!prix) {
        Swal.fire('Erreur', 'Veuillez entrer un prix', 'error');
        return;
    }

    fetch(`/api/demandes-panne-inconnue/${demandeId}/main-oeuvre`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            piece_id: pieceId,
            prix: prix
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Succès', data.message, 'success').then(() => {
                $('#mainOeuvreModal').modal('hide');
                window.location.reload();
            });
        } else {
            Swal.fire('Erreur', data.message || 'Une erreur est survenue', 'error');
        }
    })
    .catch(error => {
        Swal.fire('Erreur', 'Erreur réseau', 'error');
    });
});
</script>
</body>
</html>
