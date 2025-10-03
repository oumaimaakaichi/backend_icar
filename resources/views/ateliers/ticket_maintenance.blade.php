<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Tickets Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #B4DEBD;
            --primary-dark: #9ac9a4;
            --secondary: #BBDCE5;
            --accent: #D9E9CF;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --dark: #2c3e50;
            --light: #f8fafc;
            --border: #e2e8f0;
            --surface: #ffffff;
            --text: #2c3e50;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: var(--text);
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(250, 250, 250, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(187, 220, 229, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 50% 20%, rgba(255, 255, 255, 0.3) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container-wrapper {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;


        }

        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, black 0%, black 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            background: linear-gradient(135deg, #468A9A 0%, #468A9A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-modern {
            background: linear-gradient(135deg, #B4DEBD 0%, #9ac9a4 100%);
            border: none;
            border-radius: 16px;
            color: white;
            padding: 14px 32px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(180, 222, 189, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-modern:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(180, 222, 189, 0.5);
            color: white;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(900px, 1fr));
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease-out;
            width: 1300px
        }

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

        .ticket-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 1300px
        }

        .ticket-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #B4DEBD 0%, #BBDCE5 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .ticket-card:hover::before {
            transform: scaleX(1);
        }

        .ticket-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
        }

        .ticket-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #B4DEBD 0%, #BBDCE5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 24px rgba(180, 222, 189, 0.3);
        }

        .ticket-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }

        .status-in-progress {
            background: rgba(6, 182, 212, 0.15);
            color: #0891b2;
        }

        .status-resolved {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .status-closed {
            background: rgba(100, 116, 139, 0.15);
            color: #475569;
        }

        .ticket-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .ticket-meta {
            display: flex;
            gap: 1.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .meta-item i {
            color: #B4DEBD;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: 1.25rem;
        }

        .action-btn {
            flex: 1;
            padding: 10px;
            border-radius: 12px;
            border: 2px solid var(--border);
            background: white;
            color: var(--text);
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #B4DEBD 0%, #BBDCE5 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .empty-state-icon {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .empty-state h5 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
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

        .modal-header {
            background: linear-gradient(135deg, #BBDCE5 0%, #BBDCE5 100%);
            padding: 2rem;
            border: none;
        }

        .modal-title {
            color: rgb(15, 15, 15);
            font-weight: 700;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid var(--border);
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: #B4DEBD;
            box-shadow: 0 0 0 4px rgba(180, 222, 189, 0.2);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .ticket-detail-section {
            background: var(--light);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #B4DEBD;
        }

        .detail-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: rgb(40, 37, 37);
        }

        .icon-question {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .icon-response {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .icon-waiting {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .detail-content {
            line-height: 1.7;
            color: var(--text);
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
        }

        .no-response {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
            font-style: italic;
            background: rgba(245, 158, 11, 0.08);
            border-radius: 12px;
        }

        .alert {
            border-radius: 16px;
            border: none;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .page-link {
            border: none;
            border-radius: 10px;
            margin: 0 4px;
            padding: 10px 16px;
            color: #B4DEBD;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #B4DEBD 0%, #BBDCE5 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(180, 222, 189, 0.4);
        }

        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('Sidebar.sidebarAtelier')

        <!-- Main Content -->
        <div class="container-wrapper" style="margin-top: 100px , width:1400px">
            <!-- Header -->
            <div class="page-header" style="margin-top: 100px">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h1 class="page-title">
                        <i class="bi bi-ticket-perforated"></i>
                        Maintenance Tickets
                    </h1>
                    <button class="btn-modern" data-bs-toggle="modal" data-bs-target="#addTicketModal">
                        <i class="bi bi-plus-circle me-2"></i>New Ticket
                    </button>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <!-- Tickets Grid -->
            <div class="cards-grid" id="tickets-grid">
                @foreach ($tickets as $ticket)
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="ticket-icon-wrapper">
                            <i class="bi bi-{{
                                $ticket->type == 'Hardware' ? 'cpu' :
                                ($ticket->type == 'Software' ? 'code-slash' :
                                ($ticket->type == 'Réseau' ? 'wifi' : 'tools'))
                            }}"></i>
                        </div>
                        @php
                            $statusClass = [
                                'en attente' => 'pending',
                                'en cours'   => 'in-progress',
                                'résolu'     => 'resolved',
                                'Traite'     => 'resolved',
                                'fermé'      => 'closed'
                            ][$ticket->statut] ?? 'pending';

                            $statusIcon = [
                                'en attente' => 'clock',
                                'en cours'   => 'gear',
                                'résolu'     => 'check-circle',
                                'Traite'     => 'check-circle',
                                'fermé'      => 'x-circle'
                            ][$ticket->statut] ?? 'clock';

                            $statusLabel = $ticket->statut == 'en attente' ? 'Pending' : ($ticket->statut == 'Traite' ? 'Resolved' : $ticket->statut);
                        @endphp
                        <span class="ticket-status status-{{ $statusClass }}">
                            <i class="bi bi-{{ $statusIcon }}"></i>{{ $statusLabel }}
                        </span>
                    </div>
                    <h3 class="ticket-title">{{ $ticket->titre }}</h3>
                    <p class="text-muted mb-0">{{ Str::limit($ticket->message, 80) }}</p>
                    <div class="ticket-meta">
                        <span class="meta-item">
                            <i class="bi bi-tag"></i>{{ $ticket->type }}
                        </span>
                        <span class="meta-item">
                            <i class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="action-buttons">
                        <button class="action-btn view-ticket-btn"
                            data-ticket-id="{{ $ticket->id }}"
                            data-ticket-title="{{ $ticket->titre }}"
                            data-ticket-type="{{ $ticket->type }}"
                            data-ticket-status="{{ $ticket->statut }}"
                            data-ticket-date="{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}"
                            data-ticket-message="{{ $ticket->message }}"
                            data-ticket-response="{{ $ticket->reponse ?? '' }}">
                            <i class="bi bi-eye"></i>View
                        </button>
                    </div>
                </div>
                @endforeach

                @if($tickets->isEmpty())
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-inbox empty-state-icon"></i>
                        <h5>No maintenance tickets found</h5>
                        <p>Create your first ticket by clicking the "New Ticket" button</p>
                    </div>
                </div>
                @endif
            </div>

            @if($tickets->isNotEmpty())
            <div class="pagination mt-4">
                {{ $tickets->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Add Ticket Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Create New Ticket
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('assistance.store') }}" class="needs-validation" novalidate>
                        @csrf
                        @if(isset($atelier) && $atelier)
                            <input type="hidden" name="atelier_id" value="{{ $atelier->id }}">
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i> Aucun atelier n'est associé à votre compte.
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="titre" placeholder="Brief description of the issue" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" required>
                                <option value="">Select type...</option>
                                <option value="Hardware">🔧 Request for Information</option>
                                <option value="Autre">🔄 Others</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="message" rows="5" placeholder="Describe the problem in detail..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn-modern" @if(!isset($atelier) || !$atelier) disabled @endif>
                                <i class="bi bi-send-check me-2"></i>Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Ticket Modal -->
   <div class="modal fade" id="viewTicketModal" tabindex="-1" aria-labelledby="viewTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewTicketModalLabel" style="color:rgb(84, 81, 81)">
                        <i class="bi bi-eye me-2"></i><b style="color: black">Ticket Details</b>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                        'Traite': 'success',
                        'fermé': 'secondary'
                    }[ticketStatus] || 'secondary';

                    const statusIcon = {
                        'en attente': 'clock',
                        'en cours': 'gear',
                        'Traite': 'check-circle',
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
