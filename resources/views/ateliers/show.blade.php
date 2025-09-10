<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details #{{ $demande->id }}</title>
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
            background: linear-gradient(135deg, white 0%, white 50%, white 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--gray-900);
            line-height: 1.6;
        }

        .container-fluid {
            max-width: 1400px;
            padding-top: 2rem;
        }

        /* Header Section */
        .page-header {
            background: rgba(223, 222, 222, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(97, 95, 95, 0.2);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
            margin-top: 20px
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
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #000000;
            text-shadow: 0 2px 4px rgba(67, 66, 66, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .page-title i {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
        }

        .page-subtitle {
            color: rgba(123, 122, 122, 0.8);
            font-size: 1.125rem;
            font-weight: 500;
        }

        /* Modern Cards */
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

        /* Info Grid */
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

        /* Status Badges */
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

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(135deg, var(--primary), var(--info));
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.3);
            z-index: 1;
        }

        .timeline-content {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .timeline-date {
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .timeline-text {
            font-size: 1rem;
            color: var(--gray-900);
            font-weight: 500;
        }

        /* Buttons */
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
            color: white;
        }

        .btn-success-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
            color: white;
        }

        .btn-outline-primary-modern {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary-modern:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Forms */
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

        /* Price Input */
        .price-input {
            position: relative;
        }

        .price-input::before {
            content: '€';
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-weight: 700;
            z-index: 1;
        }

        .price-input input {
            padding-left: 2.5rem;
        }

        /* Team List */
        .team-member {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .team-member:hover {
            transform: translateX(8px);
            box-shadow: var(--shadow);
            border-color: var(--primary-light);
        }

        .team-avatar {
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

        .team-info h6 {
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
        }

        .team-info small {
            color: var(--gray-500);
            font-weight: 500;
        }

        /* Table */
        .table-modern {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-modern th {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            border: none;
            color: var(--gray-700);
            font-weight: 600;
            padding: 1rem;
        }

        .table-modern td {
            border: none;
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        /* Alert */
        .alert-modern {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(6, 182, 212, 0.05) 100%);
            border: 1px solid rgba(6, 182, 212, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-modern i {
            color: var(--info);
        }

        /* Badge */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success-modern {
            background: linear-gradient(135deg, var(--success), #16a34a);
            color: white;
        }

        .badge-warning-modern {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .card-body-modern {
                padding: 1.5rem;
            }

            .team-member {
                flex-direction: column;
                text-align: center;
            }
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
    @include('Sidebar.sidebarAtelier')

    <div class="container-fluid animate-slide-up" style="margin-top: 60px">
        <!-- Modern Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h1 class="page-title">
                    <i class="fas fa-clipboard-list"></i>
                    Request Details
                </h1>
                <p class="page-subtitle">Comprehensive overview of maintenance request </p>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Request Information -->
                <div class="modern-card animate-slide-up animate-delay-1">
                    <div class="card-header-modern">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Request Information
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
                                    <div class="team-avatar">
                                        {{ substr($demande->client->prenom, 0, 1) }}{{ substr($demande->client->nom, 0, 1) }}
                                    </div>
                                    {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>
                                    Contact
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
                                    <i class="fas fa-tools"></i>
                                    Requested Service
                                </div>
                                <div class="info-value">
                                    <i class="fas fa-wrench text-warning"></i>
                                    {{ $demande->servicePanne->titre }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-history"></i>
                                Status History
                            </h6>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">Today, 10:30 AM</div>
                                        <div class="timeline-text">Request created</div>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">Today, 11:45 AM</div>
                                        <div class="timeline-text">Awaiting validation</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spare Parts Section -->
                @if($demande->status === 'offre_acceptee' || $demande->status === 'en_cours')
                <div class="modern-card animate-slide-up animate-delay-2">
                    <div class="card-header-modern">
                        <h5 class="card-title">
                            <i class="fas fa-cogs"></i>
                            Required Spare Parts
                        </h5>
                    </div>
                    <div class="card-body-modern">
                        <div class="alert-modern d-flex align-items-center">
                            <i class="fas fa-info-circle me-3 fs-5"></i>
                            <div>The following parts have been identified as necessary for this repair.</div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>Part</th>
                                        <th>Price</th>
                                        <th>Availability</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Clutch Kit</td>
                                        <td><strong>€ 120.00</strong></td>
                                        <td><span class="badge-modern badge-success-modern">In Stock</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-primary-modern btn-modern btn-sm">Order</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Brake Pads</td>
                                        <td><strong>€ 45.00</strong></td>
                                        <td><span class="badge-modern badge-warning-modern">2-3 Days</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-primary-modern btn-modern btn-sm">Order</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Costs & Quote -->


                <!-- Assigned Team -->
                @if($demande->techniciens && count($demande->techniciens) > 0)
                <div class="modern-card animate-slide-up animate-delay-2">
                    <div class="card-header-modern">
                        <h5 class="card-title">
                            <i class="fas fa-users-cog"></i>
                            Assigned Team
                        </h5>
                    </div>
                    <div class="card-body-modern">
                        @foreach($demande->techniciens as $tech)
                        <div class="team-member">
                            <div class="team-avatar">
                                {{ substr($tech['nom'], 0, 2) }}
                            </div>
                            <div class="team-info">
                                <h6>{{ $tech['nom'] }}</h6>
                                <small>ID: {{ $tech['id'] }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Assign Technicians -->
                @if($demande->status === 'Nouvelle_demande')
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
                                <div class="mb-3">
                                    <label class="form-label">Technician 1</label>
                                    <select class="form-select" name="techniciens[]" required>
                                        <option value="" disabled selected>-- Select Technician --</option>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Assign Team
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

        // Gestion du nombre de techniciens
        const nombreInput = document.getElementById('nombre_techniciens');
        const container = document.getElementById('techniciens_select_container');
        const techniciens = @json($techniciens ?? []);

        if (nombreInput && container) {
            function createSelect(index) {
                const div = document.createElement('div');
                div.classList.add('mb-3');

                const label = document.createElement('label');
                label.classList.add('form-label-modern');
                label.textContent = `Technician ${index + 1}`;

                const select = document.createElement('select');
                select.classList.add('form-control', 'form-control-modern');
                select.name = 'techniciens[]';
                select.required = true;

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.textContent = '-- Select Technician --';
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
         console.log("assignForm =", assignForm);
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
console.log("URL API =", "{{ route('demandes.updateTechniciens', $demande->id) }}");

                fetch("{{ route('demandes.updateTechniciens', $demande->id) }}", {
                    method: 'PUT',
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
                            title: 'Success!',
                            text: data.message,
                            confirmButtonColor: '#4361ee',
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'An error occurred',
                            confirmButtonColor: '#4361ee',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to contact the server',
                        confirmButtonColor: '#4361ee',
                    });
                });
            });
        }

        // Gestion du formulaire de prix


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

        document.querySelectorAll('.info-item, .team-member').forEach(item => {
            observer.observe(item);
        });

        // Smooth scroll pour les ancres
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Loading states pour les boutons
        document.querySelectorAll('.btn-modern').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.type === 'submit') {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 3000);
                }
            });
        });

        // Tooltips pour une meilleure UX
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-resize pour les textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });

        // Validation en temps réel pour les formulaires
        document.querySelectorAll('.form-control-modern').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });

        // Shortcuts clavier
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S pour sauvegarder
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                const submitBtn = document.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.click();
                }
            }

            // Escape pour fermer les modals
            if (e.key === 'Escape') {
                const activeModal = document.querySelector('.modal.show');
                if (activeModal) {
                    bootstrap.Modal.getInstance(activeModal).hide();
                }
            }
        });
    </script>
</body>
</html>
