<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contracting Companies Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #567288 0%,  #567288 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #4facfe 100%);
            --warning-gradient: linear-gradient(135deg, #63a270 0%, #63a270 100%);
            --danger-gradient: linear-gradient(135deg, #ff5c61 0%, #ff5c61 100%);
            --info-gradient: linear-gradient(135deg, #77a386 0%, #77a386 100%);
            --white: #ffffff;
            --light-bg: #f8fafc;
            --text-dark: #2d3748;
            --text-light: #718096;
            --border-color: #e2e8f0;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f3f4f5 0%, #f0eff2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            margin: 20px;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .header-section {
            background-color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 2px,
                rgba(255,255,255,0.1) 2px,
                rgba(255,255,255,0.1) 4px
            );
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .header-title {
            position: relative;
            z-index: 2;
        }

        .header-title h2 {
            color: rgb(50, 21, 100);
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;

            letter-spacing: -0.5px;
        }

        .header-subtitle {
            color: rgb(94, 91, 91);
            font-size: 1.1rem;
            margin-top: 10px;
            font-weight: 300;
        }

        .content-section {
            padding: 40px 30px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .stat-card.total::before { background: var(--primary-gradient); }
        .stat-card.pending::before { background: var(--warning-gradient); }
        .stat-card.accepted::before { background: var(--success-gradient); }
        .stat-card.refused::before { background: var(--danger-gradient); }
        .stat-card.active::before { background: var(--info-gradient); }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .stat-card.total .stat-number { color: #667eea; }
        .stat-card.pending .stat-number { color: #f5576c; }
        .stat-card.accepted .stat-number { color: #4facfe; }
        .stat-card.refused .stat-number { color: #ff9a9e; }
        .stat-card.active .stat-number { color: #525f56; }

        .stat-label {
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
            opacity: 0.7;
        }

        .table-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .table-card .card-body {
            padding: 0;
        }

        .table {
            margin: 0;
            background: transparent;
        }

        .table thead th {
            background: var(--primary-gradient) !important;
            color: white !important;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            padding: 10px 10px;
            border: none;
            text-align: center;
            position: relative;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .table td {
            padding: 20px 15px;
            vertical-align: middle;
            text-align: center;
            color: var(--text-dark);
            font-weight: 500;
            border: none;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #749ad2, #749ad2);
            color: #fcfaf9;
        }

        .status-accepted {
            background: var(--success-gradient);
            color: white;
        }

        .status-refused {
            background: var(--danger-gradient);
            color: white;
        }

        .activation-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .activation-yes {
            background: var(--info-gradient);
            color: white;
        }

        .activation-no {
            background: var(--danger-gradient);
            color: white;
        }

        .btn-modern {
            border: none;
            border-radius: 25px;
            padding: 8px 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin: 2px;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-accept {
            background: var(--success-gradient);
            color: white;
        }

        .btn-reject {
            background: var(--danger-gradient);
            color: white;
        }

        .btn-activate {
            background: var(--info-gradient);
            color: white;
        }

        .btn-deactivate {
            background: var(--warning-gradient);
            color: #8b4513;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 700;
        }

        .btn-close {
            filter: invert(1);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid var(--border-color);
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.2);
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                border-radius: 15px;
            }

            .header-section {
                padding: 30px 20px;
            }

            .header-title h2 {
                font-size: 2rem;
            }

            .content-section {
                padding: 20px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                border-radius: 15px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-modern {
                width: 100%;
                max-width: 120px;
            }
        }

        /* Tooltip customization */
        .tooltip .tooltip-inner {
            background: var(--primary-gradient);
            border-radius: 8px;
            font-weight: 600;
        }

        .tooltip .tooltip-arrow::before {
            border-top-color: #667eea !important;
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebar')

    <div class="container-fluid" style="margin-top: 40px;margin-right:80px">
        <div class="main-container animate-fade-in" style="margin-top: 80px">
            <!-- Header Section -->
            <div class="header-section">
                  <div class="header-title">
                    <h2 style="color: rgb(73, 115, 145);"><i class="fas fa-building" style="color: rgb(73, 115, 145);"></i> Companies Management</h2>
              <p class="header-subtitle">Manage and oversee all your contracting companies</p>

                </div>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <!-- Statistics Cards -->
                <div class="stats-container">
                    <div class="stat-card total">

                        <div class="stat-number" id="totalCompanies">0</div>
                        <div class="stat-label">Total Companies</div>
                    </div>
                    <div class="stat-card pending">

                        <div class="stat-number" id="pendingCompanies">0</div>
                        <div class="stat-label">Pending</div>
                    </div>

                    <div class="stat-card active">

                        <div class="stat-number" id="activeCompanies">0</div>
                        <div class="stat-label">Active</div>
                    </div>
                </div>

                <!-- Companies Table -->
                <div class="card shadow-sm table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-building"></i> Company Name</th>
                                        <th><i class="fas fa-envelope"></i> Email</th>
                                        <th><i class="fas fa-map-marker-alt"></i> City</th>
                                        <th><i class="fas fa-phone"></i> Contact</th>
                                        <th><i class="fas fa-info-circle"></i> Status</th>
                                        <th><i class="fas fa-toggle-on"></i> Activated</th>
                                        <th><i class="fas fa-cogs"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entreprises as $key => $entreprise)
                                    <tr>
                                        <td><strong>{{ $entreprise->nom_entreprise }}</strong></td>
                                        <td>{{ $entreprise->email }}</td>
                                        <td>{{ $entreprise->ville }}</td>
                                        <td>{{ $entreprise->num_contact }}</td>
                                        <td>
                                            @if($entreprise->statut_demande === 'en_attente')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            @elseif($entreprise->statut_demande === 'acceptee')
                                                <span class="status-badge status-accepted">
                                                    <i class="fas fa-check"></i> Accepted
                                                </span>
                                            @elseif($entreprise->statut_demande === 'refusee')
                                                <span class="status-badge status-refused">
                                                    <i class="fas fa-times"></i> Refused
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($entreprise->est_actif)
                                                <span class="activation-badge activation-yes">
                                                    <i class="fas fa-check"></i> Yes
                                                </span>
                                            @else
                                                <span class="activation-badge activation-no">
                                                    <i class="fas fa-times"></i> No
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                @if($entreprise->statut_demande === 'en_attente')
                                                    <!-- Accept Button with Tooltip -->
                                                    <form action="{{ route('entreprises.accepter', $entreprise->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-modern btn-accept"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Accept Request" >
                                                            <i class="fa-solid fa-check" style="color: white"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Reject Button with Tooltip -->
                                                    <form action="{{ route('entreprises.refuser', $entreprise->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-modern btn-reject"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Reject Request">
                                                            <i class="fa-solid fa-times" style="color: white"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($entreprise->est_actif)
                                                    <!-- Deactivate Button with Tooltip -->
                                                    <form action="{{ route('entreprises.desactiver', $entreprise->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-modern btn-deactivate"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Deactivate Company">
                                                            <i class="fa-solid fa-power-off" style="color: white"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Activate Button with Tooltip -->
                                                    <form action="{{ route('entreprises.activer', $entreprise->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-modern btn-activate"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Activate Company">
                                                            <i class="fa-solid fa-power-off" style="color: white"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout -->
    <div class="modal fade" id="addEntrepriseModal" tabindex="-1" aria-labelledby="addEntrepriseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle"></i> Add a Contracting Company
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEntrepriseForm" method="POST" action="{{ route('entreprises.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-building"></i> Company Name
                            </label>
                            <input type="text" name="nom_entreprise" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i> City
                            </label>
                            <input type="text" name="ville" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-phone"></i> Contact Number
                            </label>
                            <input type="text" name="num_contact" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-modern w-100" style="background: var(--primary-gradient); color: white;">
                            <i class="fas fa-plus"></i> Add Company
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap & JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Calculate and display statistics
            updateStatistics();
        });

        // Function to update statistics
        function updateStatistics() {
            const rows = document.querySelectorAll('tbody tr');
            let total = rows.length;
            let pending = 0;
            let accepted = 0;
            let refused = 0;
            let active = 0;

            rows.forEach(row => {
                const statusCell = row.querySelector('.status-badge');
                const activationCell = row.querySelector('.activation-badge');

                if (statusCell) {
                    if (statusCell.classList.contains('status-pending')) pending++;
                    else if (statusCell.classList.contains('status-accepted')) accepted++;
                    else if (statusCell.classList.contains('status-refused')) refused++;
                }

                if (activationCell && activationCell.classList.contains('activation-yes')) {
                    active++;
                }
            });

            // Update statistics display with animation
            animateNumber('totalCompanies', total);
            animateNumber('pendingCompanies', pending);
            animateNumber('acceptedCompanies', accepted);
            animateNumber('refusedCompanies', refused);
            animateNumber('activeCompanies', active);
        }

        // Function to animate numbers
        function animateNumber(elementId, targetValue) {
            const element = document.getElementById(elementId);
            const currentValue = parseInt(element.textContent) || 0;
            const increment = targetValue > currentValue ? 1 : -1;
            const stepTime = Math.abs(Math.floor(200 / Math.abs(targetValue - currentValue))) || 50;

            let current = currentValue;
            const timer = setInterval(() => {
                current += increment;
                element.textContent = current;

                if (current === targetValue) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        document.addEventListener("DOMContentLoaded", function() {
            // supprimer une entreprise
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let entrepriseId = this.getAttribute('data-id');
                    if (confirm("Are you sure you want to delete this company?")) {
                        fetch(`/entreprises/${entrepriseId}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        }).then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                showNotification(data.message, 'success');
                                setTimeout(() => location.reload(), 1000);
                            }
                        });
                    }
                });
            });

            // Pré-remplir et afficher le modal d'édition
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let entrepriseId = this.getAttribute('data-id');
                    window.location.href = `/entreprises/${entrepriseId}/edit`;
                });
            });
        });

        // Function to show notifications
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 25px;
                border-radius: 10px;
                color: white;
                font-weight: 600;
                z-index: 9999;
                animation: slideIn 0.3s ease;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            `;

            if (type === 'success') {
                notification.style.background = 'var(--success-gradient)';
            } else if (type === 'warning') {
                notification.style.background = 'var(--warning-gradient)';
            } else {
                notification.style.background = 'var(--danger-gradient)';
            }

            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</body>
</html>
