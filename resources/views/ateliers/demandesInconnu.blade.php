<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes par Atelier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            margin-left: 0px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .header-subtitle {
            color: #718096;
            font-size: 1rem;
        }

        /* Filter section */
        .filters {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group label {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.9rem;
        }

        .filter-select {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            color: #4a5568;
            outline: none;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .filter-select:focus {
            border-color: #309ad3;
            box-shadow: 0 0 0 3px rgba(48, 154, 211, 0.1);
        }

        .btn-filter {
            background: #309ad3;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-filter:hover {
            background: #2681b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(48, 154, 211, 0.4);
        }

        /* Cards container */
        .requests-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Card styles */
        .request-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 1.5rem;
            gap: 1.5rem;
        }

        .request-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card-section {
            flex: 1;
            min-width: 0;
        }

        .card-section.action-section {
            flex: 0 0 140px;
            display: flex;
            justify-content: flex-end;
        }

        .section-label {
            font-size: 0.75rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .client-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .client-name {
            font-weight: 600;
            color: #2d3748;
        }

        .client-phone {
            font-size: 0.85rem;
            color: #718096;
        }

        .car-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .car-model {
            font-weight: 600;
            color: #2d3748;
        }

        .car-serie {
            font-size: 0.85rem;
            color: #718096;
        }

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

        .status-en_attente {
            background: #F2EFC7;
            color: #5a5520;
        }

        .status-Assignée {
            background: #B4DEBD;
            color: #1e5128;
        }

        .divider {
            width: 1px;
            background: #e2e8f0;
            height: 60px;
            align-self: center;
        }

        .btn-details {
            background: #309ad3;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-details:hover {
            background: #2681b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(48, 154, 211, 0.4);
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #718096;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .alert {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #4299e1;
            color: #2d3748;
            font-size: 1.1rem;
        }

        /* Pagination */
        .pagination-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 1.5rem;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .pagination li {
            margin: 0;
        }

        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .pagination a {
            color: #4a5568;
            background: white;
        }

        .pagination a:hover {
            background: #309ad3;
            color: white;
            border-color: #309ad3;
            transform: translateY(-2px);
        }

        .pagination .active span {
            background: #309ad3;
            color: white;
            border-color: #309ad3;
        }

        .pagination .disabled span {
            color: #a0aec0;
            background: #f7fafc;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }

        .pagination-info {
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .date-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .created-date {
            font-size: 0.85rem;
            color: #718096;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rdv-date {
            font-size: 0.85rem;
            color: #38a169;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 1200px) {
            .request-card {
                flex-wrap: wrap;
            }

            .card-section {
                flex: 1 1 45%;
            }

            .card-section.action-section {
                flex: 1 1 100%;
                justify-content: center;
            }

            .divider {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .request-card {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .card-section {
                flex: 1 1 100%;
            }

            .card-section.action-section {
                flex: 1 1 100%;
                justify-content: stretch;
            }

            .btn-details {
                width: 100%;
                justify-content: center;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-select {
                width: 100%;
            }

            .btn-filter {
                width: 100%;
                justify-content: center;
            }

            .pagination-container {
                flex-direction: column;
                text-align: center;
            }

            .divider {
                display: none;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container" style="margin-right: 50px">
        <!-- Header -->
        <div class="header">
            <h3 class="header-title">Maintenance Requests</h3>
            <p class="header-subtitle">Manage and track all maintenance requests for unknown issues</p>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-group">
                <label for="statusFilter">Search by status:</label>
                <select id="statusFilter" class="filter-select">
                    <option value="all">All status</option>
                    <option value="en_attente">New request</option>
                    <option value="Assignée">Assigned</option>
                </select>
                <button id="applyFilter" class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Apply
                </button>
            </div>
        </div>

        @if($demandes->isEmpty())
            <div class="alert">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                No requests found for this workshop
            </div>
        @else
            <div class="requests-list" id="requestsList">
                @foreach($demandes as $demande)
                    <div class="request-card" data-status="{{ str_replace(' ', '_', $demande->status) }}">
                        <!-- Client Section -->
                        <div class="card-section">
                            <div class="section-label">Client</div>
                            <div class="client-info">
                                <span class="client-name">{{ $demande->client->prenom }} {{ $demande->client->nom }}</span>
                                <span class="client-phone">
                                    <i class="fas fa-phone" style="font-size: 0.75rem;"></i>
                                    {{ $demande->client->phone }}
                                </span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Vehicle Section -->
                        <div class="card-section">
                            <div class="section-label">Vehicle</div>
                            <div class="car-info">
                                <span class="car-model">{{ $demande->voiture->model }}</span>
                                <span class="car-serie">{{ $demande->voiture->serie }}</span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Status Section -->
                        <div class="card-section">
                            <div class="section-label">Status</div>
                            <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                @if($demande->status == 'en_attente')
                                    New Request
                                @elseif($demande->status == 'Assignée')
                                    Assigned
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
                                @endif
                            </span>
                        </div>

                        <div class="divider"></div>

                        <!-- Dates Section -->
                        <div class="card-section">
                            <div class="section-label">Dates</div>
                            <div class="date-info">
                                <div class="created-date">
                                    <i class="far fa-clock"></i>
                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                </div>
                                @if($demande->date_maintenance)
                                    <div class="rdv-date">
                                        <i class="far fa-calendar-alt"></i>
                                        RDV: {{ $demande->date_maintenance->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Action Section -->
                        <div class="card-section action-section">
                            <a href="{{ route('ateliers.showInconnu', $demande->id) }}" class="btn-details">
                                <i class="fas fa-eye"></i>
                                Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($demandes->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing {{ $demandes->firstItem() }} to {{ $demandes->lastItem() }} of {{ $demandes->total() }} results
                    </div>

                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if($demandes->onFirstPage())
                            <li class="disabled" aria-disabled="true">
                                <span><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $demandes->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max(1, $demandes->currentPage() - 2);
                            $end = min($demandes->lastPage(), $demandes->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <li>
                                <a href="{{ $demandes->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="disabled">
                                    <span>...</span>
                                </li>
                            @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            @if($page == $demandes->currentPage())
                                <li class="active" aria-current="page">
                                    <span>{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $demandes->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endfor

                        @if($end < $demandes->lastPage())
                            @if($end < $demandes->lastPage() - 1)
                                <li class="disabled">
                                    <span>...</span>
                                </li>
                            @endif
                            <li>
                                <a href="{{ $demandes->url($demandes->lastPage()) }}">{{ $demandes->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if($demandes->hasMorePages())
                            <li>
                                <a href="{{ $demandes->nextPageUrl() }}" rel="next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="disabled" aria-disabled="true">
                                <span><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif
        @endif
    </div>

    <script>
        // Filter functionality
        document.getElementById('applyFilter').addEventListener('click', function() {
            const status = document.getElementById('statusFilter').value;
            const cards = document.querySelectorAll('.request-card');

            let visibleCount = 0;
            cards.forEach(card => {
                const cardStatus = card.dataset.status;

                if(status === 'all' || cardStatus === status) {
                    card.style.display = '';
                    visibleCount++;
                    // Add smooth animation
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateX(0)';
                    }, 50);
                } else {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            // Show empty state if no cards visible
            setTimeout(() => {
                if (visibleCount === 0) {
                    showEmptyState();
                } else {
                    hideEmptyState();
                }
            }, 400);
        });

        function showEmptyState() {
            const container = document.getElementById('requestsList');
            const existingEmpty = document.querySelector('.empty-state-card');

            if (!existingEmpty && container) {
                const emptyCard = document.createElement('div');
                emptyCard.className = 'empty-state-card';
                emptyCard.style.cssText = 'background: white; border-radius: 12px; padding: 4rem 2rem; text-align: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);';
                emptyCard.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h3>No requests found</h3>
                        <p>No requests match the selected filter criteria.</p>
                    </div>
                `;
                container.appendChild(emptyCard);
            }
        }

        function hideEmptyState() {
            const emptyState = document.querySelector('.empty-state-card');
            if (emptyState) {
                emptyState.remove();
            }
        }

        // Initialize with smooth entrance animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.request-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateX(-30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateX(0)';
                }, index * 50);
            });
        });
    </script>
</body>
</html>
