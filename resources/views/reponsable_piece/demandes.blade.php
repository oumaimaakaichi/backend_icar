<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1a202c; /* Couleur de texte par défaut plus foncée */
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85); /* Plus opaque pour meilleur contraste */
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
            color: #2d3748; /* Texte plus foncé */
        }

        .glass-table {
            background: rgba(255, 255, 255, 0.9); /* Plus opaque */
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #2d3748; /* Texte plus foncé */
        }

        .table-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
            color: #2d3748; /* Texte plus foncé */
        }

        .table-row {
            background: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1); /* Bordure plus visible */
            transition: all 0.3s ease;
            color: #4a5568; /* Texte gris foncé */
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            color: #2d3748; /* Texte encore plus foncé au survol */
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #2d3748; /* Texte foncé */
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            color: #1a202c; /* Texte encore plus foncé */
        }

        .status-badge {
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: #fff; /* Texte blanc pour meilleur contraste */
            font-weight: 600;
        }

        .badge-pending {
            background: linear-gradient(135deg, #ed8936, #ed8936); /* Orange plus vif */
            border-color: rgba(237, 137, 54, 0.8);
        }

        .badge-completed {
            background: linear-gradient(135deg, #68d391, #48bb78); /* Vert plus vif */
            border-color: rgba(72, 187, 120, 0.8);
        }

        .search-input {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #2d3748; /* Texte foncé */
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: #718096; /* Placeholder gris */
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #667eea;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
            color: #2d3748;
        }

        .filter-select {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #2d3748; /* Texte foncé */
        }

        .filter-select option {
            background: rgba(255, 255, 255, 0.95);
            color: #2d3748;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-slideIn {
            animation: slideIn 0.8s ease-out forwards;
        }

        .animate-delay-1 { animation-delay: 0.1s; opacity: 0; }
        .animate-delay-2 { animation-delay: 0.2s; opacity: 0; }
        .animate-delay-3 { animation-delay: 0.3s; opacity: 0; }
        .animate-delay-4 { animation-delay: 0.4s; opacity: 0; }

        .loading-shimmer {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.3) 50%, rgba(102, 126, 234, 0.1) 100%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        .action-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .action-btn:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .pagination-btn {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #2d3748;
            transition: all 0.3s ease;
        }

        .pagination-btn:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            color: #1a202c;
        }

        .pagination-btn.active {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }

        .stats-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: #2d3748;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            color: #1a202c;
        }

        .floating-element {
            position: absolute;
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
            color: #2d3748;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Styles spécifiques pour le texte dans les cartes */
        .text-dark-primary { color: #2d3748; }
        .text-dark-secondary { color: #4a5568; }
        .text-dark-tertiary { color: #718096; }

        /* Ajustements pour les éléments spécifiques */
        .header-title { color: #2d3748; }
        .header-subtitle { color: #4a5568; }
        .stat-value { color: #2d3748; font-weight: 700; }
    </style>
</head>
<body class="relative overflow-x-hidden">
    @include('Sidebar.responsablePiece')
    <!-- Floating Elements -->
    <div class="floating-element text-4xl" style="top: 10%; left: 5%; animation-delay: 0s;">🔧</div>
    <div class="floating-element text-3xl" style="top: 15%; right: 10%; animation-delay: 2s;">⚙️</div>
    <div class="floating-element text-3xl" style="bottom: 20%; left: 15%; animation-delay: 4s;">🚗</div>
    <div class="floating-element text-4xl" style="bottom: 10%; right: 20%; animation-delay: 1s;">📋</div>

    <div class="min-h-screen p-6" >
        <div class="container py-5" style="margin-top: 80px; margin-right: 120px;">


            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="glass-card rounded-2xl p-6 mb-8 animate-fadeInUp animate-delay-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="bi bi-clipboard-data text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold header-title mb-1">Requests Dashboard</h1>
                                <p class="header-subtitle">Manage and track all service requests</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <div class="text-sm text-dark-tertiary">Total Requests</div>
                                <div class="text-2xl font-bold stat-value" id="totalCount">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="stats-card rounded-2xl p-6 animate-fadeInUp animate-delay-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-dark-secondary text-sm">Pending</p>
                                <p class="text-3xl font-bold text-yellow-600 stat-value" id="pendingCount">-</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center" style="background-color:orange">
                                <i class="bi bi-clock text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-2xl p-6 animate-fadeInUp animate-delay-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-dark-secondary text-sm">Completed</p>
                                <p class="text-3xl font-bold text-green-600 stat-value" id="completedCount">-</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl flex items-center justify-center" style="background-color:green">
                                <i class="bi bi-check-circle text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-2xl p-6 animate-fadeInUp animate-delay-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-dark-secondary text-sm">Success Rate</p>
                                <p class="text-3xl font-bold text-blue-600 stat-value" id="successRate">-%</p>
                            </div>
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center">
                                <i class="bi bi-graph-up text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="glass-card rounded-2xl p-6 mb-8 animate-slideIn animate-delay-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-dark-primary text-sm font-medium mb-2">Search</label>
                            <div class="relative">
                                <input type="text" class="search-input w-full py-3 px-4 pr-12 rounded-xl placeholder-gray-500" placeholder="Search by client, phone, service..." id="searchInput">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <i class="bi bi-search text-dark-tertiary"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-dark-primary text-sm font-medium mb-2">Filter by Status</label>
                            <select class="filter-select w-full py-3 px-4 rounded-xl" id="statusFilter">
                                <option value="all">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="glass-table rounded-2xl overflow-hidden animate-fadeInUp animate-delay-3">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="table-header">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Client</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Phone</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Service</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Category</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Car</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Date</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Status</th>
                                    <th class="px-6 py-4 text-left font-semibold text-dark-primary">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="demandes-table">
                                <!-- Loading state -->
                                <tr class="table-row">
                                    <td colspan="8" class="px-6 py-8 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <div class="loading-shimmer w-8 h-8 rounded-full"></div>
                                            <span class="text-dark-secondary">Loading requests...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8 animate-fadeInUp animate-delay-4">
                    <nav class="glass-card rounded-xl p-2">
                        <ul class="flex space-x-1" id="pagination">
                            <!-- Pagination will be generated here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsPerPage = 6;
            let currentPage = 1;
            let allData = [];
            let filteredData = [];

            function updateStats() {
                const totalCount = allData.length;
                const pendingCount = allData.filter(item => item.status === 'pending').length;
                const completedCount = allData.filter(item => item.status === 'completed').length;
                const successRate = totalCount > 0 ? Math.round((completedCount / totalCount) * 100) : 0;

                document.getElementById('totalCount').textContent = totalCount;
                document.getElementById('pendingCount').textContent = pendingCount;
                document.getElementById('completedCount').textContent = completedCount;
                document.getElementById('successRate').textContent = successRate + '%';
            }

            function fetchData() {
                fetch("{{ url('/api/demandes') }}")
                    .then(response => response.json())
                    .then(data => {
                        allData = data.map(item => ({
                            ...item,
                            status: item.has_piece_recommandee ? 'completed' : 'pending'
                        }));
                        updateStats();
                        applyFilters();
                    })
                    .catch(error => {
                        console.error('Error loading requests:', error);
                        document.getElementById('demandes-table').innerHTML = `
                            <tr class="table-row">
                                <td colspan="8" class="px-6 py-8 text-center">
                                    <div class="text-red-600">
                                        <i class="bi bi-exclamation-triangle text-2xl mb-2"></i>
                                        <p>Error loading data. Please try again.</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
            }

            function applyFilters() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;

                filteredData = allData.filter(demande => {
                    const matchesSearch = (
                        (demande.client_prenom?.toLowerCase().includes(searchTerm) ||
                         demande.client_nom?.toLowerCase().includes(searchTerm)) ||
                        (demande.client_phone?.includes(searchTerm)) ||
                        (demande.service_titre?.toLowerCase().includes(searchTerm)) ||
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
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedData = filteredData.slice(start, end);

                if (paginatedData.length === 0) {
                    tableBody.innerHTML = `
                        <tr class="table-row">
                            <td colspan="8" class="px-6 py-8 text-center">
                                <div class="text-dark-secondary">
                                    <i class="bi bi-inbox text-4xl mb-3"></i>
                                    <p class="text-lg">No requests found</p>
                                    <p class="text-sm opacity-80">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                tableBody.innerHTML = paginatedData.map((demande, index) => {
                    let actionButton;
                    let statusBadge;

                    if (demande.status === 'pending') {
                        actionButton = `
                            <button class="btn-glass action-btn px-4 py-2 rounded-lg text-dark-primary hover:text-blue-700 transition-all duration-300"
                                    title="Add Parts"
                                    onclick="window.location.href='/piece-recommandee/ajouter/${demande.id}'">
                                <i class="bi bi-plus-circle"></i>
                                <span class="ml-1 text-sm">Add</span>
                            </button>`;
                        statusBadge = `<span class="status-badge badge-pending px-3 py-1 rounded-full text-sm font-medium">Pending</span>`;
                    } else {
                        actionButton = `
                            <button class="btn-glass action-btn px-4 py-2 rounded-lg text-dark-primary hover:text-green-700 transition-all duration-300"
                                    title="View Parts"
                                    onclick="window.location.href='/piece-recommandee/voir/${demande.id}'">
                                <i class="bi bi-eye"></i>
                                <span class="ml-1 text-sm">View</span>
                            </button>`;
                        statusBadge = `<span class="status-badge badge-completed px-3 py-1 rounded-full text-sm font-medium">Completed</span>`;
                    }

                    return `
                        <tr class="table-row" style="animation-delay: ${index * 0.05}s">
                            <td class="px-6 py-4 font-medium text-dark-primary">${demande.client_prenom || ''} ${demande.client_nom || ''}</td>
                            <td class="px-6 py-4 text-dark-secondary">${demande.client_phone || 'N/A'}</td>
                            <td class="px-6 py-4 text-dark-secondary">${demande.service_titre || 'N/A'}</td>
                            <td class="px-6 py-4 text-dark-secondary">${demande.categorie_titre || 'N/A'}</td>
                            <td class="px-6 py-4 text-dark-secondary">${demande.voiture_model || 'N/A'} <span class="text-xs opacity-70">(${demande.voiture_serie || 'N/A'})</span></td>
                            <td class="px-6 py-4 text-dark-secondary">${new Date(demande.created_at).toLocaleDateString()}</td>
                            <td class="px-6 py-4">${statusBadge}</td>
                            <td class="px-6 py-4">${actionButton}</td>
                        </tr>
                    `;
                }).join('');

                // Add staggered animation to new rows
                setTimeout(() => {
                    document.querySelectorAll('.table-row').forEach(row => {
                        row.style.opacity = '1';
                        row.style.transform = 'translateY(0)';
                    });
                }, 50);
            }

            function renderPagination() {
                const pagination = document.getElementById('pagination');
                const pageCount = Math.ceil(filteredData.length / itemsPerPage);

                if (pageCount <= 1) {
                    pagination.innerHTML = '';
                    return;
                }

                let paginationHTML = '';

                // Previous button
                paginationHTML += `
                    <li>
                        <button class="pagination-btn px-3 py-2 rounded-lg ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-500 hover:text-white'}"
                                ${currentPage === 1 ? 'disabled' : `onclick="changePage(${currentPage - 1})"`}>
                            <i class="bi bi-chevron-left"></i>
                        </button>
                    </li>
                `;

                // Page numbers
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(pageCount, startPage + maxVisiblePages - 1);

                for (let i = startPage; i <= endPage; i++) {
                    paginationHTML += `
                        <li>
                            <button class="pagination-btn px-4 py-2 rounded-lg ${i === currentPage ? 'active' : 'hover:bg-blue-500 hover:text-white'}"
                                    onclick="changePage(${i})">${i}</button>
                        </li>
                    `;
                }

                // Next button
                paginationHTML += `
                    <li>
                        <button class="pagination-btn px-3 py-2 rounded-lg ${currentPage === pageCount ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-500 hover:text-white'}"
                                ${currentPage === pageCount ? 'disabled' : `onclick="changePage(${currentPage + 1})"`}>
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </li>
                `;

                pagination.innerHTML = paginationHTML;
            }

            window.changePage = function(page) {
                if (page < 1 || page > Math.ceil(filteredData.length / itemsPerPage)) return;
                currentPage = page;
                renderTable(currentPage);
                renderPagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
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
