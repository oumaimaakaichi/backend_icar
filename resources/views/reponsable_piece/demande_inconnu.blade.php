<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #5685ab 0%, #3e5f7e 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            --dark-color: #2c3e50;
            --light-bg: #f8faff;
            --white: #ffffff;
            --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 30px rgba(0, 0, 0, 0.12);
            --shadow-heavy: 0 15px 50px rgba(0, 0, 0, 0.15);
            --border-radius: 20px;
            --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--light-bg);
            color: var(--dark-color);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(245, 87, 108, 0.03) 0%, transparent 50%);
            z-index: -1;
        }

        .container {
            max-width: 1000px;

            margin: 0 auto;
            margin-left: 0px;
            margin-top: 50px;
            position: relative;
        }

        /* Floating Elements */
        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
        }

        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Header Section */
        .header {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-light);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header h1 i {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
        }

        .header p {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: var(--transition);
        }

        .stat-card:hover::before {
            opacity: 0.03;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-heavy);
        }

        .stat-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info h3 {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-info p {
            color: #64748b;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            position: relative;
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 20px;
            opacity: 0.9;
        }

        .stat-icon i {
            position: relative;
            z-index: 2;
        }

        /* Filters Section */
        .filters-section {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-light);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            font-size: 1rem;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.2rem;
        }

        .status-filter {
            padding: 1.2rem 2rem;
            border: 2px solid rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            cursor: pointer;
            transition: var(--transition);
            min-width: 200px;
            font-weight: 600;
        }

        .status-filter:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        /* Table Section */
        .table-container {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-medium);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .table-header {
            background-color: white;
            color: black;
            padding: 1.5rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: grid;
            grid-template-columns: 2fr 1.5fr 1.5fr 1fr 1.5fr;
            align-items: center;
            gap: 1rem;
        }

        .table-body {
            padding: 1rem;
        }

        .table-row {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1.5fr 1fr 1.5fr;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem 1rem;
            border-radius: 15px;
            margin-bottom: 0.5rem;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-row:hover {
            background: rgba(102, 126, 234, 0.03);
            transform: translateX(5px);
            box-shadow: var(--shadow-light);
        }

        .client-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .client-avatar {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .client-details h4 {
            font-weight: 400;
            font-size: 1rem;
            color: var(--dark-color);
            margin-bottom: 0.2rem;
        }

        .client-details p {
            color: #64748b;
            font-size: 0.5rem;
        }

        .phone-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: var(--transition);
        }

        .phone-link:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .car-info {
            display: flex;
            flex-direction: column;
        }

        .car-model {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.2rem;
        }

        .car-series {
            color: #64748b;
            font-size: 0.9rem;
        }

        .date-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            text-align: center;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
        }

        .btn-outline:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-pending {
            background: rgba(245, 87, 108, 0.15);
            color: #f5576c;
        }

        .badge-completed {
            background: rgba(75, 172, 254, 0.15);
            color: #4bacfe;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            gap: 0.5rem;
        }

        .page-btn {
            padding: 1rem 1.2rem;
            border: 2px solid rgba(102, 126, 234, 0.2);
            background: white;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            min-width: 50px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .page-btn.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* No Data State */
        .no-data {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .no-data i {
            font-size: 4rem;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .no-data h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-size: 1.5rem;
        }

        /* Loading Animation */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(102, 126, 234, 0.2);
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                margin-left: 0;
            }
        }

        @media (max-width: 992px) {
            .container {
                padding: 1.5rem;
            }

            .table-header,
            .table-row {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .client-info {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .filters-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.responsablePiece')
<br/>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="floating-shape" style="top: 10%; left: 10%; font-size: 2rem;">🔧</div>
        <div class="floating-shape" style="top: 20%; right: 10%; font-size: 1.5rem; animation-delay: -2s;">⚙️</div>
        <div class="floating-shape" style="bottom: 20%; left: 15%; font-size: 1.8rem; animation-delay: -4s;">🚗</div>
        <div class="floating-shape" style="top: 60%; right: 20%; font-size: 2.2rem; animation-delay: -1s;">📋</div>
    </div>

    <div class="container" style="margin-right: 50px ; margin-top:100px">
        <div class="header">
            <h1><i class="fas fa-clipboard-list"></i> Request Management</h1>
            <p>Track and manage all automotive parts requests with advanced analytics</p>
        </div>

        <div class="stats-grid" id="stats-grid">
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3 id="total-requests">0</h3>
                        <p>Total Requests</p>
                    </div>
                    <div class="stat-icon" style="background: var(--primary-gradient);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3 id="pending-requests">0</h3>
                        <p>Pending</p>
                    </div>
                    <div class="stat-icon" style="background: var(--warning-gradient);">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3 id="completed-requests">0</h3>
                        <p>Completed</p>
                    </div>
                    <div class="stat-icon" style="background: var(--success-gradient);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-content">
                    <div class="stat-info">
                        <h3 id="completion-rate">0%</h3>
                        <p>Success Rate</p>
                    </div>
                    <div class="stat-icon" style="background: var(--secondary-gradient);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="filters-section">
            <div class="filters-grid">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search by client, phone, or car model..." id="searchInput">
                </div>
                <select class="status-filter" id="statusFilter">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div><i class="fas fa-user"></i> Client</div>
                <div><i class="fas fa-phone"></i> Contact</div>
                <div><i class="fas fa-car"></i> Vehicle</div>
                <div><i class="fas fa-calendar"></i> Date</div>
                <div><i class="fas fa-cogs"></i> Actions</div>
            </div>

            <div class="table-body" id="table-body">
                <div class="loading">
                    <div class="loading-spinner"></div>
                </div>
            </div>

            <div class="pagination" id="pagination">
                <!-- Pagination will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsPerPage = 5;
            let currentPage = 1;
            let allData = [];
            let filteredData = [];

            function fetchData() {
                fetch("{{ url('/api/demandes-iconnu') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network error');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!Array.isArray(data)) {
                            throw new Error('Invalid data format');
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
                        console.error('Error loading requests:', error);
                        showErrorState();
                    });
            }

            function showErrorState() {
                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = `
                    <div class="no-data">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Error loading data</h4>
                        <p>Please try again later</p>
                        <button onclick="fetchData()" class="action-btn btn-primary" style="margin-top: 1rem;">
                            <i class="fas fa-refresh"></i> Retry
                        </button>
                    </div>
                `;
            }

            function updateStats() {
                const totalRequests = allData.length;
                const pendingRequests = allData.filter(item => item.status === 'pending').length;
                const completedRequests = allData.filter(item => item.status === 'completed').length;
                const completionRate = totalRequests > 0 ? Math.round((completedRequests / totalRequests) * 100) : 0;

                document.getElementById('total-requests').textContent = totalRequests;
                document.getElementById('pending-requests').textContent = pendingRequests;
                document.getElementById('completed-requests').textContent = completedRequests;
                document.getElementById('completion-rate').textContent = completionRate + '%';
            }

            function applyFilters() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;

                filteredData = allData.filter(request => {
                    const fullName = `${request.client_prenom} ${request.client_nom}`.toLowerCase();
                    const matchesSearch = (
                        fullName.includes(searchTerm) ||
                        (request.client_phone?.includes(searchTerm)) ||
                        (request.voiture_model?.toLowerCase().includes(searchTerm))
                    );

                    const matchesStatus = statusFilter === 'all' || request.status === statusFilter;

                    return matchesSearch && matchesStatus;
                });

                currentPage = 1;
                renderTable(currentPage);
                renderPagination();
            }

            function renderTable(page) {
                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = '';

                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedData = filteredData.slice(start, end);

                if (paginatedData.length === 0) {
                    tableBody.innerHTML = `
                        <div class="no-data">
                            <i class="fas fa-search"></i>
                            <h4>No requests found</h4>
                            <p>Try adjusting your search criteria</p>
                        </div>
                    `;
                    return;
                }

                paginatedData.forEach(request => {
                    const fullName = `${request.client_prenom} ${request.client_nom}`.trim();
                    const initials = fullName.split(' ').map(n => n[0]).join('').toUpperCase();
                    const formattedDate = new Date(request.created_at).toLocaleDateString('en-US', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });

                    const row = document.createElement('div');
                    row.className = 'table-row';

                    row.innerHTML = `
                        <div class="client-info">
                            <div class="client-avatar">${initials}</div>
                            <div class="client-details">
                                <h4>${fullName}</h4>

                            </div>
                        </div>
                        <div>
                            ${request.client_phone ? `
                                <a href="tel:${request.client_phone}" class="phone-link">
                                    <i class="fas fa-phone"></i>
                                    ${request.client_phone}
                                </a>
                            ` : '<span style="color: #64748b;">N/A</span>'}
                        </div>
                        <div class="car-info">
                            <div class="car-model">${request.voiture_model}</div>
                            ${request.voiture_serie ? `<div class="car-series">${request.voiture_serie}</div>` : ''}
                        </div>
                        <div class="date-badge">${formattedDate}</div>
                        <div class="action-buttons">
                            ${request.status === 'pending' ? `
                                <button class="action-btn btn-primary" onclick="addPieces(${request.id})">
                                    <i class="fas fa-plus"></i> Add Parts
                                </button>
                            ` : `
                                <button class="action-btn btn-outline" onclick="viewPieces(${request.id})">
                                    <i class="fas fa-eye"></i> View Parts
                                </button>
                            `}
                        </div>
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
                ellipsis.style.cursor = 'default';
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

            // Initialize the application
            fetchData();

            // Add some entrance animations
            setTimeout(() => {
                document.querySelectorAll('.stat-card').forEach((card, index) => {
                    card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
                });
            }, 100);
        });

        // CSS animations for entrance effects
        const style = document.createElement('style');
        style.textContent = `
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

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
