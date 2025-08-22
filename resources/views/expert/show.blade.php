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
            --primary: #4361ee;
            --primary-dark: #3c56dd;
            --primary-light: #5d75f2;
            --secondary: #64748b;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --border-radius: 16px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, rgb(252, 253, 253) 0%, rgb(252, 253, 253) 50%, rgb(252, 253, 253) 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--gray-900);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            padding-top: 2rem;
        }

        /* Header moderne avec glassmorphism */
        .page-header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(131, 129, 129, 0.2);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .page-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: rgb(104, 101, 101);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 50px;
            margin-top: 30px
        }

        .page-title i {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            margin: 0;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: white;
        }

        .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }

        /* Cards modernes */
        .modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--info), var(--success));
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .card-header-modern {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border: none;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .card-title i {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        .card-body-modern {
            padding: 2rem;
        }

        /* Info boxes modernisées */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--info));
            transition: width 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: var(--primary-light);
        }

        .info-item:hover::before {
            width: 8px;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-label i {
            color: var(--primary);
        }

        .info-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Status badges modernisés */
        .status-badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .status-badge-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .status-badge-modern:hover::before {
            left: 100%;
        }

        .status-Non_assigné {
            background: linear-gradient(135deg, var(--gray-500), var(--gray-600));
            color: white;
        }
        .status-Assignée_now {
            background: linear-gradient(135deg, var(--secondary), #475569);
            color: white;
        }
        .status-Nouvelle_demande {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }
        .status-en_attente {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }
        .status-offre_acceptee {
            background: linear-gradient(135deg, var(--success), #16a34a);
            color: white;
        }
        .status-en_cours {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }
        .status-termine {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
        }
        .status-annule {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
        }

        /* Buttons modernisés */
        .btn-modern {
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, var(--success), #16a34a);
            color: rgb(255, 255, 255);
        }

        .btn-success-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-info-modern {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }

        .btn-info-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.3);
            color: white;
        }

        .btn-download-rapport {
            background: linear-gradient(135deg, #5881b1, #4e7ba8);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            margin-top: 1rem;
            gap: 0.5rem;
        }

        .btn-download-rapport:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(88, 129, 177, 0.3);
            color: white;
        }

        /* Forms modernisés */
        .form-control-modern {
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: white;
            transition: all 0.3s ease;
        }

        .form-control-modern:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        .form-label-modern {
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Technicians list */
        .technician-item {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .technician-item:hover {
            transform: translateX(8px);
            box-shadow: var(--shadow);
            border-color: var(--primary-light);
        }

        .technician-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .technician-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.125rem;
        }

        .technician-details h6 {
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
        }

        .technician-details p {
            font-size: 0.875rem;
            color: var(--gray-500);
            margin: 0;
        }

        .badge {
            border-radius: 50px;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .bg-secondary {
            background: var(--gray-500) !important;
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

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.6s ease-out;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
            animation-fill-mode: both;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
            animation-fill-mode: both;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
            animation-fill-mode: both;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .page-header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .page-title {
                font-size: 2rem;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .card-body-modern {
                padding: 1.5rem;
            }

            .technician-item {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .technician-info {
                justify-content: center;
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(67, 97, 238, 0); }
            100% { box-shadow: 0 0 0 0 rgba(67, 97, 238, 0); }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarExpert')

  <div class="container animate-slide-up" style="margin-top: 60px ; margin-right:50px">
    <!-- Modern Header -->

        <div class="page-header-content">
            <h3 class="page-title">
                <i class="fas fa-clipboard-list"></i>
                Request Details
            </h3>

<br/>
    </div>

    <div class="row">
        <!-- Main Column -->
        <div class="col-lg-8">
            <!-- Main Information -->
            <div class="modern-card animate-slide-up animate-delay-1">
                <div class="card-header-modern">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Main Information
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                Client
                            </div>
                            <div class="info-value">
                                <div class="technician-avatar">
                                    {{ substr($demande->client->prenom, 0, 1) }}{{ substr($demande->client->nom, 0, 1) }}
                                </div>
                                {{ $demande->client->prenom }} {{ $demande->client->nom }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-phone"></i>
                                Phone
                            </div>
                            <div class="info-value">
                                <i class="fas fa-phone text-success"></i>
                                {{ $demande->client->phone }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-car"></i>
                                Vehicle
                            </div>
                            <div class="info-value">
                                <i class="fas fa-car text-primary"></i>
                                {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-flag"></i>
                                Status
                            </div>
                            <div class="info-value">
                                <span class="status-badge-modern status-{{ str_replace(' ', '_', $demande->status) }}">
                                    <i class="fas fa-circle"></i>
                                    {{ str_replace('_', ' ', $demande->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-tools"></i>
                                Service
                            </div>
                            <div class="info-value">
                                <i class="fas fa-wrench text-warning"></i>
                                {{ $demande->servicePanne->titre }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-list-alt"></i>
                                Category
                            </div>
                            <div class="info-value">
                                <i class="fas fa-tags text-info"></i>
                                {{ $demande->servicePanne->categoryPane->titre }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Technicians -->
            @if($demande->techniciens && count($demande->techniciens) > 0)
            <div class="modern-card animate-slide-up animate-delay-2">
                <div class="card-header-modern">
                    <h5 class="card-title">
                        <i class="fas fa-users-cog"></i>
                        Assigned Technicians
                    </h5>
                </div>
                <div class="card-body-modern">
                    @foreach($demande->techniciens as $tech)
                    @php
                        $flux = App\Models\FluxDirect::where('demande_id', $demande->id)
                                                    ->where('technicien_id', $tech['id'])
                                                    ->first();
                        $demandeFlux = $flux ? $flux->demandeFlux : null;
                    @endphp
                    <div class="technician-item">
                        <div class="technician-info">
                            <div class="technician-avatar">
                                {{ substr($tech['nom'], 0, 2) }}
                            </div>
                            <div class="technician-details">
                                <h6>{{ $tech['nom'] }}</h6>
                                <p>Specialized Technician</p>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            @if($demandeFlux && $flux && $flux->lien_meet)
                                @if($demandeFlux->permission)
                                    <button class="btn btn-success-modern btn-modern" disabled>
                                        <i class="fas fa-check-circle" style="color: white"></i>
                                        <b style="color: white">Sharing Allowed</b>
                                    </button>
                                @else
                                    <button class="btn btn-primary-modern btn-modern share-btn"
                                            data-flux-id="{{ $demandeFlux->id }}">
                                        <i class="fas fa-share-square"></i>
                                        Allow Sharing
                                    </button>
                                @endif
                            @endif

                            @if($flux && $flux->ouvert)
                                @if($flux && $flux->lien_meet)
                                    <a href="{{ $flux->lien_meet }}" target="_blank" class="btn btn-info-modern btn-modern">
                                        <i class="fas fa-video"></i>
                                        Meet
                                    </a>
                                @else
                                    <span class="badge bg-secondary">No link available</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Video Conference Closed</span>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    @if($demande && $demande->rapport)
                        <div class="text-center">
                            <a href="{{ route('rapport.download', $demande->rapport->id) }}"
                               class="btn btn-download-rapport"
                               download
                               title="Download Report">
                                <i class="fas fa-file-pdf" style="color: white"></i>
                                <b style="color: white"> View Report</b>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Price Proposal -->
            <div class="modern-card animate-slide-up animate-delay-1">
                <div class="card-header-modern">
                    <h5 class="card-title">
                        <i class="fas fa-euro-sign"></i>
                        Price Proposal
                    </h5>
                </div>
                <div class="card-body-modern">
                    <form id="prixForm" action="{{ route('demandes.ajouterPrixMainOeuvre', $demande->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="prix_main_oeuvre" class="form-label-modern">
                                <i class="fas fa-hand-holding-usd me-1"></i>
                                Labor Price (€)
                            </label>
                            <input type="number" step="0.01" min="0" class="form-control form-control-modern"
                                   id="prix_main_oeuvre" name="prix_main_oeuvre"
                                   value="{{ old('prix_main_oeuvre', $demande->prix_main_oeuvre) }}"
                                   @if($demande->status !== 'Nouvelle_demande') disabled @endif
                                   required>
                            @error('prix_main_oeuvre')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($demande->status === 'Nouvelle_demande')
                        <button type="submit" class="btn btn-primary-modern btn-modern w-100 pulse-animation">
                            <i class="fas fa-paper-plane" style="color: white"></i>
                            <b style="color: white"> Send Offer</b>
                        </button>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Package -->
            <div class="modern-card animate-slide-up animate-delay-2">
                <div class="card-header-modern">
                    <h5 class="card-title">
                        <i class="fas fa-box"></i>
                        Package
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="info-value">
                        <i class="fas fa-tag text-success"></i>
                        {{ $demande->forfait->nomForfait }}
                    </div>
                </div>
            </div>

            <!-- Assign Technicians -->
            @if($demande->status === 'offre_acceptee')
            <div class="modern-card animate-slide-up animate-delay-3">
                <div class="card-header-modern">
                    <h5 class="card-title">
                        <i class="fas fa-user-plus"></i>
                        Assign Technicians
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="mb-3">
                        <label for="nombre_techniciens" class="form-label-modern">Number of Technicians</label>
                        <input type="number" min="1" max="{{ $techniciens->count() }}" class="form-control form-control-modern"
                               id="nombre_techniciens" value="1">
                    </div>
                    <form id="assignTechniciensForm">
                        <div id="techniciens_select_container">
                            <div class="technician-select-container">
                                <label class="form-label-modern">Technician 1</label>
                                <select class="form-control form-control-modern" name="techniciens[]" required>
                                    <option value="" disabled selected>Select a Technician</option>
                                    @foreach($techniciens as $tech)
                                        <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success-modern btn-modern w-100 mt-3">
                            <i class="fas fa-user-plus" style="color: white"></i>
                            <b style="color: white">Assign</b>
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation d'entrée progressive
        const cards = document.querySelectorAll('.modern-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

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
                                this.classList.replace('btn-primary-modern', 'btn-success-modern');
                                this.innerHTML = '<i class="fas fa-check-circle"></i> Partage autorisé';
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

        // Gestion du nombre de techniciens
        const nombreInput = document.getElementById('nombre_techniciens');
        const container = document.getElementById('techniciens_select_container');
        const techniciens = @json($techniciens ?? []);

        if (nombreInput && container) {
            function createSelect(index) {
                const div = document.createElement('div');
                div.classList.add('technician-select-container');

                const label = document.createElement('label');
                label.classList.add('form-label-modern');
                label.textContent = `Technicien ${index + 1}`;

                const select = document.createElement('select');
                select.classList.add('form-control', 'form-control-modern');
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
        }

        // Gestion de l'assignation des techniciens
        const assignForm = document.getElementById('assignTechniciensForm');
        if (assignForm) {
            assignForm.addEventListener('submit', function(e) {
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
                            confirmButtonColor: '#4361ee',
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: data.message || 'Une erreur est survenue',
                            confirmButtonColor: '#4361ee',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Erreur réseau',
                        confirmButtonColor: '#4361ee',
                    });
                });
            });
        }

        // Gestion du formulaire de prix
        const prixForm = document.getElementById('prixForm');
        if (prixForm) {
            prixForm.addEventListener('submit', function(e) {
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
                            confirmButtonColor: '#4361ee',
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès!',
                            text: "L'offre a été envoyée, en attente d'acceptation du client.",
                            confirmButtonColor: '#4361ee',
                        })
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: "L'offre a été envoyée, en attente d'acceptation du client.",
                        confirmButtonColor: '#4361ee',
                    })
                });
            });
        }

        // Effets de survol pour les cartes
        document.querySelectorAll('.modern-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Animation des info-items
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = Math.random() * 0.3 + 's';
                    entry.target.classList.add('animate-slide-up');
                }
            });
        });

        document.querySelectorAll('.info-item').forEach(item => {
            observer.observe(item);
        });
    </script>
</body>
</html>
