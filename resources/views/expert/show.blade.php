
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Demande #{{ $demande->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #000000;
            --primary-dark: #d3d3dc;
            --primary-light: #8b5cf6;
            --secondary: #06b6d4;
            --success: #10b981;
            --info: #3b82f6;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray: #64748b;
            --light-gray: #f1f5f9;
            --border: #e2e8f0;
            --gradient: linear-gradient(135deg, #a1c4d8 0%, #619bc8 100%);
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
        }

        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient);
            opacity: 0.6;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            padding: 1.5rem 2rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 24px 24px 0 0 !important;
        }

        .card-header i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient);
        }

        .info-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-box-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
            margin-bottom: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-box-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-box-value i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .status-badge {
            padding: 0.6rem 1.2rem;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .status-badge:hover::before {
            left: 100%;
        }

        .status-badge i {
            margin-right: 5px;
            font-size: 0.8em;
        }

        .status-Non_assigné {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .status-Assignée_now {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
        }
        .status-en_attente {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        .status-en_cours {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        .status-termine {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        .status-annule {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-submit {
            background: var(--gradient);
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
.btn-download-rapport {
            background: linear-gradient(135deg, #5881b1, #5881b1);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1.2rem;
            margin-left: 10px;
            margin-bottom: 50px;
        }

        .btn-download-rapport:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            color: white;
        }

        .btn-download-rapport i {
            margin-right: 8px;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            background: var(--primary-dark);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            margin-right: 8px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.15);
            background: white;
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .list-group-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px !important;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .list-group-item i {
            margin-right: 12px;
            color: var(--primary);
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            font-size: 1.5rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--gradient);
            border-radius: 3px;
        }

        .technician-select-container {
            margin-bottom: 15px;
        }

        .technician-select-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }

        .btn-primary {
            background: var(--gradient);
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
            background: var(--primary-dark);
        }

        .btn-success {
            background: linear-gradient(135deg, #1f8261, #1f8261);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .btn-outline-success {
            background: linear-gradient(135deg, #a78bfa, #8b5cf6);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(167, 139, 250, 0.4);
            color: white;
        }

        .text-danger {
            color: var(--danger) !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .small {
            font-size: 0.875em;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }

        .shadow-sm {
            box-shadow: var(--shadow) !important;
        }

        .bg-primary {
            background: var(--gradient) !important;
        }

        .text-white {
            color: white !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .text-secondary {
            color: var(--gray) !important;
        }

        .badge {
            border-radius: 50px;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .bg-secondary {
            background: var(--gray) !important;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .info-box {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarExpert')

    <div class="container py-4" >
        <div class="page-header" style="margin-top: 60px">
            <h1 class="page-title" >
                <i class="fas fa-clipboard-list"></i>
                Détails de la demande
            </h1>
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('expert.demande_maintenance') }}" class="text-decoration-none">Demandes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $demande->id }}</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i>
                        <h6 class="m-0 font-weight-bold">Informations principales</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">
                                        <i class="fas fa-user"></i>
                                        Client
                                    </div>
                                    <div class="info-box-value">
                                        <i class="fas fa-user"></i>
                                        {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">
                                        <i class="fas fa-phone"></i>
                                        Téléphone
                                    </div>
                                    <div class="info-box-value">
                                        <i class="fas fa-phone"></i>
                                        {{ $demande->client->phone }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">
                                        <i class="fas fa-car"></i>
                                        Véhicule
                                    </div>
                                    <div class="info-box-value">
                                        <i class="fas fa-car"></i>
                                        {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">
                                        <i class="fas fa-flag"></i>
                                        Statut
                                    </div>
                                    <div class="info-box-value">
                                        <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                            <i class="fas fa-circle"></i>
                                            {{ str_replace('_', ' ', $demande->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">
                                        <i class="fas fa-tools"></i>
                                        Service
                                    </div>
                                    <div class="info-box-value">
                                        <i class="fas fa-tools"></i>
                                        {{ $demande->servicePanne->titre }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">
                                        <i class="fas fa-list-alt"></i>
                                        Catégorie
                                    </div>
                                    <div class="info-box-value">
                                        <i class="fas fa-list-alt"></i>
                                        {{ $demande->servicePanne->categoryPane->titre }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-euro-sign"></i>
                        <h6 class="m-0 font-weight-bold">Proposition de prix</h6>
                    </div>
                    <div class="card-body">
                        <form id="prixForm" action="{{ route('demandes.ajouterPrixMainOeuvre', $demande->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="prix_main_oeuvre" class="form-label info-box-title">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    Prix main d'œuvre (€)
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control"
                                       id="prix_main_oeuvre" name="prix_main_oeuvre"
                                       value="{{ old('prix_main_oeuvre', $demande->prix_main_oeuvre) }}"
                                       @if($demande->status !== 'Nouvelle_demande') disabled @endif
                                       required>
                                @error('prix_main_oeuvre')
                                    <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($demande->status === 'Nouvelle_demande')
                            <button type="submit" class="btn btn-submit w-100 pulse-animation">
                                <i class="fas fa-paper-plane"></i>Envoyer l'offre
                            </button>
                            @endif
                        </form>
                    </div>
                </div>

@if($demande->techniciens && count($demande->techniciens) > 0)
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-users-cog" style="color: white"></i>
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
                        <div class="fw-bold">
                            <i class="fas fa-user-tie text-secondary me-2"></i>{{ $tech['nom'] }}
                        </div>
                       @if($demandeFlux && $flux && $flux->lien_meet)
    @if($demandeFlux->permission)
        <button class="btn btn-sm btn-success mt-2" disabled>
            <i class="fas fa-check-circle me-1" style="color: white"></i> Partage autorisé
        </button>
    @else
        <button class="btn btn-sm btn-outline-success mt-2 share-btn"
                data-flux-id="{{ $demandeFlux->id }}">
            <i class="fas fa-share-square me-1"></i> Autoriser le partage
        </button>
    @endif
@endif    </div>

                    <div>
                        @if($flux && $flux->lien_meet)
                            <a href="{{ $flux->lien_meet }}" target="_blank" class="btn btn-sm btn-primary" style="margin-top: 30px">
                                <i class="fas fa-video me-1" style="color: rgb(255, 255, 255)"></i> Meet
                            </a>
                        @else
                            <span class="badge bg-secondary">Aucun lien disponible</span>
                        @endif

                    </div>

                </li>
            @endforeach
        </ul>
         @if($demande && $demande->rapport)
                                <a href="{{ route('rapport.download', $demande->rapport->id) }}"
                                   class="btn btn-download-rapport btn-sm"
                                   download
                                   title="Télécharger le rapport">
                                    <i class="fas fa-file-pdf" style="color:white"></i> <b style="color: white">Voir rapport</b>
                                </a>
                            @endif
    </div>
</div>
@endif

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-box"></i>
                        <h6 class="m-0 font-weight-bold">Pack</h6>
                    </div>
                    <div class="card-body">
                        <div class="info-box-value">
                            <i class="fas fa-tag"></i>
                            {{ $demande->forfait->nomForfait }}
                        </div>
                    </div>
                </div>

                @if($demande->status === 'offre_acceptee')
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
            </div>
        </div>
    </div>
    <script>
    // Gestion du partage avec le client
document.querySelectorAll('.share-btn').forEach(button => {
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
                fetch(`/demande-flux/permission/${fluxId}`, {
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
                        this.classList.replace('btn-outline-success', 'btn-success');
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
</script>
<script>
    // Gestion de l'ouverture du flux direct
    document.querySelectorAll('.open-flux').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const demandeId = this.getAttribute('data-demande-id');
            const technicienId = this.getAttribute('data-technicien-id');

            // Appel API pour créer/obtenir le flux direct
            fetch(`/api/flux-direct/${demandeId}/${technicienId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Ouvrir le flux dans une nouvelle fenêtre ou un modal
                    window.open(`/flux-direct/${data.flux.id}`, '_blank');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message || 'Impossible d\'ouvrir le flux',
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
    });
</script>
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

        fetch("{{ route('demandes.updateTechniciens', $demande->id) }}", {
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
    document.getElementById('prixForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: "L'offre a été envoyée, en attente d'acceptation du client.",
                    confirmButtonColor: 'var(--primary)',
                }).then(() => {
                    // Optional: Reload or redirect if needed
                    // window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: "L'offre a été envoyée, en attente d'acceptation du client.",
                    confirmButtonColor: 'var(--primary)',
                })
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: "L'offre a été envoyée, en attente d'acceptation du client.",
                confirmButtonColor: 'var(--primary)',
            })
        });
    });
</script>
</body>
</html>
