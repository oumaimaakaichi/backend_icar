<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Tickets Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #1e293b;
            --light: #f8fafc;
            --border: #e2e8f0;
            --surface: #ffffff;
            --surface-hover: #f1f5f9;
            --text: #334155;
            --text-muted: #64748b;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #d4d5d6 0%, #d4d5d6 100%);
            min-height: 100vh;
            color: var(--text);
            overflow-x: hidden;
            width: 1000px
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 700%;
            height: 100%;
            background: linear-gradient(135deg, #eeeded 0%, #ffffff 100%);
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
               z-index: -1;
        }

        .main-content {
            background: transparent;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .header-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            margin-top: 80px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-lg);
        }

        .page-title {
            background: linear-gradient(135deg, black 0%, black 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin: 0;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-gradient:hover::before {
            left: 100%;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
            color: white;
        }

        .ticket-table {
            background: transparent;
        }

        .ticket-table thead {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .ticket-table thead th {
            border: none;
            font-weight: 600;
            color: var(--text);
            padding: 1.5rem 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ticket-table tbody tr {
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ticket-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transform: scale(1.005);
        }

        .ticket-table tbody td {
            border: none;
            padding: 1.5rem 1rem;
            vertical-align: middle;
        }

        .ticket-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: var(--shadow);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid;
        }

        .badge-warning {
            color: var(--warning);
            border-color: var(--warning);
            background-color: rgba(245, 158, 11, 0.1);
        }

        .badge-info {
            color: var(--info);
            border-color: var(--info);
            background-color: rgba(6, 182, 212, 0.1);
        }

        .badge-success {
            color: var(--success);
            border-color: var(--success);
            background-color: rgba(16, 185, 129, 0.1);
        }

        .badge-secondary {
            color: var(--secondary);
            border-color: var(--secondary);
            background-color: rgba(100, 116, 139, 0.1);
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            color: var(--text);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(20px);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 20px 20px 0 0;
            border: none;
            padding: 2rem;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid var(--border);
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            background: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
            border-left: 4px solid var(--warning);
        }

        .pagination .page-link {
            border-radius: 8px;
            border: none;
            color: var(--primary);
            margin: 0 2px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            color: white;
        }

        .btn-outline-secondary {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 12px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-outline-secondary:hover {
            background: var(--secondary);
            border-color: var(--secondary);
            color: white;
        }

        /* Ticket Detail Modal Styles */
        .ticket-detail-section {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
        }

        .ticket-detail-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .question-icon {
            background: linear-gradient(135deg, var(--info), #0891b2);
            color: white;
        }

        .response-icon {
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
        }

        .no-response-icon {
            background: linear-gradient(135deg, var(--warning), #d97706);
            color: white;
        }

        .detail-content {
            line-height: 1.6;
            color: var(--text);
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .no-response {
            font-style: italic;
            color: var(--text-muted);
            text-align: center;
            padding: 2rem;
            background: rgba(245, 158, 11, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--warning);
        }

        .ticket-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .meta-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .meta-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .meta-value {
            font-weight: 500;
            color: var(--text);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.75rem;
            }

            .header-section {
                padding: 1.5rem;
            }

            .ticket-meta {
                grid-template-columns: 1fr;
            }
        }

        /* Animation keyframes */
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

        .slide-in-up {
            animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('Sidebar.sidebarAtelier')

        <!-- Main Content -->
        <div class="container py-5" style="width:1200px;margin-top: 0px; margin-right: 0px;">
            <div class="container-fluid py-4">
                <!-- Messages de notification -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show slide-in-up" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show slide-in-up" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Header Section -->
                <div class="header-section slide-in-up">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h1 class="page-title">
                            <i class="bi bi-list-ul"></i>
                            Maintenance Tickets
                        </h1>
                        <button class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#addTicketModal" style="color: white">
                            <i class="bi bi-plus-circle me-2"></i>Add Ticket
                        </button>
                    </div>
                </div>

                <!-- Tickets Table -->
                <div class="glass-card slide-in-up" style="animation-delay: 0.2s;">
                    <div class="table-responsive">
                        <table class="table ticket-table mb-0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="ps-4 py-3 fw-semibold">Ticket</th>
                                    <th class="py-3 fw-semibold">Type</th>
                                    <th class="py-3 fw-semibold">Statut</th>
                                    <th class="py-3 fw-semibold">Date</th>
                                    <th class="pe-4 py-3 fw-semibold text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="ticket-icon me-3">
                                                <i class="bi bi-ticket-detailed"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $ticket->titre }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-{{
                                                $ticket->type == 'Hardware' ? 'cpu' :
                                                ($ticket->type == 'Software' ? 'code-slash' :
                                                ($ticket->type == 'Réseau' ? 'wifi' : 'tools'))
                                            }} me-2 text-primary"></i>
                                            {{ $ticket->type }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $statusClass = [
                                                'en attente' => 'warning',
                                                'en cours'   => 'info',
                                                'résolu'     => 'success',
                                                'fermé'      => 'secondary'
                                            ][$ticket->statut] ?? 'secondary';

                                            $statusLabel = $ticket->statut == 'en attente'
                                                ? 'Pending'
                                                : $ticket->statut;
                                        @endphp

                                        <span class="status-badge badge-{{ $statusClass }}">
                                            <i class="bi bi-{{
                                                $ticket->statut == 'en attente' ? 'clock' :
                                                ($ticket->statut == 'en cours' ? 'gear' :
                                                ($ticket->statut == 'résolu' ? 'check-circle' : 'x-circle'))
                                            }} me-1"></i>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($ticket->created_at)->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="btn-group" role="group">
                                            <button class="action-btn view-ticket-btn" title="View"
                                                data-ticket-id="{{ $ticket->id }}"
                                                data-ticket-title="{{ $ticket->titre }}"
                                                data-ticket-type="{{ $ticket->type }}"
                                                data-ticket-status="{{ $ticket->statut }}"
                                                data-ticket-date="{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}"
                                                data-ticket-message="{{ $ticket->message }}"
                                                data-ticket-response="{{ $ticket->reponse ?? '' }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                @if($tickets->isEmpty())
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <i class="bi bi-inbox empty-state-icon"></i>
                                        <h5 class="fw-semibold">No maintenance tickets found</h5>
                                        <p class="text-muted">Create your first ticket by clicking the "Add Ticket" button</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($tickets->isNotEmpty())
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center p-4">
                        <div class="text-muted">
                            Showing <span class="fw-semibold">{{ $tickets->firstItem() }}</span> to <span class="fw-semibold">{{ $tickets->lastItem() }}</span> of <span class="fw-semibold">{{ $tickets->total() }}</span> entries
                        </div>
                        <div>
                            {{ $tickets->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1" aria-labelledby="addTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addTicketModalLabel" style="color:white">
                        <i class="bi bi-ticket-detailed me-2"></i>Create New Ticket
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{ route('assistance.store') }}" class="needs-validation" novalidate>
                        @csrf
                        @if(isset($atelier) && $atelier)
                            <input type="hidden" name="atelier_id" value="{{ $atelier->id }}">
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i> Aucun atelier n'est associé à votre compte.
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label for="titre" class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrer un titre descriptif" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="" selected disabled>Sélectionner un type</option>
                                <option value="Hardware">🔧 Request for Information</option>

                                <option value="Autre">🔄 Others</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Décrivez le problème en détail..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-gradient rounded-pill px-4" @if(!isset($atelier) || !$atelier) disabled @endif style="color: white">
                                <i class="bi bi-send-check me-2"></i>Create Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Ticket Detail Modal -->
    <div class="modal fade" id="viewTicketModal" tabindex="-1" aria-labelledby="viewTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewTicketModalLabel" style="color:white">
                        <i class="bi bi-eye me-2"></i>Ticket Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Ticket Meta Information -->
                    <div class="ticket-meta">

                        <div class="meta-item">
                            <div class="meta-label">Type</div>
                            <div class="meta-value" id="modal-ticket-type">Hardware</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Status</div>
                            <div class="meta-value">
                                <span id="modal-ticket-status" class="status-badge badge-warning">
                                    <i class="bi bi-clock me-1"></i>
                                    Pending
                                </span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Date Created</div>
                            <div class="meta-value" id="modal-ticket-date">15/09/2025 10:30</div>
                        </div>
                    </div>

                    <!-- Question Section -->
                    <div class="ticket-detail-section">
                        <div class="ticket-detail-header">
                            <div class="detail-icon question-icon">
                                <i class="bi bi-question-circle"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Question</h6>
                        </div>
                        <div class="detail-content" id="modal-ticket-question">
                            Loading question...
                        </div>
                    </div>

                    <!-- Response Section -->
                    <div class="ticket-detail-section">
                        <div class="ticket-detail-header">
                            <div class="detail-icon response-icon" id="response-icon">
                                <i class="bi bi-chat-quote"></i>
                            </div>
                            <h6 class="mb-0 fw-semibold">Response</h6>
                        </div>
                        <div id="modal-ticket-response-content">
                            <div class="detail-content" id="modal-ticket-response">
                                Loading response...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Enable tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Form validation
            (function () {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()

            // Add animation delays to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.1}s`;
                row.classList.add('slide-in-up');
            });

            // View Ticket Modal functionality
            const viewTicketButtons = document.querySelectorAll('.view-ticket-btn');
            const viewTicketModal = new bootstrap.Modal(document.getElementById('viewTicketModal'));

            viewTicketButtons.forEach(button => {
                button.addEventListener('click', function() {

                    const ticketTitle = this.getAttribute('data-ticket-title');
                    const ticketType = this.getAttribute('data-ticket-type');
                    const ticketStatus = this.getAttribute('data-ticket-status');
                    const ticketDate = this.getAttribute('data-ticket-date');
                    const ticketMessage = this.getAttribute('data-ticket-message');
                    const ticketResponse = this.getAttribute('data-ticket-response');

                    // Update modal title
                    document.getElementById('viewTicketModalLabel').innerHTML = `<i class="bi bi-eye me-2"></i>${ticketTitle}`;

                    // Update ticket meta information

                    document.getElementById('modal-ticket-type').textContent = ticketType;
                    document.getElementById('modal-ticket-date').textContent = ticketDate;

                    // Update status badge
                    const statusElement = document.getElementById('modal-ticket-status');
                    const statusClass = {
                        'en attente': 'warning',
                        'en cours': 'info',
                        'résolu': 'success',
                        'fermé': 'secondary'
                    }[ticketStatus] || 'secondary';

                    const statusIcon = {
                        'en attente': 'clock',
                        'en cours': 'gear',
                        'résolu': 'check-circle',
                        'fermé': 'x-circle'
                    }[ticketStatus] || 'x-circle';

                    const statusLabel = ticketStatus === 'en attente' ? 'Pending' : ticketStatus;

                    statusElement.className = `status-badge badge-${statusClass}`;
                    statusElement.innerHTML = `<i class="bi bi-${statusIcon} me-1"></i>${statusLabel}`;

                    // Update question
                    document.getElementById('modal-ticket-question').textContent = ticketMessage;

                    // Update response
                    const responseContainer = document.getElementById('modal-ticket-response-content');
                    const responseIcon = document.getElementById('response-icon');

                    if (ticketResponse && ticketResponse.trim() !== '') {
                        // Has response
                        responseIcon.className = 'detail-icon response-icon';
                        responseIcon.innerHTML = '<i class="bi bi-chat-quote"></i>';
                        responseContainer.innerHTML = `
                            <div class="detail-content">
                                ${ticketResponse}
                            </div>
                        `;
                    } else {
                        // No response yet
                        responseIcon.className = 'detail-icon no-response-icon';
                        responseIcon.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                        responseContainer.innerHTML = `
                            <div class="no-response">
                                <i class="bi bi-hourglass-split me-2"></i>
                                No response yet...
                            </div>
                        `;
                    }

                    // Show modal
                    viewTicketModal.show();
                });
            });
        });

        // Smooth scrolling for better UX
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
