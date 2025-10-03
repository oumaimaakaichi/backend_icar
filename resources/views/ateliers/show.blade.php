<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details #{{ $demande->id }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .container {
            padding: 2rem;
            margin-top: 90px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Header */
        .header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .header-content p {
            color: #718096;
            font-size: 1rem;
        }

        .btn-back {
            background: #e2e8f0;
            color: #4a5568;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e2e8f0;
            padding: 1.5rem;
        }

        .card-header h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header h5 i {
            color: #309ad3;
        }

        .card-body {
            padding: 2rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #309ad3;
        }

        .info-label {
            font-size: 0.75rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            display: inline-block;
        }

        .status-Nouvelle_demande, .status-New {
            background: #F2EFC7;
            color: #5a5520;
        }

        .status-Assignée, .status-Assigned {
            background: #B4DEBD;
            color: #1e5128;
        }

        .status-en_attente {
            background: #fef3c7;
            color: #92400e;
        }

        .status-offre_acceptee {
            background: #d1fae5;
            color: #065f46;
        }

        .status-en_cours {
            background: #dbeafe;
            color: #1e3a8a;
        }

        .status-termine {
            background: #d1fae5;
            color: #14532d;
        }

        .status-annule {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
            margin-top: 1.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
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
            background: #309ad3;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(48, 154, 211, 0.3);
            z-index: 1;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .timeline-date {
            font-size: 0.875rem;
            color: #718096;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .timeline-text {
            font-size: 0.9rem;
            color: #2d3748;
        }

        /* Team Member */
        .team-member {
            background: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .team-member:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #309ad3;
        }

        .team-avatar {
            width: 48px;
            height: 48px;
            background: #309ad3;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.125rem;
        }

        .team-info h6 {
            font-weight: 600;
            color: #2d3748;
            margin: 0;
            font-size: 0.95rem;
        }

        .team-info small {
            color: #718096;
            font-size: 0.85rem;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-select, .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: #309ad3;
            box-shadow: 0 0 0 3px rgba(48, 154, 211, 0.1);
            outline: none;
        }

        /* Buttons */
        .btn-primary-custom {
            background: #309ad3;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            width: 100%;
            justify-content: center;
        }

        .btn-primary-custom:hover {
            background: #2681b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(48, 154, 211, 0.4);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f8f9fa;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.875rem;
        }

        .table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem;
            color: #2d3748;
        }

        .badge-stock {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #B4DEBD;
            color: #1e5128;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-order {
            background: transparent;
            border: 2px solid #309ad3;
            color: #309ad3;
            border-radius: 6px;
            padding: 0.4rem 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .btn-order:hover {
            background: #309ad3;
            color: white;
        }

        /* Alert */
        .alert {
            background: #e0f2fe;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #075985;
        }

        .alert i {
            font-size: 1.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin-top: 70px;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .team-member {
                flex-direction: column;
                text-align: center;
            }

            .card-body {
                padding: 1.5rem;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide {
            animation: slideIn 0.5s ease-out;
        }

        .row {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .col-lg-8 {
            flex: 1 1 65%;
        }

        .col-lg-4 {
            flex: 1 1 30%;
        }

        @media (max-width: 992px) {
            .col-lg-8, .col-lg-4 {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container animate-slide" style="margin-right: 50px">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1>Request Details</h1>
                <p>Comprehensive overview of maintenance request</p>
            </div>
            <a href="{{ route('atelierss.demandes-par-atelier') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Request Information -->
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-info-circle"></i>
                            Request Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user"></i>
                                    Client
                                </div>
                                <div class="info-value">
                                    <div class="team-avatar" style="width: 36px; height: 36px; font-size: 0.9rem;">
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
                                    <i class="fas fa-phone" style="color: #22c55e;"></i>
                                    {{ $demande->client->phone }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-car"></i>
                                    Vehicle
                                </div>
                                <div class="info-value">
                                    <i class="fas fa-car" style="color: #309ad3;"></i>
                                    {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-tools"></i>
                                    Requested Service
                                </div>
                                <div class="info-value">
                                    <i class="fas fa-wrench" style="color: #f59e0b;"></i>
                                    {{ $demande->servicePanne->titre }}
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-flag"></i>
                                    Status
                                </div>
                                <div class="info-value">
                                    <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                        @if($demande->status == 'Nouvelle_demande' || $demande->status == 'Nouvelle demande')
                                            New
                                        @elseif($demande->status == 'Assignée')
                                            Assigned
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="far fa-calendar"></i>
                                    Dates
                                </div>
                                <div class="info-value" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
                                    <div style="font-size: 0.85rem; color: #718096;">
                                        <i class="far fa-clock"></i>
                                        Created: {{ $demande->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    @if($demande->date_maintenance)
                                        <div style="font-size: 0.85rem; color: #22c55e; font-weight: 600;">
                                            <i class="far fa-calendar-check"></i>
                                            RDV: {{ $demande->date_maintenance->format('d/m/Y H:i') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">{{ $demande->created_at->format('d/m/Y H:i') }}</div>
                                    <div class="timeline-text">Request created</div>
                                </div>
                            </div>
                            @if($demande->status == 'Assignée' || $demande->status == 'en_cours' || $demande->status == 'termine')
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">{{ $demande->updated_at->format('d/m/Y H:i') }}</div>
                                    <div class="timeline-text">Status updated to {{ ucfirst(str_replace('_', ' ', $demande->status)) }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Spare Parts Section -->
                @if($demande->status === 'offre_acceptee' || $demande->status === 'en_cours')
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-cogs"></i>
                            Required Spare Parts
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert">
                            <i class="fas fa-info-circle"></i>
                            <div>The following parts have been identified as necessary for this repair.</div>
                        </div>

                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Part</th>
                                        <th>Price</th>
                                        <th>Availability</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Clutch Kit</strong></td>
                                        <td><strong>€ 120.00</strong></td>
                                        <td><span class="badge-stock badge-success">In Stock</span></td>
                                        <td style="text-align: right;">
                                            <button class="btn-order">Order</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Brake Pads</strong></td>
                                        <td><strong>€ 45.00</strong></td>
                                        <td><span class="badge-stock badge-warning">2-3 Days</span></td>
                                        <td style="text-align: right;">
                                            <button class="btn-order">Order</button>
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
                <!-- Assigned Team -->
                @if($demande->techniciens && count($demande->techniciens) > 0)
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-users-cog"></i>
                            Assigned Team
                        </h5>
                    </div>
                    <div class="card-body">
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

                <!-- Assign Technician -->
                @if($demande->status === 'Nouvelle_demande')
                <div class="card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-user-plus"></i>
                            Assign Technician
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="assignTechniciensForm">
                            <div style="margin-bottom: 1rem;">
                                <label class="form-label">Select Technician</label>
                                <select class="form-select" name="technicien_id" required>
                                    <option value="" disabled selected>-- Select Technician --</option>
                                    @foreach($techniciens as $tech)
                                        <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn-primary-custom">
                                <i class="fas fa-user-plus"></i>
                                Assign Technician
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Assign technician form
        const assignForm = document.getElementById('assignTechniciensForm');

        if (assignForm) {
            assignForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const select = this.querySelector('select[name="technicien_id"]');
                const techniciensData = [{
                    id_technicien: parseInt(select.value),
                    nom: select.options[select.selectedIndex].text
                }];

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
                            confirmButtonColor: '#309ad3',
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'An error occurred',
                            confirmButtonColor: '#309ad3',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to contact the server',
                        confirmButtonColor: '#309ad3',
                    });
                });
            });
        }

        // Smooth animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
