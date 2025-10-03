<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Details #{{ $demande->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #7b68ee;
            --accent: #4facfe;
            --success: #10b981;
            --info: #3b82f6;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --border: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --radius: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--gray-50);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--gray-800);
            line-height: 1.6;
        }

        .main-content {
            padding: 2rem 0;
            position: relative;
            z-index: 1;
        }

        .page-header {
            background: var(--light);
            border-radius: var(--radius-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            margin-top: 60px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            border-left: 4px solid var(--primary);
        }

        .page-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title::before {
            content: '';
            display: block;
            width: 24px;
            height: 24px;
            background: var(--primary);
            mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/%3E%3Cpolyline points='14 2 14 8 20 8'/%3E%3Cline x1='16' y1='13' x2='8' y2='13'/%3E%3Cline x1='16' y1='17' x2='8' y2='17'/%3E%3Cpolyline points='10 9 9 9 8 9'/%3E%3C/svg%3E");
            -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z'/%3E%3Cpolyline points='14 2 14 8 20 8'/%3E%3Cline x1='16' y1='13' x2='8' y2='13'/%3E%3Cline x1='16' y1='17' x2='8' y2='17'/%3E%3Cpolyline points='10 9 9 9 8 9'/%3E%3C/svg%3E");
            mask-repeat: no-repeat;
            -webkit-mask-repeat: no-repeat;
            background-color: var(--primary);
        }

        .page-subtitle {
            color: var(--gray-600);
            font-size: 1rem;
            margin-left: 2.5rem;
        }

        .request-id {
            color: var(--primary);
            font-weight: 600;
        }

        .modern-card {
            background: var(--light);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            padding: 100px
        }

        .modern-card:nth-child(1) { animation-delay: 0.1s; }
        .modern-card:nth-child(2) { animation-delay: 0.2s; }
        .modern-card:nth-child(3) { animation-delay: 0.3s; }

        .modern-card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background: var(--gray-50);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
            position: relative;
        }

        .card-title {
            color: var(--gray-700);
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            margin: 0;
            gap: 0.75rem;
            margin-top: 20px;
            margin-bottom: 10px
        }

        .card-title i {
            color: var(--primary);
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .card-body {
            padding: 1.5rem;
            position: relative;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
        }

        .status-badge i {
            font-size: 0.9rem;
        }

        .status-Nouvelle_demande {
            background: var(--primary);
            box-shadow: 0 2px 4px rgba(67, 97, 238, 0.3);
        }
        .status-Assignée{
            background: var(--info);
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
        .status-en_attente {
            background: var(--warning);
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
        }
        .status-en_cours {
            background: var(--accent);
            box-shadow: 0 2px 4px rgba(79, 172, 254, 0.3);
        }
        .status-termine {
            background: var(--success);
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }
        .status-annule {
            background: var(--danger);
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            background: var(--gray-50);
            padding: 1.25rem;
            border-radius: var(--radius);
            border-left: 3px solid var(--primary);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .detail-label {
            font-weight: 500;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-label i {
            color: var(--primary);
            font-size: 0.9rem;
            width: 16px;
        }

        .detail-value {
            color: var(--gray-800);
            font-size: 1.05rem;
            font-weight: 500;
        }

        .section-title {
            color: var(--gray-700);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .section-title i {
            color: var(--primary);
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--gray-300);
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-dot {
            position: absolute;
            left: -30px;
            top: 6px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary);
            border: 2px solid var(--light);
            box-shadow: 0 0 0 2px var(--primary);
        }

        .timeline-content {
            background: var(--light);
            padding: 1rem;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .timeline-date {
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .timeline-text {
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .team-member {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--radius);
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .team-member:hover {
            background: var(--gray-100);
            transform: translateX(3px);
            border-color: var(--primary);
        }

        .team-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .team-info h6 {
            color: var(--gray-800);
            font-weight: 600;
            margin-bottom: 0.1rem;
            font-size: 0.95rem;
        }

        .team-info small {
            color: var(--gray-600);
            font-size: 0.8rem;
        }

        .form-control, .form-select {
            background: white;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            color: var(--gray-800);
            padding: 0.6rem 0.875rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            color: var(--gray-800);
        }

        .form-control::placeholder {
            color: var(--gray-500);
        }

        .form-label {
            color: var(--gray-700);
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            border: 1px solid var(--gray-300);
            background: white;
            color: var(--gray-700);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-print {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-print:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .btn-edit {
            background: var(--info-light);
            color: var(--info);
        }

        .btn-edit:hover {
            background: var(--info);
            color: white;
        }

        .btn-delete {
            background: var(--danger-light);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
        }

        /* New styles for technician selection */
        .technician-item {
            background: var(--gray-50);
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .technician-item:hover {
            background: var(--gray-100);
            border-color: var(--primary);
        }

        .technician-item.selected {
            background: var(--primary-light);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .technician-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .technician-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .technician-details h6 {
            margin: 0;
            font-weight: 600;
            color: var(--gray-800);
            font-size: 0.9rem;
        }

        .technician-details small {
            color: var(--gray-600);
            font-size: 0.75rem;
        }

        .technician-checkbox {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .selected-count {
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: auto;
        }

        /* Print-specific styles */
        @media print {
            @page {
                margin: 0.5in;
                size: A4;
            }

            body {
                background: white !important;
                color: black !important;
                font-size: 12pt;
                line-height: 1.4;
            }

            .sidebar, .action-buttons, .btn-print, .btn-edit, .btn-delete,
            #assignTechniciensForm, .technician-checkbox, .selected-count,
            .timeline-dot, .timeline::before {
                display: none !important;
            }

            .container-fluid {
                margin-top: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }

            .page-header {
                margin-top: 0 !important;
                box-shadow: none !important;
                border: 2px solid #333 !important;
                background: white !important;
                color: black !important;
                padding: 1rem !important;
            }

            .modern-card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                margin-bottom: 1rem !important;
                page-break-inside: avoid;
                padding: 0 !important;
            }

            .card-header {
                background: #f5f5f5 !important;
                border-bottom: 2px solid #333 !important;
                color: black !important;
            }

            .card-title, .section-title {
                color: black !important;
            }

            .detail-item {
                background: white !important;
                border: 1px solid #ddd !important;
                color: black !important;
            }

            .detail-label, .detail-value {
                color: black !important;
            }

            .status-badge {
                color: black !important;
                border: 1px solid #333 !important;
                background: white !important;
            }

            .team-member {
                border: 1px solid #ddd !important;
                background: white !important;
            }

            .team-avatar {
                background: #333 !important;
                color: white !important;
            }

            .print-header {
                text-align: center;
                margin-bottom: 1.5rem;
                border-bottom: 3px double #333;
                padding-bottom: 1rem;
            }

            .print-footer {
                text-align: center;
                margin-top: 2rem;
                border-top: 1px solid #ccc;
                padding-top: 1rem;
                font-size: 10pt;
                color: #666;
            }

            .print-watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 72pt;
                color: rgba(0,0,0,0.1);
                z-index: -1;
                pointer-events: none;
            }

            a[href]:after {
                content: " (" attr(href) ")";
            }

            .no-print {
                display: none !important;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            .timeline {
                padding-left: 25px;
            }

            .main-content {
                padding: 1rem 0;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .technician-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .technician-checkbox {
                align-self: flex-end;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container-fluid animate-slide-up" style="margin-top: 60px ; margin-right:30px">
        <div class="page-header">
            <h1 class="page-title">Request Details <span class="request-id"></span></h1>
            <p class="page-subtitle">Manage and track maintenance requests with advanced tools</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="card-header">
                        <h2 class="card-title" style="font-size: 1rem">
                            <i class="fas fa-info-circle"></i>
                            Request Information
                        </h2>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <p class="detail-label">
                                    <i class="fas fa-user"></i>
                                    Client
                                </p>
                                <p class="detail-value">
                                    {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                </p>
                            </div>

                            <div class="detail-item">
                                <p class="detail-label">
                                    <i class="fas fa-car"></i>
                                    Vehicle
                                </p>
                                <p class="detail-value">
                                    {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                </p>
                            </div>

                            <div class="detail-item">
                                <p class="detail-label">
                                    <i class="fas fa-phone"></i>
                                    Contact
                                </p>
                                <p class="detail-value">
                                    {{ $demande->client->phone }}
                                </p>
                            </div>

                            <div class="detail-item">
                                <p class="detail-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Maintenance Date
                                </p>
                                <p class="detail-value">
                                    {{ $demande->date_maintenance}}
                                </p>
                            </div>

                            <div class="detail-item">
                                <p class="detail-label">
                                    <i class="fas fa-clock"></i>
                                    Time
                                </p>
                                <p class="detail-value">
                                    {{ $demande->heure_maintenance }}
                                </p>
                            </div>

                            <div class="detail-item">
                                <p class="detail-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Notes
                                </p>
                                <p class="detail-value">
                                    {{ $demande->notes ?? 'No notes provided' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="section-title">
                                <i class="fas fa-history"></i>
                                Status History
                            </h6>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">Today, 10:30 AM</div>
                                        <div class="timeline-text">Request created</div>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">Today, 11:45 AM</div>
                                        <div class="timeline-text">Pending validation</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="action-btn btn-print" id="printButton">
                                <i class="fas fa-print"></i> Print Details
                            </button>
                            <button class="action-btn btn-print" onclick="simplePrint()">
                                <i class="fas fa-print"></i> Quick Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if($demande->techniciens && count($demande->techniciens) > 0)
                <div class="modern-card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fas fa-users" style="color: black"></i>
                            Assigned Team
                            <br/>
                        </h6>
                    </div>
                     <br/>
                    <div class="card-body">
                        @foreach($demande->techniciens as $tech)
                            <div class="team-member">
                                <div class="team-avatar">
                                    {{ substr($tech['nom'], 0, 1) }}{{ substr($tech['prenom'] ?? '', 0, 1) }}
                                </div>
                                <div class="team-info">
                                    <h6>{{ $tech['nom'] }} {{ $tech['prenom'] ?? '' }}</h6>
                                    <small>ID: {{ $tech['id'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($demande->status === 'en_attente')
                <div class="modern-card no-print">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-user-plus" style="color: black"></i>
                                Assign Technicians
                                <br/>
                            </h6>
                            <div class="selected-count" id="selectedCount" style="display: none;">
                                0 selected
                            </div>
                        </div>
                    </div>

                    <div class="card-body"  style="margin-top: 20px">
                        <form id="assignTechniciensForm">
                            <div id="technicians_list">
                                @foreach($techniciens as $tech)
                                    <div class="technician-item" data-tech-id="{{ $tech->id }}">
                                        <div class="technician-info">
                                            <div class="technician-avatar">
                                                {{ substr($tech->nom ?? $tech->name, 0, 1) }}{{ substr($tech->prenom ?? '', 0, 1) }}
                                            </div>
                                            <div class="technician-details">
                                                <h6>{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</h6>
                                                <small>ID: {{ $tech->id }}</small>
                                            </div>
                                        </div>
                                        <input type="checkbox" class="technician-checkbox" name="techniciens[]" value="{{ $tech->id }}" data-name="{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}">
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3" id="assignBtn" disabled>
                                <i class="fas fa-user-plus me-2"></i>Assign Technician
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Print functionality
        document.getElementById('printButton').addEventListener('click', function() {
            // Create a print-friendly version of the content
            const printContent = createPrintContent();

            // Open print window
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Request Details #{{ $demande->id }}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            color: #000;
                            line-height: 1.4;
                        }
                        .print-header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 2px solid #333;
                            padding-bottom: 20px;
                        }
                        .print-section {
                            margin-bottom: 25px;
                            page-break-inside: avoid;
                        }
                        .print-section h3 {
                            background: #f5f5f5;
                            padding: 10px;
                            border-left: 4px solid #4361ee;
                            margin-bottom: 15px;
                        }
                        .detail-grid {
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            gap: 15px;
                            margin-bottom: 20px;
                        }
                        .detail-item {
                            border: 1px solid #ddd;
                            padding: 15px;
                            border-left: 4px solid #4361ee;
                        }
                        .detail-label {
                            font-weight: bold;
                            color: #666;
                            font-size: 12px;
                            text-transform: uppercase;
                            margin-bottom: 5px;
                        }
                        .detail-value {
                            font-size: 14px;
                        }
                        .team-member {
                            display: flex;
                            align-items: center;
                            margin-bottom: 10px;
                            padding: 10px;
                            border: 1px solid #eee;
                        }
                        .team-avatar {
                            width: 30px;
                            height: 30px;
                            border-radius: 50%;
                            background: #4361ee;
                            color: white;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin-right: 10px;
                            font-weight: bold;
                        }
                        .print-footer {
                            text-align: center;
                            margin-top: 40px;
                            padding-top: 20px;
                            border-top: 1px solid #ccc;
                            font-size: 12px;
                            color: #666;
                        }
                        @media print {
                            body { margin: 0; }
                            .print-section { page-break-inside: avoid; }
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);

            printWindow.document.close();

            // Wait for content to load then print
            printWindow.onload = function() {
                printWindow.print();
                // printWindow.close(); // Optional: close after printing
            };
        });

        function createPrintContent() {
            const today = new Date().toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            // Build assigned team HTML safely
            let assignedTeamHTML = '';
            @if($demande->techniciens && count($demande->techniciens) > 0)
                assignedTeamHTML = `
                    <div class="print-section">
                        <h3>Assigned Team</h3>
                `;

                // Generate team members HTML using template literals
                const teamMembers = @json($demande->techniciens);
                teamMembers.forEach(tech => {
                    const initials = (tech.nom ? tech.nom.charAt(0) : '') + (tech.prenom ? tech.prenom.charAt(0) : '');
                    assignedTeamHTML += `
                        <div class="team-member">
                            <div class="team-avatar">${initials}</div>
                            <div>
                                <strong>${tech.nom || ''} ${tech.prenom || ''}</strong><br>
                                <small>ID: ${tech.id}</small>
                            </div>
                        </div>
                    `;
                });

                assignedTeamHTML += `</div>`;
            @endif

            return `
                <div class="print-header">
                    <h1>Maintenance Request Details</h1>
                    <h2>Request #{{ $demande->id }}</h2>
                    <p>Generated on: ${today}</p>
                </div>

                <div class="print-section">
                    <h3>Request Information</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Client</div>
                            <div class="detail-value">{{ $demande->client->prenom }} {{ $demande->client->nom }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Vehicle</div>
                            <div class="detail-value">{{ $demande->voiture->model }} ({{ $demande->voiture->serie }})</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Contact</div>
                            <div class="detail-value">{{ $demande->client->phone }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Maintenance Date</div>
                            <div class="detail-value">{{ $demande->date_maintenance }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Time</div>
                            <div class="detail-value">{{ $demande->heure_maintenance }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Notes</div>
                            <div class="detail-value">{{ $demande->notes ?? 'No notes provided' }}</div>
                        </div>
                    </div>
                </div>

                ${assignedTeamHTML}

                <div class="print-section">
                    <h3>Status History</h3>
                    <div style="padding-left: 20px; border-left: 2px solid #4361ee;">
                        <div style="margin-bottom: 15px;">
                            <strong>Today, 10:30 AM</strong><br>
                            Request created
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong>Today, 11:45 AM</strong><br>
                            Pending validation
                        </div>
                    </div>
                </div>

                <div class="print-footer">
                    <p>© {{ date('Y') }} Your Company Name. All rights reserved.</p>
                    <p>This document is computer-generated and does not require a signature.</p>
                </div>
            `;
        }

        // Alternative simple print function
        function simplePrint() {
            window.print();
        }

        // Handle technician selection (existing code)
        const checkboxes = document.querySelectorAll('.technician-checkbox');
        const technicianItems = document.querySelectorAll('.technician-item');
        const selectedCount = document.getElementById('selectedCount');
        const assignBtn = document.getElementById('assignBtn');

        function updateSelection() {
            const selected = document.querySelectorAll('.technician-checkbox:checked');
            const count = selected.length;

            if (count > 0) {
                selectedCount.style.display = 'block';
                selectedCount.textContent = `${count} selected`;
                assignBtn.disabled = false;
            } else {
                selectedCount.style.display = 'none';
                assignBtn.disabled = true;
            }

            technicianItems.forEach(item => {
                const checkbox = item.querySelector('.technician-checkbox');
                if (checkbox.checked) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelection);
        });

        technicianItems.forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.type !== 'checkbox') {
                    const checkbox = item.querySelector('.technician-checkbox');
                    checkbox.checked = !checkbox.checked;
                    updateSelection();
                }
            });
        });

        document.getElementById('assignTechniciensForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const selectedCheckboxes = document.querySelectorAll('.technician-checkbox:checked');
            const techniciensData = Array.from(selectedCheckboxes).map(checkbox => {
                return {
                    id_technicien: parseInt(checkbox.value),
                    nom: checkbox.getAttribute('data-name')
                };
            });

            if (techniciensData.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Selection',
                    text: 'Please select at least one technician',
                    confirmButtonColor: '#4361ee',
                });
                return;
            }

            assignBtn.disabled = true;
            assignBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Assigning...';

            fetch("{{ route('demandes.updateTechniciensInconnu', $demande->id) }}", {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ techniciens: techniciensData }),
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#4361ee',
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'An error occurred',
                        confirmButtonColor: '#ef4444',
                    });
                    assignBtn.disabled = false;
                    assignBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Assign Team';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to contact the server',
                    confirmButtonColor: '#ef4444',
                });
                assignBtn.disabled = false;
                assignBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Assign Team';
            });
        });
    </script>
</body>
</html>
