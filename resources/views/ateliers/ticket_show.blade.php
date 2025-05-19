<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --dark-text: #2b2d42;
        }

        body {
            background-color: #f5f7ff;
            color: var(--dark-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
            margin-left: 80px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1.5rem;
            border-bottom: none;
        }

        .ticket-title {
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .ticket-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
            border-radius: 3px;
        }

        .meta-info span {
            background-color: rgba(67, 97, 238, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .meta-info i {
            margin-right: 0.3rem;
            color: var(--primary-color);
        }

        .description-box {
            background-color: var(--light-bg);
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-left: 4px solid var(--accent-color);
        }

        .attachment-btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .attachment-btn:hover {
            background-color: var(--primary-color);
            color: white !important;
        }

        .btn-outline-secondary {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #e9ecef;
        }

        .btn-danger {
            border-radius: 8px;
            background-color: #ef233c;
            border: none;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #d90429;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 35, 60, 0.3);
        }

        .divider {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin: 1.5rem 0;
        }

        .action-buttons {
            padding-top: 1.5rem;
        }

        .priority-high {
            color: #ef233c !important;
            background-color: rgba(239, 35, 60, 0.1) !important;
        }

        .priority-medium {
            color: #f8961e !important;
            background-color: rgba(248, 150, 30, 0.1) !important;
        }

        .priority-low {
            color: #43aa8b !important;
            background-color: rgba(67, 170, 139, 0.1) !important;
        }

        .type-bug {
            color: #ef233c !important;
        }

        .type-feature {
            color: #4cc9f0 !important;
        }

        .type-request {
            color: #7209b7 !important;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-none d-lg-block" style="width: 250px; position: fixed;">
        @include('Sidebar.sidebarAtelier')
    </div>

    <div class="container py-4" style="margin-top: 80px">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-white"><i class="bi bi-ticket-detailed me-2"></i>Ticket Details</h4>
                            <span class="badge bg-light text-dark">
                                Status: <span class="fw-bold">{{ ucfirst($ticket->statut) }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h3 class="ticket-title">{{ $ticket->titre }}</h3>

                            <div class="meta-info d-flex flex-wrap mb-4">
                                <span class="type-{{ strtolower($ticket->type) }}">
                                    <i class="bi bi-tag-fill"></i> {{ $ticket->type }}
                                </span>
                                <span class="priority-{{ strtolower($ticket->priorite) }}">
                                    <i class="bi bi-flag-fill"></i> {{ ucfirst($ticket->priorite) }} Priority
                                </span>
                                <span>
                                    <i class="bi bi-calendar"></i> {{ $ticket->created_at->format('d M Y, H:i') }}
                                </span>

                            </div>

                            <div class="description-box">
                                <h5 class="fw-bold mb-3"><i class="bi bi-card-text me-2"></i>Description</h5>
                                <p class="mb-0">{{ $ticket->description }}</p>
                            </div>

                            @if($ticket->fichier)
                            <div class="mt-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-paperclip me-2"></i>Attachment</h5>
                                <a href="{{ asset('storage/'.$ticket->fichier) }}" target="_blank" class="attachment-btn btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download me-1"></i> Download File
                                </a>
                            </div>
                            @endif
                        </div>

                        <div class="divider"></div>

                        <div class="action-buttons d-flex justify-content-between align-items-center">
                            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back to List
                            </a>

                            <div class="d-flex">

                                @if($ticket->isVisible)
                                    <form action="{{ route('tickets.disable', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-eye-slash me-1"></i> Disable Ticket
                                        </button>
                                    </form>
                                    @endif
                                 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
