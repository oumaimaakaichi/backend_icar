<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tickets d'assistance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f5f5f6 0%, #f5f5f6 100%);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(102, 126, 234, 0.1);
            color: #567288;
            border-right: 3px solid #667eea;
        }

        .sidebar-nav i {
            width: 20px;
            margin-right: 0.75rem;
        }

        /* Main Content */
        .main-content {
            min-height: 100vh;
        }

        /* Header */
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #666;
            margin: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .stat-card.pending::before {
            background: linear-gradient(90deg, #959fca, #444a62);
        }

        .stat-card.resolved::before {
            background: linear-gradient(90deg, #4a5d4e, #4a5d4e);
        }

        .stat-card.total::before {
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-weight: 500;
        }

        /* Main Card */
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #f6f6f8, #f9fafb);
            color: white;
            padding: 0.5rem 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            padding: 10px
        }

        /* Table */
        .table-container {
            padding: 0;
        }

        .modern-table {
            margin: 0;
        }

        .modern-table thead th {
            background: #567288;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: #ffffff;
            font-size: 0.9rem;
            margin-left: 50px
        }

        .modern-table tbody tr {
            border: none;
            transition: background-color 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .modern-table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        /* User Avatar */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f6184, #4f6184);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-details h6 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .user-role {
            font-size: 0.8rem;
            color: #666;
            margin: 0;
        }

        /* Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .status-Pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-traite {
            background: #d1edff;
            color: #0c5460;
        }

        .status-ferme {
            background: #f8d7da;
            color: #721c24;
        }

        .type-badge {
            background: #e7f3ff;
            color: #0066cc;
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-view {
            background: #e7f3ff;
            color: #0066cc;
        }

        .btn-reply {
            background: #e8f5e8;
            color: #28a745;
        }

        .btn-close-ticket {
            background: #ffe6e6;
            color: #dc3545;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        /* Pagination Styles */
        .pagination-container {
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pagination {
            margin: 0;
            display: flex;
            gap: 0.5rem;
        }

        .page-item {
            list-style: none;
        }

        .page-link {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            color: #567288;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #4f6184, #3a4a6b);
            border-color: #4f6184;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination-info {
            margin-left: 1rem;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Modals */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #4f6184, #4f6184);
            color: white;
            border: none;
            border-radius: 20px 20px 0 0;
        }

        .modal-title {
            font-weight: 600;
        }

        .form-label-modern {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control-modern {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem;
            transition: border-color 0.3s ease;
        }

        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .readonly-field {
            background: #f8f9fa;
            color: #6c757d;
        }

        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, #56ab2f, #a8e6cf);
            color: white;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Success Alert */
        .alert-success-modern {
            background: linear-gradient(135deg, rgba(86, 171, 47, 0.1), rgba(168, 230, 207, 0.1));
            border: 1px solid #56ab2f;
            border-radius: 12px;
            color: #155724;
            border-left: 4px solid #56ab2f;
        }

        .loading-spinner {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
            }

            .pagination-info {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebar')

    <!-- Main Content -->
    <div class="container py-5" style="margin-top: 50px ; margin-right:60px">
        <!-- Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-headset me-3"></i>Support Center
            </h1>
            <p class="page-subtitle">Manage all your support tickets in real time</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-number">{{ $tickets->where('statut', 'Pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card resolved">
                <div class="stat-number">{{ $tickets->where('statut', 'traite')->count() }}</div>
                <div class="stat-label">Resolved</div>
            </div>
            <div class="stat-card total">
                <div class="stat-number">{{ $tickets->where('statut', 'ferme')->count() }}</div>
                <div class="stat-label">Closed</div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success-modern alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Table Card -->
        <div class="main-card">
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user me-2"></i>User</th>
                                <th><i class="fas fa-tag me-2"></i>Type</th>
                                <th><i class="fas fa-traffic-light me-2"></i>Status</th>
                                <th><i class="fas fa-calendar me-2"></i>Date</th>
                                <th><i class="fas fa-cogs me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>
                                    @if($ticket->user)
                                        <div class="user-info">
                                            <div class="avatar">
                                                {{ strtoupper(substr($ticket->user->prenom, 0, 1) . substr($ticket->user->nom, 0, 1)) }}
                                            </div>
                                            <div class="user-details">
                                                <h6>{{ $ticket->user->prenom }} {{ $ticket->user->nom }}</h6>
                                                <p class="user-role">"{{ $ticket->user->role }}"</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="user-info">
                                            <div class="avatar">??</div>
                                            <div class="user-details">
                                                <h6>Utilisateur inconnu</h6>
                                                <p class="user-role">N/A</p>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="type-badge">{{ $ticket->type }}</span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ str_replace(' ', '-', $ticket->statut) }}">
                                        {{ $ticket->statut }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $ticket->created_at->format('d/m/Y') }}</strong><br>
                                    <small class="text-muted">{{ $ticket->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view view-ticket"
                                                data-bs-toggle="modal"
                                                data-bs-target="#ticketViewModal"
                                                data-id="{{ $ticket->id }}"
                                                data-user="{{ $ticket->user ? $ticket->user->prenom . ' ' . $ticket->user->nom : 'Utilisateur inconnu' }}"
                                                data-titre="{{ $ticket->titre }}"
                                                data-type="{{ $ticket->type }}"
                                                data-message="{{ $ticket->message }}"
                                                data-reponse="{{ $ticket->reponse }}"
                                                data-statut="{{ $ticket->statut }}"
                                                data-date="{{ $ticket->created_at->format('d/m/Y H:i') }}"
                                                title="View details">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="action-btn btn-reply reply-ticket"
                                                data-bs-toggle="modal"
                                                data-bs-target="#replyModal"
                                                data-id="{{ $ticket->id }}"
                                                data-titre="{{ $ticket->titre }}"
                                                data-user="{{ $ticket->user ? $ticket->user->prenom . ' ' . $ticket->user->nom : 'Utilisateur inconnu' }}"
                                               data-message="{{ $ticket->message }}"
                                                title="Reply to Ticket">
                                            <i class="fas fa-reply"></i>
                                        </button>

                                        @if($ticket->statut != 'ferme')
                                        <button class="action-btn btn-close-ticket close-ticket"
                                                data-id="{{ $ticket->id }}"
                                                title="Close ticket">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if ($tickets->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $tickets->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i></a>
                            </li>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                            @if ($page == $tickets->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($tickets->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $tickets->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>


                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour voir les détails du ticket -->
    <div class="modal fade" id="ticketViewModal" tabindex="-1" aria-labelledby="ticketViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketViewModalLabel">
                        <i class="fas fa-ticket-alt me-2"></i>Ticket Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-modern">User</label>
                                <input type="text" class="form-control form-control-modern readonly-field" id="view-user" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-modern">Type</label>
                                <input type="text" class="form-control form-control-modern readonly-field" id="view-type" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-modern">Status</label>
                                <input type="text" class="form-control form-control-modern readonly-field" id="view-statut" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label-modern">Created Date</label>
                                <input type="text" class="form-control form-control-modern readonly-field" id="view-date" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-modern">Message</label>
                        <textarea class="form-control form-control-modern readonly-field" id="view-message" rows="4" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-modern">Current Response</label>
                        <textarea class="form-control form-control-modern readonly-field" id="view-reponse" rows="3" readonly placeholder="No response yet"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modern btn-primary-modern" data-bs-dismiss="modal" style="background-color: #4f6184 ; color:white">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to reply to ticket -->
  <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #4f6184, #3a4a6b);">
                <h5 class="modal-title text-white" id="replyModalLabel">
                    <i class="fas fa-reply me-2"></i>Reply to Ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Information Sidebar -->
                    <div class="col-md-3 bg-light" style="border-right: 1px solid #e9ecef;">
                        <div class="p-4">
                            <div class="text-center mb-4">
                                <div class="ai-icon mx-auto">
                                    <i class="fas fa-ticket-alt text-white"></i>
                                </div>
                                <h6 class="mt-2 mb-1 fw-bold">Ticket Details</h6>
                            </div>

                            <div class="ticket-info">


                                <div class="info-item mb-3">
                                    <small class="text-muted d-block">User</small>
                                    <span class="fw-semibold" id="sidebar-ticket-user">{{ $ticket->user->prenom }} {{ $ticket->user->nom }}</span>
                                </div>

                                <div class="info-item mb-3">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </div>

                                <hr>

                                <div class="quick-actions">
                                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                                    <button class="btn btn-outline-primary btn-sm w-100 mb-2" id="generate-ai-response">
                                        <i class="fas fa-robot me-1"></i>Generate AI Response
                                    </button>
                                    <button class="btn btn-outline-success btn-sm w-100 mb-2" id="use-ai-response" disabled>
                                        <i class="fas fa-check me-1"></i>Use AI Response
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm w-100" id="regenerate-ai-response" disabled>
                                        <i class="fas fa-sync-alt me-1"></i>Regenerate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-9">
                        <div class="p-4">
                            <!-- AI Assistant Section -->
                            <div class="ai-assistant mb-4">
                                <div class="ai-header">
                                    <div class="ai-icon">
                                        <i class="fas fa-robot text-white"></i>
                                    </div>
                                    <h5 class="mb-0">AI Assistant</h5>
                                </div>

                                <div class="ai-content mt-3">
                                    <div class="mb-3">
                                        <label class="form-label-modern">
                                            <i class="fas fa-user-circle me-2"></i>Client Question
                                        </label>
                                        <div class="client-question" id="client-question" style="min-height: 60px;">
                                            <em class="text-muted">The client's message will appear here...</em>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label-modern">
                                            <i class="fas fa-comment-dots me-2"></i>AI Generated Response
                                        </label>
                                        <div class="ai-response" id="ai-response" style="min-height: 120px;">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <div class="text-center text-muted">
                                                    <i class="fas fa-robot fa-2x mb-2"></i>
                                                    <p>Click on "Generate Response" to get a suggestion</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="replyForm">
                                @csrf
                                <input type="hidden" id="reply_ticket_id" name="ticket_id">

                                <div class="mb-4">
                                    <label for="reply-text" class="form-label-modern">
                                        <i class="fas fa-pen me-2"></i>Your Response <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-modern"
                                              id="reply-text"
                                              name="reponse"
                                              rows="6"
                                              required
                                              placeholder="Type your detailed response here..."></textarea>
                                    <small class="form-text text-muted mt-2">
                                        <i class="fas fa-lightbulb me-1"></i>
                                        This response will be sent to the user and the ticket will be marked as resolved.
                                    </small>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="markAsResolved" checked>
                                    <label class="form-check-label fw-bold" for="markAsResolved">
                                        <i class="fas fa-check-circle me-2 text-success"></i>
                                        Mark the ticket as resolved
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="replyForm" class="btn btn-success">
                    <span class="loading-spinner spinner-border spinner-border-sm me-2" role="status"></span>
                    <i class="fas fa-paper-plane me-2"></i>Send Response
                </button>
            </div>
        </div>
    </div>
</div>


    <style>
        .ai-assistant {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e0e7ff;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .ai-assistant::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 6px 0 0 6px;
        }

        .ai-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            position: relative;
        }

        .ai-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .ai-header h5 {
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            font-size: 1.25rem;
        }

        #generate-ai-response {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        #generate-ai-response:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .ai-content {
            position: relative;
        }

        .form-label-modern {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            margin-top: 0;
        }

        .form-label-modern i {
            margin-right: 0.5rem;
            color: #667eea;
        }

        .client-question, .ai-response {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            border: 2px solid #e9ecef;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .client-question {
            border-left: 4px solid #4f6184;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

    .ai-response {
        border-left: 4px solid #667eea;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        min-height: 120px;
    }

    .client-question:hover, .ai-response:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .message-content {
        line-height: 1.6;
        color: #2d3748;
        font-size: 0.95rem;
    }

    .ai-response.loading {
        background: linear-gradient(90deg, #f8f9fa, #e9ecef, #f8f9fa);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border: 2px dashed #dee2e6;
    }

    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .ai-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        justify-content: center;
    }

    #use-ai-response, #regenerate-ai-response {
        border-radius: 20px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid;
    }

    #use-ai-response {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        border-color: #48bb78;
    }

    #use-ai-response:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    }

    #regenerate-ai-response {
        background: white;
        color: #4a5568;
        border-color: #e2e8f0;
    }

    #regenerate-ai-response:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: #f7fafc;
    }

    #use-ai-response:disabled, #regenerate-ai-response:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* Améliorations pour le formulaire de réponse */
    #replyForm {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid #e9ecef;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    #reply-text {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    #reply-text:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }

    /* Style pour les badges d'état dans la réponse IA */
    .ai-response .message-content {
        position: relative;
    }

    .ai-response .text-muted {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    /* Animation pour l'apparition des réponses */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .ai-response .message-content {
        animation: fadeIn 0.5s ease-out;
    }

    /* Style pour les états de chargement */
    .loading-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #667eea;
    }

    .loading-content i {
        margin-bottom: 0.5rem;
    }

    /* Responsive design pour l'assistant IA */
    @media (max-width: 768px) {
        .ai-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .ai-header h5 {
            margin: 0.5rem 0;
        }

        .ai-actions {
            flex-direction: column;
        }

        #use-ai-response, #regenerate-ai-response {
            width: 100%;
        }
    }
</style>
<script>
    $(document).ready(function() {
           let currentTicketMessage = '';

        // Préparer le modal de réponse avec le message du client
        $('.reply-ticket').click(function() {
            const ticketId = $(this).data('id');
            const titre = $(this).data('titre');
            const user = $(this).data('user');
            const message = $(this).data('message'); // Récupérer le message

            $('#reply_ticket_id').val(ticketId);
            $('#reply-ticket-titre').text(titre);
            $('#reply-ticket-user').text(user);
            $('#reply-text').val('');
            $('#markAsResolved').prop('checked', true);

            // Stocker le message du client pour l'utiliser avec l'IA
            currentTicketMessage = message;

            // Afficher le message du client
            if (message && message.trim() !== '') {
                $('#client-question').html('<div class="message-content">' + message + '</div>');
            } else {
                $('#client-question').html('<em class="text-muted">Aucun message disponible</em>');
            }

            // Réinitialiser la réponse IA
            $('#ai-response').html(`
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-center text-muted">
                        <i class="fas fa-robot fa-2x mb-2"></i>
                        <p>Cliquez sur "Générer une réponse" pour obtenir une suggestion</p>
                    </div>
                </div>
            `);

            // Désactiver les boutons d'action IA
            $('#use-ai-response, #regenerate-ai-response').prop('disabled', true);
        });
        // Générer une réponse IA
        $('#generate-ai-response').click(function() {
            if (!currentTicketMessage) {
                showToast('Aucun message client disponible', 'error');
                return;
            }

            const generateBtn = $(this);
            const aiResponseContainer = $('#ai-response');

            // Afficher l'indicateur de chargement
            generateBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Génération...');
            aiResponseContainer.addClass('loading').html(`
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin fa-2x mb-2 text-primary"></i>
                        <p>L'assistant IA génère une réponse...</p>
                    </div>
                </div>
            `);

            // Appeler l'API chatbot
            $.ajax({
                url: 'http://127.0.0.1:8000/api/chatbot',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    question: currentTicketMessage
                }),
                success: function(response) {
                    // Afficher la réponse de l'IA
                    aiResponseContainer.removeClass('loading').html(`
                        <div class="message-content">${response.answer}</div>
                        <small class="text-muted position-absolute bottom-0 end-0 me-2 mb-1">
                            <i class="fas fa-robot me-1"></i>Généré par l'IA
                        </small>
                    `);

                    // Activer les boutons d'action
                    $('#use-ai-response, #regenerate-ai-response').prop('disabled', false);

                    showToast('Réponse IA générée avec succès!', 'success');
                },
                error: function(xhr) {
                    aiResponseContainer.removeClass('loading').html(`
                        <div class="alert alert-danger m-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Erreur lors de la génération de la réponse. Veuillez réessayer.
                        </div>
                    `);
                    showToast('Erreur lors de l\'appel de l\'API chatbot', 'error');
                },
                complete: function() {
                    generateBtn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i>Générer une réponse');
                }
            });
        });

        // Utiliser la réponse IA générée
        $('#use-ai-response').click(function() {
            const aiResponse = $('#ai-response .message-content').text();
            if (aiResponse) {
                $('#reply-text').val(aiResponse);
                showToast('Réponse IA insérée dans le champ de réponse', 'success');
            }
        });

        // Regénérer une réponse IA
        $('#regenerate-ai-response').click(function() {
            $('#generate-ai-response').click();
        });

        // Fonction pour afficher des toasts modernes
        function showToast(message, type = 'success') {
            const toastId = 'toast-' + Date.now();
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';

            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0 position-fixed"
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 15px;" role="alert">
                    <div class="d-flex">
                        <div class="toast-body d-flex align-items-center">
                            <i class="fas ${iconClass} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            $('body').append(toastHtml);
            const toast = new bootstrap.Toast(document.getElementById(toastId), {
                autohide: true,
                delay: 4000
            });
            toast.show();

            // Supprimer l'élément après fermeture
            $(`#${toastId}`).on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }
    });
</script>


    <script>
    $(document).ready(function() {
        // Configuration AJAX pour CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Afficher les détails du ticket dans le modal de visualisation
        $('.view-ticket').click(function() {
            $('#view-id').val('#' + $(this).data('id'));
            $('#view-user').val($(this).data('user'));
            $('#view-titre').val($(this).data('titre'));
            $('#view-type').val($(this).data('type'));
            $('#view-message').val($(this).data('message'));
            $('#view-reponse').val($(this).data('reponse') || '');
            $('#view-statut').val($(this).data('statut'));
            $('#view-date').val($(this).data('date'));
        });


        // Fermer un ticket sans réponse
        $(document).on('click', '.close-ticket', function() {
            const ticketId = $(this).data('id');

            if (confirm('Êtes-vous sûr de vouloir fermer ce ticket sans réponse ?')) {
                $.ajax({
                    url: `/tickets/${ticketId}/close`,
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        showToast(response.message || 'Ticket fermé avec succès!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        showToast('Erreur lors de la fermeture du ticket', 'error');
                    }
                });
            }
        });

        // Envoyer la réponse via AJAX
        $('#replyForm').submit(function(e) {
            e.preventDefault();

            const ticketId = $('#reply_ticket_id').val();
            const reponse = $('#reply-text').val().trim();
            const submitBtn = $('button[type="submit"][form="replyForm"]');
            const spinner = submitBtn.find('.loading-spinner');

            if (!reponse) {
                $('#reply-text').addClass('is-invalid');
                setTimeout(() => $('#reply-text').removeClass('is-invalid'), 3000);
                showToast('Veuillez saisir une réponse avant d\'envoyer.', 'error');
                return;
            }

            spinner.show();
            submitBtn.prop('disabled', true);

            $.ajax({
                url: `/api/tickets/${ticketId}/reply`,
                type: 'POST',
                data: {
                    reponse: reponse,
                    _token: $('input[name="_token"]').val()
                },
                success: function(response) {
                    showToast(response.message || 'Réponse enregistrée avec succès!', 'success');
                    $('#replyModal').modal('hide');
                    setTimeout(() => location.reload(), 2000);
                },
                error: function(xhr) {
                    let errorMessage = 'Une erreur est survenue lors de l\'envoi de la réponse.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showToast(errorMessage, 'error');
                },
                complete: function() {
                    spinner.hide();
                    submitBtn.prop('disabled', false);
                }
            });
        });

        // Réinitialiser le modal quand il se ferme
        $('#replyModal').on('hidden.bs.modal', function() {
            $('#replyForm')[0].reset();
            $('#reply_ticket_id').val('');
            $('.loading-spinner').hide();
            $('button[type="submit"][form="replyForm"]').prop('disabled', false);
            $('#reply-text').removeClass('is-invalid');
        });

        // Fonction pour afficher des toasts modernes
        function showToast(message, type = 'success') {
            const toastId = 'toast-' + Date.now();
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';

            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0 position-fixed"
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-radius: 15px;" role="alert">
                    <div class="d-flex">
                        <div class="toast-body d-flex align-items-center">
                            <i class="fas ${iconClass} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            $('body').append(toastHtml);
            const toast = new bootstrap.Toast(document.getElementById(toastId), {
                autohide: true,
                delay: 4000
            });
            toast.show();

            // Supprimer l'élément après fermeture
            $(`#${toastId}`).on('hidden.bs.toast', function() {
                $(this).remove();
            });
        }

        // Animation au survol des cartes de statistiques
        $('.stat-card').hover(
            function() {
                $(this).find('.stat-number').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.stat-number').removeClass('animate__animated animate__pulse');
            }
        );

        // Ajouter le CSS pour les animations
        $('<style>').text(`
            .is-invalid {
                border-color: #dc3545 !important;
                animation: shake 0.5s ease-in-out;
            }

            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }

            .toast {
                backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }

            .animate__animated {
                animation-duration: 1s;
            }

            .animate__pulse {
                animation-name: pulse;
            }

            @keyframes pulse {
                from {
                    transform: scale3d(1, 1, 1);
                }
                50% {
                    transform: scale3d(1.05, 1.05, 1.05);
                }
                to {
                    transform: scale3d(1, 1, 1);
                }
            }
        `).appendTo('head');

    });
    </script>
</body>
</html>

