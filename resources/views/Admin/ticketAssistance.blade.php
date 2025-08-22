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

        .status-en-attente {
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
    <div class="stat-number">{{ $tickets->where('statut', 'en attente')->count() }}</div>
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
                                               title="Reply to Ticket"
>
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


            </div>
        </div>
    </div>

    <!-- Modal pour voir les détails du ticket -->
  <div class="modal fade" id="ticketViewModal" tabindex="-1" aria-labelledby="ticketViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                        <div class="mb-3">
                            <label class="form-label-modern">Ticket ID</label>
                            <input type="text" class="form-control form-control-modern readonly-field" id="view-id" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label-modern">User</label>
                            <input type="text" class="form-control form-control-modern readonly-field" id="view-user" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label-modern">Title</label>
                            <input type="text" class="form-control form-control-modern readonly-field" id="view-titre" readonly>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">
                    <i class="fas fa-reply me-2"></i>Reply to Ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info border-0" style="background: linear-gradient(135deg, rgba(74, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%); border-left: 4px solid #4facfe !important;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 text-info"></i>
                        <div>
                            <strong>Ticket:</strong> <span id="reply-ticket-titre"></span><br>
                            <strong>User:</strong> <span id="reply-ticket-user"></span>
                        </div>
                    </div>
                </div>

                <form id="replyForm">
                    @csrf
                    <input type="hidden" id="reply_ticket_id" name="ticket_id">

                    <div class="mb-3">
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

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="markAsResolved" checked>
                        <label class="form-check-label fw-bold" for="markAsResolved">
                            <i class="fas fa-check-circle me-2 text-success"></i>
                            Mark ticket as resolved
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background: #6c757d; color: white; border-radius: 25px;" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" form="replyForm" class="btn btn-modern btn-success-modern">
                    <span class="loading-spinner spinner-border spinner-border-sm me-2" role="status"></span>
                    <i class="fas fa-paper-plane me-2"></i>Send Response
                </button>
            </div>
        </div>
    </div>
</div>


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

        // Préparer le modal de réponse
        $('.reply-ticket').click(function() {
            const ticketId = $(this).data('id');
            const titre = $(this).data('titre');
            const user = $(this).data('user');

            $('#reply_ticket_id').val(ticketId);
            $('#reply-ticket-titre').text(titre);
            $('#reply-ticket-user').text(user);
            $('#reply-text').val('');
            $('#markAsResolved').prop('checked', true);
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
