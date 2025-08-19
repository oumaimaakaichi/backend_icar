<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #th;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --gray-color: #adb5bd;
            --border-radius: 12px;
            --box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f7ff;
            color: var(--dark-color);
            min-height: 100vh;

            transition: margin-left 0.3s;
            width: 1500px

        }

        .container {
            max-width: 1400px;
            padding: 2rem;
            margin: 0 auto;
            margin-left: 120px;
            margin-top:50px
        }

        /* Header Section */
        .header {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--box-shadow);
            border-left: 5px solid var(--primary-color);
            animation: fadeIn 0.6s ease-out;
        }

        .header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header p {
            color: var(--gray-color);
            font-size: 1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        /* Filters Section */
        .filters-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--box-shadow);
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
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
            font-size: 1.1rem;
        }

        .status-filter {
            padding: 1rem 1.5rem;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            background: white;
            cursor: pointer;
            transition: var(--transition);
            min-width: 200px;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        .status-filter:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        /* Table Section */
        .table-container {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            padding: 20px
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .table th {
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            color: 4361ee;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .table th:first-child {
            border-top-left-radius: var(--border-radius);
        }

        .table th:last-child {
            border-top-right-radius: var(--border-radius);
        }

        .table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
            transition: var(--transition);
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: rgba(67, 97, 238, 0.03);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-pending {
            background: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .badge-completed {
            background: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        /* Action Buttons */
        .action-btn {
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: rgba(67, 97, 238, 0.05);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            gap: 0.5rem;
        }

        .page-btn {
            padding: 0.7rem 1rem;
            border: 1px solid #e0e0e0;
            background: white;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            min-width: 40px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-btn:hover {
            background: rgba(67, 97, 238, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .page-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* No Data State */
        .no-data {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-color);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #e0e0e0;
        }

        .no-data h4 {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            body {
                margin-left: 0;
            }
        }

        @media (max-width: 992px) {
            .container {
                padding: 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 1.8rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 800px;
            }

            .action-btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 1.2rem;
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
       @include('Sidebar.responsablePiece')
    <div class="container">


   <div>

        <div class="header">
            <h1><i class="fas fa-clipboard-list"></i> Request Management</h1>
<p>Track and manage all automotive parts requests</p>
   </div>

        <div class="stats-grid" id="stats-grid">
            <!-- Stats will be populated by JavaScript -->
        </div>

        <div class="filters-section">
            <div class="filters-grid">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search by client, phone ..." id="searchInput">
                </div>
                <select class="status-filter" id="statusFilter">
                    <option value="all">All status</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead style="background-color: #4361ee">
                    <tr>
                        <th><i class="fas fa-user-tie"></i> Client</th>
                        <th><i class="fas fa-phone"></i> Phone</th>
                        <th><i class="fas fa-car"></i> car</th>
                        <th><i class="fas fa-calendar-day"></i> Date</th>
                        <th><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="demandes-table" style="padding: 20px">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>

            <div class="pagination" id="pagination">
                <!-- Pagination will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsPerPage = 8;
            let currentPage = 1;
            let allData = [];
            let filteredData = [];

            function fetchData() {
                fetch("{{ url('/api/demandes-iconnu') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!Array.isArray(data)) {
                            throw new Error('Format de données invalide');
                        }

                        allData = data.map(item => ({
                            id: item.id,
                            client_prenom: item.client_prenom || '',
                            client_nom: item.client_nom || '',
                            client_phone: item.client_phone || '',
                            voiture_model: item.voiture_model || 'N/A',
                            voiture_serie: item.voiture_serie || '',
                            created_at: item.created_at,
                            has_piece_recommandee: item.has_piece_recommandee || false,
                            status: item.has_piece_recommandee ? 'completed' : 'pending'
                        }));

                        applyFilters();
                        updateStats();
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des demandes:', error);
                        showErrorState();
                    });
            }

            function showErrorState() {
                const tableBody = document.getElementById('demandes-table');
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="no-data">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h4>Erreur lors du chargement des données</h4>
                            <p>Veuillez réessayer plus tard</p>
                        </td>
                    </tr>
                `;

                document.getElementById('stats-grid').innerHTML = `
                    <div class="stat-card">
                        <div class="stat-number">--</div>
                        <div class="stat-label">Total Demandes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">--</div>
                        <div class="stat-label">En Attente</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">--</div>
                        <div class="stat-label">Complétées</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">--%</div>
                        <div class="stat-label">Taux de complétion</div>
                    </div>
                `;
            }

            function updateStats() {
                const totalRequests = allData.length;
                const pendingRequests = allData.filter(item => item.status === 'pending').length;
                const completedRequests = allData.filter(item => item.status === 'completed').length;
                const completionRate = totalRequests > 0 ? Math.round((completedRequests / totalRequests) * 100) : 0;

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
                    <div class="stat-card">
                        <div class="stat-number">${completionRate}%</div>
                        <div class="stat-label">Taux de complétion</div>
                    </div>
                `;
            }

            function applyFilters() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;

                filteredData = allData.filter(demande => {
                    const fullName = `${demande.client_prenom} ${demande.client_nom}`.toLowerCase();
                    const matchesSearch = (
                        fullName.includes(searchTerm) ||
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
                            <td colspan="5" class="no-data">
                                <i class="fas fa-inbox"></i>
                                <h4>Aucune demande trouvée</h4>
                                <p>Essayez de modifier vos critères de recherche</p>
                            </td>
                        </tr>
                    `;
                    return;
                }

                paginatedData.forEach(demande => {
                    const row = document.createElement('tr');
                    const fullName = `${demande.client_prenom} ${demande.client_nom}`.trim();
                    const formattedDate = new Date(demande.created_at).toLocaleDateString('fr-FR', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    const actionButton = demande.status === 'pending' ? `
                        <button class="action-btn btn-primary" onclick="addPieces(${demande.id})">
                            <i class="fas fa-plus-circle"></i> Add spare part

                        </button>
                    ` : `
                        <button class="action-btn btn-outline" onclick="viewPieces(${demande.id})">
                            <i class="fas fa-eye"></i> View spare part
                        </button>
                    `;

                    row.innerHTML = `
                        <td>
                            <strong>${fullName || 'N/A'}</strong>
                        </td>
                        <td>
                            ${demande.client_phone ? `
                                <a href="tel:${demande.client_phone}" class="text-decoration-none">
                                    <i class="fas fa-phone-alt mr-1"></i> ${demande.client_phone}
                                </a>
                            ` : 'N/A'}
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong>${demande.voiture_model}</strong>
                                ${demande.voiture_serie ? `<small class="text-muted">${demande.voiture_serie}</small>` : ''}
                            </div>
                        </td>
                        <td>
                            ${formattedDate}
                        </td>
                        <td>
                            ${actionButton}
                        </td>
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
                const prevBtn = createPageButton('<i class="fas fa-chevron-left"></i>', currentPage > 1, () => changePage(currentPage - 1));
                pagination.appendChild(prevBtn);

                // Page numbers
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(pageCount, startPage + maxVisiblePages - 1);

                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                // First page and ellipsis
                if (startPage > 1) {
                    pagination.appendChild(createPageButton('1', true, () => changePage(1)));
                    if (startPage > 2) {
                        pagination.appendChild(createEllipsis());
                    }
                }

                // Middle pages
                for (let i = startPage; i <= endPage; i++) {
                    pagination.appendChild(createPageButton(i.toString(), true, () => changePage(i), i === currentPage));
                }

                // Last page and ellipsis
                if (endPage < pageCount) {
                    if (endPage < pageCount - 1) {
                        pagination.appendChild(createEllipsis());
                    }
                    pagination.appendChild(createPageButton(pageCount.toString(), true, () => changePage(pageCount)));
                }

                // Next button
                const nextBtn = createPageButton('<i class="fas fa-chevron-right"></i>', currentPage < pageCount, () => changePage(currentPage + 1));
                pagination.appendChild(nextBtn);
            }

            function createPageButton(content, enabled, onClick, isActive = false) {
                const button = document.createElement('button');
                button.className = `page-btn ${isActive ? 'active' : ''} ${!enabled ? 'disabled' : ''}`;
                button.innerHTML = content;
                button.onclick = enabled ? onClick : null;
                button.disabled = !enabled;
                return button;
            }

            function createEllipsis() {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'page-btn';
                ellipsis.textContent = '...';
                ellipsis.style.pointerEvents = 'none';
                return ellipsis;
            }

            function changePage(page) {
                if (page < 1 || page > Math.ceil(filteredData.length / itemsPerPage)) return;
                currentPage = page;
                renderTable(currentPage);
                renderPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Global functions for button actions
            window.addPieces = function(id) {
                window.location.href = `/piece-recommandee/show/${id}`;
            };

            window.viewPieces = function(id) {
                window.location.href = `/piece-recommandee/voir/${id}`;
            };

            // Event listeners
            document.getElementById('searchInput').addEventListener('input',
                debounce(() => applyFilters(), 300)
            );

            document.getElementById('statusFilter').addEventListener('change', applyFilters);

            // Debounce function for search input
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this, args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            // Initialize
            fetchData();
        });
    </script>
</body>
</html>
