<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Demandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar-container {
            min-height: 100vh;
        }
        .main-content {

            padding: 20px;
            transition: all 0.3s;
        }
        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            font-weight: 500;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        .action-icon {
            font-size: 1.2rem;
            transition: all 0.2s;
        }
        .action-icon:hover {
            transform: scale(1.2);
        }
        .pagination .page-item.active .page-link {
            background-color: #343a40;
            border-color: #343a40;
        }
        .pagination .page-link {
            color: #343a40;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
 <div style="margin-left: 20px ">
    <div>
        @include('Sidebar.responsablePiece')
    </div>

    <div class="main-content flex-grow-1">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1 class="h3 mb-0 text-gray-800"> <b>Requests List</b></h1>
            </div>

            <!-- Filters Section -->
            <div class="filter-section mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <label class="input-group-text" for="statusFilter">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="all">All statuses</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container" style="width: 1300px">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Client</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Category</th>
                                <th>Car</th>

                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="demandes-table">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination will be generated here -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsPerPage = 10;
            let currentPage = 1;
            let allData = [];
            let filteredData = [];

            function fetchData() {
                fetch("{{ url('/api/demandes') }}")
                    .then(response => response.json())
                    .then(data => {
                        allData = data.map(item => ({
                            ...item,
                            status: item.has_piece_recommandee ? 'completed' : 'pending'
                        }));
                        applyFilters();
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des demandes:', error);
                    });
            }

            function applyFilters() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;

                filteredData = allData.filter(demande => {
                    // Filtre par recherche
                    const matchesSearch = (
                        (demande.client_prenom?.toLowerCase().includes(searchTerm) ||
                         demande.client_nom?.toLowerCase().includes(searchTerm)) ||
                        (demande.client_phone?.includes(searchTerm)) ||
                        (demande.service_titre?.toLowerCase().includes(searchTerm)) ||
                        (demande.voiture_model?.toLowerCase().includes(searchTerm))
                    );

                    // Filtre par statut
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
                            <td colspan="9" class="text-center py-4">Aucune demande trouvée</td>
                        </tr>
                    `;
                    return;
                }

                paginatedData.forEach(demande => {
                    const row = document.createElement('tr');

                    let actionButton;
                    let statusBadge;

                    if (demande.status === 'pending') {
                        actionButton = `
                            <button class="btn btn-sm btn-outline-primary me-1"
                                    title="Ajouter les pièces"
                                    onclick="window.location.href='/piece-recommandee/ajouter/${demande.id}'">
                                <i class="bi bi-plus-circle"></i>
                            </button>`;
                        statusBadge = `<span class="status-badge badge-pending">En attente</span>`;
                    } else {
                        actionButton = `
                            <button class="btn btn-sm btn-outline-success me-1"
                                    title="Voir les pièces"
                                    onclick="window.location.href='/piece-recommandee/voir/${demande.id}'">
                                <i class="bi bi-eye"></i>
                            </button>`;
                        statusBadge = `<span class="status-badge badge-completed">Complété</span>`;
                    }

                    row.innerHTML = `
                        <td>${demande.client_prenom || ''} ${demande.client_nom || ''}</td>
                        <td>${demande.client_phone || 'N/A'}</td>
                        <td>${demande.service_titre || 'N/A'}</td>
                        <td>${demande.categorie_titre || 'N/A'}</td>
                        <td>${demande.voiture_model || 'N/A'} (${demande.voiture_serie || 'N/A'})</td>

                        <td>${new Date(demande.created_at).toLocaleDateString()}</td>
                        <td>${statusBadge}</td>
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

                // Bouton Précédent
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Previous" onclick="changePage(${currentPage - 1})">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                `;

                // Pages
                const maxVisiblePages = 5;
                let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(pageCount, startPage + maxVisiblePages - 1);

                if (endPage - startPage + 1 < maxVisiblePages) {
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                if (startPage > 1) {
                    pagination.innerHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="changePage(1)">1</a>
                        </li>
                        ${startPage > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                    `;
                }

                for (let i = startPage; i <= endPage; i++) {
                    pagination.innerHTML += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                        </li>
                    `;
                }

                if (endPage < pageCount) {
                    pagination.innerHTML += `
                        ${endPage < pageCount - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : ''}
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="changePage(${pageCount})">${pageCount}</a>
                        </li>
                    `;
                }

                // Bouton Suivant
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === pageCount ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Next" onclick="changePage(${currentPage + 1})">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                `;
            }

            window.changePage = function(page) {
                if (page < 1 || page > Math.ceil(filteredData.length / itemsPerPage)) return;
                currentPage = page;
                renderTable(currentPage);
                window.scrollTo(0, 0);
            };

            // Écouteurs d'événements
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);

            fetchData();
        });
    </script>
</body>
</html>
