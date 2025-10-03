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

        /* Filter buttons */
        .filter-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-btn i {
            font-size: 1.1rem;
        }

        .filter-btn-new {
            background: #F2EFC7;
            color: #5a5520;
        }

        .filter-btn-new:hover {
            background: #e8e4b5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .filter-btn-assigned {
            background: #B4DEBD;
            color: #1e5128;
        }

        .filter-btn-assigned:hover {
            background: #a0d4ab;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .filter-btn-all {
            background: #e2e8f0;
            color: #4a5568;
        }

        .filter-btn-all:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .filter-btn.active {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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

        .card-section.id-section {
            flex: 0 0 100px;
        }

        .card-section.status-section {
            flex: 0 0 120px;
        }

        .card-section.action-section {
            flex: 0 0 140px;
            display: flex;
            justify-content: flex-end;
        }

        .request-id {
            font-weight: 700;
            color: #309ad3;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .piece-indicator {
            color: #ed8936;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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

        .service-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .service-title {
            font-weight: 600;
            color: #2d3748;
        }

        .service-category {
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

        .status-Nouvelle_demande, .status-New {
            background: #F2EFC7;
            color: #5a5520;
        }

        .status-Assignée, .status-Assigned {
            background: #B4DEBD;
            color: #1e5128;
        }

        .section-label {
            font-size: 0.75rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .section-content {
            color: #2d3748;
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

            .card-section.id-section,
            .card-section.status-section,
            .card-section.action-section {
                flex: 1 1 100%;
            }

            .card-section.action-section {
                justify-content: stretch;
            }

            .btn-details {
                width: 100%;
                justify-content: center;
            }

            .filter-buttons {
                flex-direction: column;
            }

            .filter-btn {
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
            <p class="header-subtitle">Manage and track all maintenance requests for known issues</p>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn filter-btn-all active" data-filter="all">
                <i class="fas fa-list"></i>
                All Requests
            </button>
            <button class="filter-btn filter-btn-new" data-filter="Nouvelle_demande">
                <i class="fas fa-plus-circle"></i>
                New Requests
            </button>
            <button class="filter-btn filter-btn-assigned" data-filter="Assignée">
                <i class="fas fa-check-circle"></i>
                Assigned Requests
            </button>
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
                        <!-- ID Section -->


                        <div class="divider"></div>

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

                        <!-- Service Section -->
                        <div class="card-section">
                            <div class="section-label">Service</div>
                            <div class="service-info">
                                <span class="service-title">{{ $demande->servicePanne->titre }}</span>
                                <span class="service-category">{{ $demande->servicePanne->categoryPane->titre }}</span>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Status Section -->
                        <div class="card-section status-section">
                            <div class="section-label">Status</div>
                            <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                @if($demande->status == 'Nouvelle_demande' || $demande->status == 'Nouvelle demande')
                                    New
                                @elseif($demande->status == 'Assignée')
                                    Assigned
                                @else
                                    {{ $demande->status }}
                                @endif
                            </span>
                        </div>

                        <div class="divider"></div>

                        <!-- Dates Section -->
                        <div class="card-section">
                            <div class="section-label">Dates</div>
                            <div class="section-content">
                                <div style="font-size: 0.85rem; color: #718096; margin-bottom: 0.25rem;">
                                    <i class="far fa-clock"></i>
                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                </div>
                                @if($demande->date_maintenance)
                                    <div style="font-size: 0.85rem; color: #38a169; font-weight: 600;">
                                        <i class="far fa-calendar-alt"></i>
                                        RDV: {{ $demande->date_maintenance->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Action Section -->
                        <div class="card-section action-section">
                            <a href="{{ route('ateliers.show', $demande->id) }}" class="btn-details">
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
        const filterButtons = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.request-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter cards
                let visibleCount = 0;
                cards.forEach(card => {
                    const status = card.dataset.status;

                    if(filter === 'all' || status === filter) {
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
