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
            background: linear-gradient(135deg, #f3f4f7 0%, #f2f5fb 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            z-index: -1;
        }

        .container {
            padding: 2rem;
            margin-top: 90px;
            margin-left: 90px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-title {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #309ad3 0%, #309ad3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .header-subtitle {
            color: #718096;
            font-size: 1.1rem;
        }

        .filters {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select {
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: #4a5568;
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .filter-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-filter {
            background: linear-gradient(135deg, #309ad3 0%, #309ad3 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .requests-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fill, minmax(550px, 1fr));
        }

        .request-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .request-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #4b89a2 100%);
        }

        .request-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }

        .request-id {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .status-Nouvelle_demande {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
        }

        .status-Une_offre_a_été_faite {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
        }

        .status-offre_acceptee {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .status-Assignée {
            background: linear-gradient(135deg, #309ad3, #309ad3);
            color: white;
        }

        .status-Non_assigné {
            background: linear-gradient(135deg, #e53e3e, #c53030);
            color: white;
        }

        .status-Assigné {
            background: linear-gradient(135deg, #38a169, #2f855a);
            color: white;
        }

        .card-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .info-section h4 {
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
            opacity: 0.7;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .info-item i {
            width: 16px;
            color: #667eea;
        }

        .info-item strong {
            min-width: 80px;
            font-weight: 600;
            color: #4a5568;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .created-date {
            color: #718096;
            font-size: 0.9rem;
        }

        .rdv-date {
            background: rgba(72, 187, 120, 0.1);
            color: #38a169;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-details {
            background: linear-gradient(135deg, #309ad3 0%, #309ad3 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .piece-indicator {
            color: #ed8936;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #718096;
        }

        .alert {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 4px solid #4299e1;
            color: #2d3748;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .container {
                margin-left: 0;
                padding: 1rem;
            }

            .requests-grid {
                grid-template-columns: 1fr;
            }

            .card-content {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .card-footer {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container">
        <!-- Header -->
      <div class="header">
    <h3 class="header-title">Maintenance Requests</h3>
    <p class="header-subtitle">Manage and track all maintenance requests for known issues</p>
</div>


        <!-- Filters -->
        <div class="filters">
            <div class="filter-group">
               <label for="statusFilter" style="font-weight: 600; color: #4a5568;">Filter by status:</label>

                <select id="statusFilter" class="filter-select">
                    <option value="all">Tous les statuts</option>
                    <option value="Nouvelle_demande">Nouvelle demande</option>
                    <option value="Une_offre_a_été_faite">Une offre a été faite</option>
                    <option value="offre_acceptee">Offre acceptée</option>
                    <option value="Assignée">Assignée</option>
                    <option value="Non_assigné">Non assigné</option>
                    <option value="Assigné">Assigné</option>
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
                Aucune demande trouvée pour cet atelier
            </div>
        @else
            <div class="requests-grid">
                @foreach($demandes as $demande)
                    <div class="request-card" data-status="{{ str_replace(' ', '_', $demande->status) }}">
                        <div class="card-header">
                            <h3 class="request-id">
                                Request
                                @if($demande->has_piece_recommandee)
                                    <i class="fas fa-tools piece-indicator" title="Pièces recommandées"></i>
                                @endif
                            </h3>
                            <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                {{ str_replace('_', ' ', $demande->status) }}
                            </span>
                        </div>

                        <div class="card-content">
                            <div class="info-section">
                               <h4>Customer Information</h4>

                                <div class="info-item">
                                    <i class="fas fa-user"></i>
                                    <strong>Customer:</strong>
                                    <span>{{ $demande->client->prenom }} {{ $demande->client->nom }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <strong>Phone:</strong>
                                    <span>{{ $demande->client->phone }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-car"></i>
                                    <strong>Car:</strong>
                                    <span>{{ $demande->voiture->model }} ({{ $demande->voiture->serie }})</span>
                                </div>
                            </div>
                            <div class="info-section">
                              <h4>Service Details</h4>

                                <div class="info-item">
                                    <i class="fas fa-wrench"></i>
                                    <strong>Service:</strong>
                                    <span>{{ $demande->servicePanne->titre }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-tags"></i>
                                    <strong>Category:</strong>
                                    <span>{{ $demande->servicePanne->categoryPane->titre }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-euro-sign"></i>
                                    <strong>Package:</strong>
                                    <span>{{ $demande->forfait->nomForfait }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <span class="created-date">
                                <i class="far fa-clock"></i>
                                CreatedAt {{ $demande->created_at->format('d/m/Y H:i') }}
                            </span>
                            @if($demande->date_maintenance)
                                <span class="rdv-date">
                                    <i class="far fa-calendar-alt"></i>
                                    RDV: {{ $demande->date_maintenance->format('d/m/Y H:i') }}
                                </span>
                            @endif
                            <a href="{{ route('ateliers.show', $demande->id) }}" class="btn-details">
                                <i class="fas fa-eye"></i>
                                Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Filter functionality
        document.getElementById('applyFilter').addEventListener('click', function() {
            const status = document.getElementById('statusFilter').value;
            const cards = document.querySelectorAll('.request-card');

            cards.forEach(card => {
                if(status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    // Add smooth animation
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            // Show empty state if no cards visible
            setTimeout(() => {
                const visibleCards = Array.from(cards).filter(card =>
                    card.style.display !== 'none'
                );

                if (visibleCards.length === 0) {
                    showEmptyState();
                } else {
                    hideEmptyState();
                }
            }, 400);
        });

        function showEmptyState() {
            const container = document.querySelector('.requests-grid');
            const existingEmpty = document.querySelector('.empty-state');

            if (!existingEmpty && container) {
                const emptyState = document.createElement('div');
                emptyState.className = 'empty-state';
                emptyState.style.gridColumn = '1 / -1';
                emptyState.innerHTML = `
                    <i class="fas fa-search"></i>
                    <h3>Aucune demande trouvée</h3>
                    <p>Aucune demande ne correspond aux critères de filtrage sélectionnés.</p>
                `;
                container.appendChild(emptyState);
            }
        }

        function hideEmptyState() {
            const emptyState = document.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }
        }

        // Add click animation to cards
        document.querySelectorAll('.request-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.btn-details')) {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                }
            });
        });

        // Initialize with smooth entrance animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.request-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
