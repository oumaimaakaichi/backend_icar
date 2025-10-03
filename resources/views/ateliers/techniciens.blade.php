<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Techniciens | GaragePro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #a5b4fc;
            --primary-light: #a5b4fc;
            --primary-dark: #a5b4fc;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray: #64748b;
            --light-gray: #f1f5f9;
            --border: #e2e8f0;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: #ffffff;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--dark);
        }

        /* Subtle animated background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(102, 126, 234, 0.02) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes float {
            0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
            33% { transform: translateX(30px) translateY(-30px) rotate(1deg); }
            66% { transform: translateX(-20px) translateY(20px) rotate(-1deg); }
        }

        .container {
            position: relative;
            z-index: 1;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            box-shadow:
                0 8px 32px 0 rgba(102, 126, 234, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform: translateY(0);
        }

        .glass-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 20px 40px 0 rgba(102, 126, 234, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        /* Header Styles */
        .page-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.05) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }

        /* Modern Button Styles */
        .btn-modern {
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
            color: white;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-primary-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary-modern:hover::before {
            left: 100%;
        }

        /* Table Styles */
        .modern-table {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .modern-table thead th {
            background: linear-gradient(135deg, white 0%, white 100%);
            color: black;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-table tbody td {
            padding: 1.5rem;
            border: none;
            color: #0f172a;
            background: rgba(255, 255, 255, 0.6);
            position: relative;
        }

        .modern-table tbody tr {
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        .modern-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.08);
            transform: scale(1.02);
        }

        .modern-table tbody tr:hover td {
            background: transparent;
        }

        /* Avatar Styles */
        .avatar-modern {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: linear-gradient(135deg, #3b71a7 0%, #3b71a7 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .avatar-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        /* Status Badges */
        .status-badge-modern {
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .status-active-modern {
            background: linear-gradient(135deg, #3b71a7 0%, #3b71a7 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .status-inactive-modern {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        /* Action Buttons */
        .action-btn-modern {
            width: 45px;
            height: 45px;
            border-radius: 15px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            position: relative;
            overflow: hidden;
            font-size: 1rem;
        }

        .btn-edit-modern {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .btn-toggle-modern {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-toggle-off-modern {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
        }

        .action-btn-modern:hover {
            transform: translateY(-3px) scale(1.1);
            filter: brightness(1.1);
        }

        /* Modal Styles */
        .modal-content-modern {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            backdrop-filter: blur(20px);
            border: none;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .modal-header-modern {
            background: linear-gradient(135deg, #385279 0%, #385279 100%);
            color: white;
            border: none;
            border-radius: 25px 25px 0 0;
            padding: 2rem;
        }

        .modal-header-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .form-control-modern {
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            background: rgba(255, 255, 255, 0.95);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 2rem;
            opacity: 0.7;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .empty-state h5 {
            color: #0f172a;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 2rem;
        }

        /* Pagination */
        .pagination-modern .page-link {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            border-radius: 12px;
            margin: 0 0.25rem;
            padding: 0.75rem 1rem;
            backdrop-filter: blur(10px);
        }

        .pagination-modern .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .pagination-modern .page-link:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
            color: #667eea;
        }

        /* Animations */
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

        .slide-in-up {
            animation: slideInUp 0.6s ease-out forwards;
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            background-size: 200px 100%;
            animation: shimmer-loading 1.5s infinite;
        }

        @keyframes shimmer-loading {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .glass-card {
                margin: 1rem;
                border-radius: 15px;
            }

            .modern-table {
                font-size: 0.9rem;
            }

            .modern-table thead {
                display: none;
            }

            .modern-table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 15px;
                padding: 1rem;
            }

            .modern-table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            }

            .modern-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
                color: #64748b;
                text-transform: uppercase;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container py-5" style="margin-top: 80px; margin-right: 120px;">
        <!-- Modern Header -->
        <div class="page-header slide-in-up">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-users-cog me-3"></i>Technician Management
                    </h1>
                    <p class="page-subtitle">Manage your workshop technicians efficiently</p>
                </div>
                <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#addTechnicienModal">
                    <i class="fas fa-plus me-2" style="color: white"></i><b style="color: white">New Technician</b>
                </button>
            </div>
        </div>

        <!-- Main Card -->
        <div class="glass-card slide-in-up">
            <div class="card-body p-0">
                @if($techniciens->count())
                    <div class="modern-table">
                        <table class="table table-hover mb-0">
                            <thead >
                                <tr>
                                    <th>Technician</th>
                                    <th>Specialty</th>
                                    <th>Experience</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($techniciens as $tech)
                                <tr>
                                    <td data-label="Technician">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-modern me-3">
                                                {{ substr($tech->prenom ?? $tech->name, 0, 1) }}{{ substr($tech->nom, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $tech->prenom ?? '' }} {{ $tech->nom }}</div>
                                                <small style="color: #64748b;">{{ $tech->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Specialty">{{ $tech->extra_data['specialite'] ?? 'Non spécifié' }}</td>
                                    <td data-label="Experience">{{ $tech->extra_data['annee_experience'] ?? '0' }} years</td>
                                   <td data-label="Status">
    <span class="status-badge-modern {{ $tech->isActive ? 'status-active-modern' : 'status-inactive-modern' }}">
        {{ $tech->isActive ? 'Active' : 'Inactive' }}
    </span>
</td>

                                    <td class="text-end" data-label="Actions">
                                        <div class="d-flex justify-content-end">
                                            <button class="action-btn-modern btn-edit-modern me-2 edit-technicien"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTechnicienModal"
                                                    data-id="{{ $tech->id }}"
                                                    data-nom="{{ $tech->nom }}"
                                                    data-prenom="{{ $tech->prenom }}"
                                                    data-email="{{ $tech->email }}"
                                                    data-phone="{{ $tech->phone }}"
                                                    data-adresse="{{ $tech->adresse }}"
                                                    data-specialite="{{ $tech->extra_data['specialite'] ?? '' }}"
                                                    data-annee_experience="{{ $tech->extra_data['annee_experience'] ?? '' }}"
                                                    title="update">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if ($tech->isActive == 0)
                                                <button class="action-btn-modern btn-toggle-modern accept-btn"
                                                        data-id="{{ $tech->id }}"
                                                        title="Activate">
                                                    <i class="fas fa-toggle-off"></i>
                                                </button>
                                            @else
                                                <button class="action-btn-modern btn-toggle-off-modern refuse-btn"
                                                        data-id="{{ $tech->id }}"
                                                        title="Desactivate">
                                                    <i class="fas fa-toggle-on"></i>
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
                    @if($techniciens->hasPages())
                    <div class="d-flex justify-content-between align-items-center p-4">
                        <div style="color: #64748b;">
                            Display of {{ $techniciens->firstItem() }} à {{ $techniciens->lastItem() }} sur {{ $techniciens->total() }} technicians
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-modern mb-0">
                                {{-- Previous Page Link --}}
                                @if ($techniciens->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $techniciens->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($techniciens->getUrlRange(1, $techniciens->lastPage()) as $page => $url)
                                    @if ($page == $techniciens->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($techniciens->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $techniciens->nextPageUrl() }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                @else
                    <div class="empty-state">
    <i class="fas fa-user-cog fa-3x mb-3"></i>
    <h5 class="fw-bold">No technician found</h5>
    <p>Start by adding your first technician</p>
    <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#addTechnicienModal" style="background-color: cornflowerblue ; color:white">
       Add a technician
    </button>
</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Technician Modal -->
    <div class="modal fade" id="addTechnicienModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-modern">
                    <h5 class="modal-title" style="color: white">
                        <i class="fas fa-user-plus me-2" style="color: white"></i><b style="color: white">New Technician</b>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('techniciens.storee') }}" method="POST">
                    @csrf
                    <input type="hidden" name="atelier_id" value="{{ Auth::id() }}">

                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="nom" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                <input type="text" name="adresse" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Specialty <span class="text-danger">*</span></label>
                                <select name="specialite" class="form-select form-control-modern" required>
                                    <option value="" selected disabled>chose Specialty</option>
                                    @foreach($specialisations as $specialite)
                                        <option value="{{ $specialite->nom_specialite }}">{{ $specialite->nom_specialite }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Years of experience</label>
                                <input type="number" name="annee_experience" class="form-control form-control-modern" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-modern btn-primary-modern">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Technician Modal -->
    <div class="modal fade" id="editTechnicienModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-modern">
                <div class="modal-header modal-header-warning">
                    <h5 class="modal-title"  >
                        <i class="fas fa-user-edit me-2"></i>Update Technician
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTechnicienForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_technicien_id" name="id">

                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit_nom" name="nom" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" id="edit_prenom" name="prenom" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" id="edit_email" name="email" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                <input type="text" id="edit_phone" name="phone" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                <input type="text" id="edit_adresse" name="adresse" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Specialty <span class="text-danger">*</span></label>
                                <select id="edit_specialite" name="specialite" class="form-select form-control-modern" required>
                                    <option value="" selected disabled>chose a Specialty</option>
                                    @foreach($specialisations as $specialite)
                                        <option value="{{ $specialite->nom_specialite }}">{{ $specialite->nom_specialite }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Years of experience</label>
                                <input type="number" id="edit_annee_experience" name="annee_experience" class="form-control form-control-modern" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-modern" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;"> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fill edit form
    document.querySelectorAll('.edit-technicien').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            document.getElementById('edit_technicien_id').value = id;
            document.getElementById('edit_nom').value = this.getAttribute('data-nom');
            document.getElementById('edit_prenom').value = this.getAttribute('data-prenom');
            document.getElementById('edit_email').value = this.getAttribute('data-email');
            document.getElementById('edit_phone').value = this.getAttribute('data-phone');
            document.getElementById('edit_adresse').value = this.getAttribute('data-adresse');
            document.getElementById('edit_annee_experience').value = this.getAttribute('data-annee_experience');

            // Select speciality
            const specialite = this.getAttribute('data-specialite');
            const select = document.getElementById('edit_specialite');
            Array.from(select.options).forEach(option => {
                option.selected = option.value === specialite;
            });

            // Update form action
            document.getElementById('editTechnicienForm').action = `/users/${id}`;
        });
    });

    // Activation
    document.querySelectorAll('.accept-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const userId = this.getAttribute('data-id');

            const result = await Swal.fire({
                title: 'Activate technician?',
                text: "This technician will be activated.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, activate',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(`/users/${userId}/activate`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Activated!',
                        text: 'The technician has been activated.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error while activating technician.'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.'
                });
            }
        });
    });

    // Deactivation
    document.querySelectorAll('.refuse-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const userId = this.getAttribute('data-id');

            const result = await Swal.fire({
                title: 'Deactivate technician?',
                text: "This technician will be deactivated.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, deactivate',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(`/users/${userId}/desactivate`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deactivated!',
                        text: 'The technician has been deactivated.',
                        confirmButtonColor: '#3085d6'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error while deactivating technician.'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.'
                });
            }
        });
    });

    // Form submission
    document.getElementById('editTechnicienForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Technician updated successfully',
                    confirmButtonColor: '#3085d6'
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error while updating technician',
                    confirmButtonColor: '#d33'
                });
            }

        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.'
            });
        }
    });
</script>

</body>
</html>
