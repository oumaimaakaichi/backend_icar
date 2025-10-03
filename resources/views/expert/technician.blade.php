<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard des Techniciens</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, white 0%, white 100%);
            min-height: 100vh;
            padding: 20px;
            margin-top: 90px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #4f6184 0%, #4f6184 100%);
            color: white;
            padding: 30px 40px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>') repeat;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-right: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .content {
            padding: 40px;
        }

        .filters-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            align-items: end;
        }

        .filter-group {
            position: relative;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .filter-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .search-input {
            position: relative;
        }

        .search-input::before {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 1;
        }

        .search-input input {
            padding-left: 50px;
        }

        .table-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            color: white;
        }

        .table th {
            padding: 20px;
            font-weight: 600;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f8f9fa;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table td {
            padding: 20px;
            vertical-align: middle;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .avatar-text {
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .technician-info {
            display: flex;
            align-items: center;
        }

        .technician-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .badge:hover::before {
            left: 100%;
        }

        .bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .bg-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .contact-info {
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .contact-info:hover {
            color: #667eea;
            transform: translateX(5px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .pagination-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
            margin-top: 20px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Styles pour les textes des suspensions */
        .suspension-reason {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
                margin-top: 100px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .content {
                padding: 20px;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
                margin-right: 0;
                margin-top: 20px;
            }

            .table-container {
                overflow-x: auto;
            }

            .pagination-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarExpert')

   <div class="container py-5" style="margin-top: 50px ; margin-right:50px">
    <div class="header">
        <div class="header-content">
            <div>
                <h1><i class="fas fa-tools"></i> Technicians List</h1>
                <p>Manage and track your technical team</p>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="filters-section">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="statusFilter">Status</label>
                    <select class="filter-input" id="statusFilter">
                        <option value="">All statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="activeFilter">Activity State</label>
                    <select class="filter-input" id="activeFilter">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="searchFilter">Search</label>
                    <div class="search-input">
                        <input type="text" class="filter-input" id="searchFilter" placeholder="Name, email, phone...">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="table" id="techniciansTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-user-circle"></i> Avatar</th>
                        <th><i class="fas fa-user"></i> Full Name</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-phone"></i> Phone</th>
                        <th><i class="fas fa-toggle-on"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($techniciens as $technicien)
                        <tr>
                            <td>
                                <div class="avatar">
                                    <span class="avatar-text">{{ strtoupper(substr($technicien->nom, 0, 1)) }}{{ strtoupper(substr($technicien->prenom, 0, 1)) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="technician-info">
                                    <div class="technician-name">{{ $technicien->nom }} {{ $technicien->prenom }}</div>
                                </div>
                            </td>
                            <td class="contact-info">{{ $technicien->email }}</td>
                            <td class="contact-info">{{ $technicien->phone }}</td>
                            <td>
                                @if($technicien->isSuspended())
                                    <span class="badge bg-danger">Suspended</span>
                                    @if($technicien->suspension_reason)
                                        <div class="suspension-reason">{{ $technicien->suspension_reason }}</div>
                                    @endif
                                @elseif($technicien->isActive)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h3>No technicians found</h3>
                                    <p>There are currently no technicians to display</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-info">
            <div>
                <p class="text-muted">
                    Showing {{ $techniciens->firstItem() ?? 0 }} to {{ $techniciens->lastItem() ?? 0 }}
                    of {{ $techniciens->total() }} technicians
                </p>
            </div>
            <div>
                {{ $techniciens->links() }}
            </div>
        </div>
    </div>
</div>


    <script>
        let currentTechnicienId = null;

        // Filtres
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const activeFilter = document.getElementById('activeFilter');
            const searchFilter = document.getElementById('searchFilter');

            // Mise à jour des statistiques dynamiques
            updateStats();

            // Implémentation des filtres côté client
            [statusFilter, activeFilter, searchFilter].forEach(filter => {
                filter.addEventListener('change', applyFilters);
                filter.addEventListener('input', applyFilters);
            });
        });

        function updateStats() {
            const rows = document.querySelectorAll('#techniciensTable tbody tr');
            let total = 0, actifs = 0, suspendus = 0;

            rows.forEach(row => {
                if (row.cells.length >= 5 && !row.querySelector('.empty-state')) {
                    total++;
                    const statusCell = row.cells[4];
                    if (statusCell.textContent.includes('Actif')) actifs++;
                    if (statusCell.textContent.includes('Suspendu')) suspendus++;
                }
            });

            // Mise à jour des compteurs si les éléments existent
            const totalElement = document.getElementById('totalTech');
            const activeElement = document.getElementById('activeTech');
            const suspendedElement = document.getElementById('suspendedTech');

            if (totalElement) totalElement.textContent = total;
            if (activeElement) activeElement.textContent = actifs;
            if (suspendedElement) suspendedElement.textContent = suspendus;
        }

        function applyFilters() {
            const statusValue = document.getElementById('statusFilter').value.toLowerCase();
            const activeValue = document.getElementById('activeFilter').value;
            const searchValue = document.getElementById('searchFilter').value.toLowerCase();

            const rows = document.querySelectorAll('#techniciensTable tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const cells = row.cells;
                if (cells.length < 5 || row.querySelector('.empty-state')) return;

                const statusText = cells[4].textContent.toLowerCase();
                const activeText = cells[4].textContent.toLowerCase();
                const searchText = (cells[1].textContent + ' ' + cells[2].textContent + ' ' + cells[3].textContent).toLowerCase();

                let show = true;

                // Filtre par statut
                if (statusValue && !statusText.includes(statusValue)) {
                    show = false;
                }

                // Filtre par activité
                if (activeValue) {
                    if (activeValue === '1' && !activeText.includes('actif')) {
                        show = false;
                    }
                    if (activeValue === '0' && (activeText.includes('actif') && !activeText.includes('inactif'))) {
                        show = false;
                    }
                }

                // Filtre par recherche
                if (searchValue && !searchText.includes(searchValue)) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            // Mise à jour des statistiques filtrées
            updateFilteredStats(visibleCount);
        }

        function updateFilteredStats(visibleCount) {
            const rows = document.querySelectorAll('#techniciensTable tbody tr:not([style*="display: none"])');
            let actifs = 0, suspendus = 0;

            rows.forEach(row => {
                if (row.cells.length >= 5 && !row.querySelector('.empty-state')) {
                    const statusCell = row.cells[4];
                    if (statusCell.textContent.includes('Actif')) actifs++;
                    if (statusCell.textContent.includes('Suspendu')) suspendus++;
                }
            });

            // Mise à jour des compteurs filtrés
            const totalElement = document.getElementById('totalTech');
            const activeElement = document.getElementById('activeTech');
            const suspendedElement = document.getElementById('suspendedTech');

            if (totalElement) totalElement.textContent = visibleCount;
            if (activeElement) activeElement.textContent = actifs;
            if (suspendedElement) suspendedElement.textContent = suspendus;
        }
    </script>
</body>
</html>
