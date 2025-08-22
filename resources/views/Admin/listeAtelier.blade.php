<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des Ateliers</title>
    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        :root {
            --primary-color: #e3e4e7;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #4facfe;
            --warning-color: #ff9a9e;
            --danger-color: #ffa085;
            --light-bg: #f8fafc;
            --white: #ffffff;
            --text-dark: #2d3748;
            --text-light: #718096;
            --border-color: #e2e8f0;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: linear-gradient(135deg, #f6f6f8 0%, #f2f1f4 100%);
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
        }

        .header-section {

            padding: 40px 30px;
            border-radius: 20px 20px 0 0;
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

        .header-title h1 {
            color: rgb(73, 115, 145);
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(130, 224, 237, 0.3);
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            color: rgba(110, 108, 108, 0.9);
            font-size: 1.1rem;
            margin-top: 10px;
            font-weight: 300;
        }

        .content-section {
            padding: 30px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .search-box input {
            width: 100%;
            padding: 15px 20px 15px 55px;
            font-size: 16px;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            outline: none;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 5px 25px rgba(102, 126, 234, 0.3);
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 18px;
            pointer-events: none;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .table {
            margin: 0;
            background: transparent;
        }



        .table thead th {
            color: rgb(133, 131, 131) !important;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            padding: 20px 15px;
            border: none;
            text-align: center;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table td {
            padding: 20px 15px;
            vertical-align: middle;
            text-align: center;
            color: var(--text-dark);
            font-weight: 500;
        }

        .btn-modern {
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(236, 232, 232, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-visit {

            color: white;
        }

        .btn-visit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            color: white;
        }

        .btn-activate {
            background: linear-gradient(135deg, #be3b03, #be3b03);
            color: white;
        }

        .btn-activate:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-deactivate {
            background: linear-gradient(135deg, #6aa67c, #6aa67c);
            color: white;
        }

        .btn-deactivate:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 154, 158, 0.4);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: linear-gradient(135deg, #54b988, #4a8f70);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #fa4c52, #fa4c52);
            color: white;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
            gap: 15px;
        }

        .btn-pagination {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-pagination:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-pagination:disabled {
            background: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
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
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        #map {
            height: 300px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 15px;
            overflow: hidden;
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
                border-radius: 15px 15px 0 0;
            }

            .header-title h1 {
                font-size: 2rem;
            }

            .content-section {
                padding: 20px;
            }

            .table-container {
                overflow-x: auto;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar inclusion (assurez-vous que le fichier sidebar.blade.php existe) -->
@include('Sidebar.sidebar')

<div class="container-fluid" style="margin-top: 80px ; margin-right:80px">
    <div class="main-container animate-fade-in">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-title">
                <h1><i class="fas fa-tools"></i> Workshop Management</h1>
              <p class="header-subtitle">Manage and oversee all your workshops in one place</p>

            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Statistics Cards -->
            <div class="stats-container">
    <div class="stat-card">
        <div class="stat-number" id="totalWorkshops">0</div>
        <div class="stat-label">Total Workshops</div>
    </div>
    <div class="stat-card">
        <div class="stat-number text-success" id="activeWorkshops">0</div>
        <div class="stat-label">Active Workshops</div>
    </div>
    <div class="stat-card">
        <div class="stat-number text-warning" id="inactiveWorkshops">0</div>
        <div class="stat-label">Inactive Workshops</div>
    </div>
</div>


            <!-- Search Container -->
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="search" placeholder="Search by par name or email...">
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-responsive table-container">
                <table class="table" id="workshopTable">
                    <thead style="background-color: #00f2fe">
                        <tr>
                            <th><i class="fas fa-store"></i> Trade Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-globe"></i> Website</th>
                            <th><i class="fas fa-map-marker-alt"></i> City</th>

                            <th><i class="fas fa-user-tie"></i> Director</th>
                            <th><i class="fas fa-toggle-on"></i> Status</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody id="AtelierTable">
                        @foreach ($ateliers as $atelier)
                            <tr>
                                <td><strong>{{ $atelier->nom_commercial }}</strong></td>
                                <td>{{ $atelier->email }}</td>
                                <td>
                                    <a href="{{ $atelier->site_web }}" target="_blank" class="btn btn-modern btn-visit">
                                        <i class="fas fa-external-link-alt" style="color: cadetblue"></i> <b style="color: cadetblue">Visiter</b>
                                    </a>
                                </td>
                                <td>{{ $atelier->ville }}</td>

                                <td>{{ $atelier->nom_directeur }}</td>
                                <td>
                                    <span class="status-badge {{ $atelier->is_active == 0 ? 'status-inactive' : 'status-active' }}">
                                        {{ $atelier->is_active == 0 ? 'Inactif' : 'Actif' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($atelier->is_active == 0)
                                        <button class="btn btn-modern btn-activate activate-btn" data-id="{{ $atelier->id }}" title="Activer l'atelier">
                                            <i class="fas fa-toggle-off" style="color: white"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-modern btn-deactivate deactivate-btn" data-id="{{ $atelier->id }}" title="Désactiver l'atelier">
                                            <i class="fas fa-toggle-on" style="color: white"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination-container">
                    <button id="prevBtn" class="btn-pagination" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span id="pageInfo" style="margin: 0 20px; font-weight: 600; color: var(--text-dark);">Page 1</span>
                    <button id="nextBtn" class="btn-pagination">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Leaflet JS pour la carte -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Calcul des statistiques
        updateStatistics();

        // Activation d'un atelier
        document.querySelectorAll('.activate-btn').forEach(button => {
            button.addEventListener('click', function () {
                let atelierId = this.getAttribute('data-id');

                fetch(`/ateliers/${atelierId}/activate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    showNotification(data.message || "Atelier activé !", 'success');
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    showNotification("Une erreur s'est produite lors de l'activation.", 'error');
                });
            });
        });

        // Désactiver d'un atelier
        document.querySelectorAll('.deactivate-btn').forEach(button => {
            button.addEventListener('click', function () {
                let atelierId = this.getAttribute('data-id');

                fetch(`/ateliers/${atelierId}/desactivate`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    showNotification(data.message || "Atelier désactivé !", 'warning');
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    showNotification("Une erreur s'est produite lors de la désactivation.", 'error');
                });
            });
        });
    });

    // Fonction pour afficher les statistiques
    function updateStatistics() {
        const rows = document.querySelectorAll("#AtelierTable tr");
        const totalWorkshops = rows.length;
        let activeWorkshops = 0;
        let inactiveWorkshops = 0;

        rows.forEach(row => {
            const statusBadge = row.querySelector('.status-badge');
            if (statusBadge && statusBadge.classList.contains('status-active')) {
                activeWorkshops++;
            } else {
                inactiveWorkshops++;
            }
        });

        document.getElementById('totalWorkshops').textContent = totalWorkshops;
        document.getElementById('activeWorkshops').textContent = activeWorkshops;
        document.getElementById('inactiveWorkshops').textContent = inactiveWorkshops;
    }

    // Fonction pour afficher les notifications
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
            notification.style.background = 'linear-gradient(135deg, #4facfe, #00f2fe)';
        } else if (type === 'warning') {
            notification.style.background = 'linear-gradient(135deg, #ff9a9e, #fad0c4)';
        } else {
            notification.style.background = 'linear-gradient(135deg, #ffa085, #ffaa85)';
        }

        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    //recherche par nom et email une atelier
    document.getElementById("search").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#workshopTable tbody tr");

        rows.forEach(row => {
            let name = row.cells[0].textContent.toLowerCase();
            let email = row.cells[1].textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

        // Recalculer les statistiques après filtrage
        updateStatistics();
    });

    // Pagination avec indicateur de page
    let currentPage = 0;
    const rowsPerPage = 5;
    const rows = document.querySelectorAll("#AtelierTable tr");

    function showPage(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= page * rowsPerPage && index < (page + 1) * rowsPerPage) ? "" : "none";
        });

        document.getElementById("prevBtn").disabled = page === 0;
        document.getElementById("nextBtn").disabled = (page + 1) * rowsPerPage >= rows.length;

        const totalPages = Math.ceil(rows.length / rowsPerPage);
        document.getElementById("pageInfo").textContent = `Page ${page + 1} sur ${totalPages}`;
    }

    document.getElementById("prevBtn").addEventListener("click", () => {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    });

    document.getElementById("nextBtn").addEventListener("click", () => {
        if ((currentPage + 1) * rowsPerPage < rows.length) {
            currentPage++;
            showPage(currentPage);
        }
    });

    showPage(currentPage);

    // Activation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
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
