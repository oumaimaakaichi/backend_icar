<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f0f0f2 0%, #ffffff 100%);
            min-height: 100vh;
            color: #2d3748;
            overflow-x: hidden;
            margin-left: 50px
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            margin-left: 480px; /* Space for sidebar */
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            animation: slideInDown 0.8s ease-out;
        }

        .header p {
            color: #64748b;
            font-size: 1.1rem;
            opacity: 0;
            animation: fadeIn 1s ease-out 0.3s forwards;
        }

        .filters-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideInUp 0.8s ease-out 0.2s both;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1.5rem;
            align-items: center;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
        }

        .status-filter {
            padding: 1rem 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .status-filter:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideInUp 0.8s ease-out 0.4s both;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .table th {
            padding: 1.5rem 1rem;
            text-align: left;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table td {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: translateX(5px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        .badge-pending {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
        }

        .badge-completed {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .action-btn {
            padding: 0.8rem 1.2rem;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            gap: 0.5rem;
        }

        .page-btn {
            padding: 0.8rem 1.2rem;
            border: 2px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            min-width: 45px;
            text-align: center;
        }

        .page-btn:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .page-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .no-data {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
            font-size: 1.1rem;
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #cbd5e1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin-left: 0; /* Remove sidebar margin on mobile */
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 800px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body style="margin-left: 300px">
    <div class="container">
        <div style="margin-left: 20px; margin-top: 20px;">
            @include('Sidebar.responsablePiece')
        </div>

        <div class="header">
            <h1><i class="fas fa-tasks"></i> Gestion des Demandes</h1>
            <p>Gérez efficacement toutes vos demandes clients avec une interface moderne et intuitive</p>
        </div>

        <div class="stats-grid" id="stats-grid">
            <!-- Stats will be populated by JavaScript -->
        </div>

        <div class="filters-section">
            <div class="filters-grid">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Rechercher par nom, téléphone, ou modèle..." id="searchInput">
                </div>
                <select class="status-filter" id="statusFilter">
                    <option value="all">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="completed">Complété</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="color:cornflowerblue"><i class="fas fa-user"></i> Client</th>
                        <th style="color:cornflowerblue"><i class="fas fa-phone"></i> Téléphone</th>
                        <th style="color:cornflowerblue"><i class="fas fa-car"></i> Voiture</th>
                        <th style="color:cornflowerblue"><i class="fas fa-calendar"></i> Date</th>
                        <th style="color:cornflowerblue"><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="demandes-table">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>

            <div class="pagination" id="pagination">
                <!-- Pagination will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsPerPage = 6;
            let currentPage = 1;
            let allData = [];
            let filteredData = [];

            function fetchData() {
                fetch("{{ url('/api/demandes-iconnu') }}")
                    .then(response => response.json())
                    .then(data => {
                        allData = data.map(item => ({
                            ...item,
                            status: item.has_piece_recommandee ? 'completed' : 'pending'
                        }));
                        applyFilters();
                        updateStats();
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des demandes:', error);
                        // Show error message to user
                        const tableBody = document.getElementById('demandes-table');
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="no-data">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div>Erreur lors du chargement des données</div>
                                    <small>Veuillez réessayer plus tard</small>
                                </td>
                            </tr>
                        `;
                    });
            }

            function updateStats() {
                const totalRequests = allData.length;
                const pendingRequests = allData.filter(item => item.status === 'pending').length;
                const completedRequests = allData.filter(item => item.status === 'completed').length;

                const statsGrid = document.getElementById('stats-grid');
                statsGrid.innerHTML = `
                    <div class="stat-card">
                        <div class="stat-number">${totalRequests}</div>
                        <div class="stat-label">Total Demandes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${pendingRequests}</div>
                        <div class="stat-label">En Attente</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${completedRequests}</div>
                        <div class="stat-label">Complétées</div>
                    </div>
                `;
            }

            function applyFilters() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;

                filteredData = allData.filter(demande => {
                    const matchesSearch = (
                        (demande.client_prenom?.toLowerCase().includes(searchTerm) ||
                         demande.client_nom?.toLowerCase().includes(searchTerm)) ||
                        (demande.client_phone?.includes(searchTerm)) ||
                        (demande.voiture_model?.toLowerCase().includes(searchTerm))
                    );

                    const matchesStatus = statusFilter === 'all' || demande.status === statusFilter;

                    return matchesSearch && matchesStatus;
                });

                currentPage = 1;
                renderTable(currentPage);
                renderPagination();
            }

            function renderTable(page) {
                const tableBody = document.getElementById('demandes-table');
                tableBody.innerHTML = '';

                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedData = filteredData.slice(start, end);

                if (paginatedData.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="no-data">
                                <i class="fas fa-inbox"></i>
                                <div>Aucune demande trouvée</div>
                                <small>Essayez de modifier vos critères de recherche</small>
                            </td>
                        </tr>
                    `;
                    return;
                }

                paginatedData.forEach(demande => {
                    const row = document.createElement('tr');

                    let actionButton;
                    let statusBadge;


                        actionButton = `
  <button class="action-btn btn-primary" onclick='addPieces(${JSON.stringify(demande)})'>
    <i class="fas fa-plus"></i> Ajouter pièces
  </button>`;

                        statusBadge = `<span class="status-badge badge-pending">En attente</span>`;


                    row.innerHTML = `
                        <td><strong>${demande.client_prenom || ''} ${demande.client_nom || ''}</strong></td>
                        <td><i class="fas fa-phone-alt"></i> ${demande.client_phone || 'N/A'}</td>
                        <td><strong>${demande.voiture_model || 'N/A'}</strong><br><small>${demande.voiture_serie || 'N/A'}</small></td>
                        <td>${new Date(demande.created_at).toLocaleDateString('fr-FR')}</td>

                        <td>${actionButton}</td>
                    `;

                    tableBody.appendChild(row);
                });
            }

            function renderPagination() {
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';

                const pageCount = Math.ceil(filteredData.length / itemsPerPage);

                if (pageCount <= 1) return;

                // Previous button
                const prevBtn = document.createElement('button');
                prevBtn.className = `page-btn ${currentPage === 1 ? 'disabled' : ''}`;
                prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
                prevBtn.onclick = () => currentPage > 1 && changePage(currentPage - 1);
                prevBtn.disabled = currentPage === 1;
                pagination.appendChild(prevBtn);

                // Page numbers
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(pageCount, startPage + maxVisiblePages - 1);

                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
                    pageBtn.textContent = i;
                    pageBtn.onclick = () => changePage(i);
                    pagination.appendChild(pageBtn);
                }

                // Next button
                const nextBtn = document.createElement('button');
                nextBtn.className = `page-btn ${currentPage === pageCount ? 'disabled' : ''}`;
                nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
                nextBtn.onclick = () => currentPage < pageCount && changePage(currentPage + 1);
                nextBtn.disabled = currentPage === pageCount;
                pagination.appendChild(nextBtn);
            }

            function changePage(page) {
                if (page < 1 || page > Math.ceil(filteredData.length / itemsPerPage)) return;
                currentPage = page;
                renderTable(currentPage);
                renderPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Global functions for button actions
            window.addPieces = function(demande) {
                window.location.href = `/piece-recommandee/show/${demande.id}`;
            };

            window.viewPieces = function(id) {
                window.location.href = `/piece-recommandee/voir/${id}`;
            };

            // Event listeners
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);

            // Initialize
            fetchData();
        });
    </script>
</body>
</html>
