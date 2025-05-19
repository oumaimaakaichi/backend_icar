<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Tickets</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #3a0ca3 0%, #4361ee 100%);
            color: white;
        }

        .main-content {
            padding: 20px;
            margin-left: 250px;
            transition: all 0.3s;
        }

        .ticket-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .badge-pill {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 2px;
        }

        .ticket-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link {
            color: var(--primary-color);
        }

        .empty-state {
            padding: 40px 0;
            text-align: center;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .modal-header {
            background: linear-gradient(90deg, #3a0ca3 0%, #4361ee 100%);
            color: white;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-none d-lg-block" style="width: 250px; position: fixed;">
            @include('Sidebar.sidebarAtelier')
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0 text-dark fw-bold" style="margin-top:80px">
                        <i class="bi bi-list-ul text-primary me-2"></i>Maintenance Tickets
                    </h2>
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addTicketModal">
                        <i class="bi bi-plus-circle me-2"></i>Add Ticket
                    </button>
                </div>

                <div class="card ticket-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="width: 1200px" >
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3 fw-semibold">Ticket</th>
                                        <th class="py-3 fw-semibold">Type</th>

                                        <th class="py-3 fw-semibold">Status</th>
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
                                            <span >
                                                <i class="bi bi-{{
                                                    $ticket->type == 'Hardware' ? 'cpu' :
                                                    ($ticket->type == 'Software' ? 'code-slash' : 'tools')
                                                }} me-1"></i>
                                                {{ $ticket->type }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($ticket->isVisible)
                                                <span class="badge bg-success rounded-pill">
                                                    <i class="bi bi-eye-fill me-1"></i> Visible
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">
                                                    <i class="bi bi-eye-slash-fill me-1"></i> Masqué
                                                </span>
                                            @endif
                                        </td>

                                        <td class="py-3">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($ticket->created_at)->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="pe-4 py-3 text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary action-btn" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($tickets->isEmpty())
                                    <tr>
                                        <td colspan="6" class="empty-state">
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
                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
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
    </div>

    <!-- Add Ticket Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1" aria-labelledby="addTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addTicketModalLabel">
                        <i class="bi bi-ticket-detailed me-2"></i>Create New Ticket
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('tickets.store') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="titre" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-card-heading text-primary"></i></span>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Enter ticket title" required>
                                </div>
                                <div class="invalid-feedback">Please provide a title</div>
                            </div>
                            <div class="col-md-4">
                                <label for="priorite" class="form-label fw-semibold">Priority</label>
                                <select class="form-select" id="priorite" name="priorite">
                                    <option value="basse">Low</option>
                                    <option value="moyenne" selected>Medium</option>
                                    <option value="haute">High</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="" disabled selected>Select ticket type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->type_ticket }}">{{ $type->type_ticket }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a type</div>
                            </div>
                            <div class="col-md-6">
                                <label for="equipement_id" class="form-label fw-semibold">Equipment (optional)</label>
                                <select class="form-select" id="equipement_id" name="equipement_id">
                                    <option value="" selected>Select equipment</option>
                                    <!-- Equipment options would go here -->
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Describe the issue in detail..." required></textarea>
                            <div class="invalid-feedback">Please provide a description</div>
                            <div class="form-text">Maximum 500 characters</div>
                        </div>

                        <div class="mb-4">
                            <label for="fichier" class="form-label fw-semibold">Attachment (optional)</label>
                            <input class="form-control" type="file" id="fichier" name="fichier" accept="image/*,.pdf,.doc,.docx">
                            <div class="form-text">Accepted formats: JPG, PNG, PDF, DOC (max 5MB)</div>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-send-check me-2"></i>Create Ticket
                            </button>
                        </div>
                    </form>
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
        });
    </script>
</body>
</html>
