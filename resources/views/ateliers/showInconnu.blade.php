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
            margin-top: 20px
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
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container-fluid animate-slide-up" style="margin-top: 60px">
        <div class="page-header">
            <h1 class="page-title">Request Details <span class="request-id"></span></h1>
            <p class="page-subtitle">Manage and track maintenance requests with advanced tools</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="card-header">
                        <h6 class="card-title" >
                            <i class="fas fa-info-circle"></i>
                            Request Information
                        </h6>
                        <span class="status-badge status-{{ $demande->status }}" style="margin-top: 30px">
                            <i class="fas fa-circle"></i>
                            {{ $demande->status }}
                        </span>
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
                            <button class="action-btn btn-print">
                                <i class="fas fa-print"></i> Print Details
                            </button>
                            <button class="action-btn btn-edit">
                                <i class="fas fa-edit"></i> Edit Request
                            </button>
                            <button class="action-btn btn-delete">
                                <i class="fas fa-trash-alt"></i> Delete Request
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
                            <i class="fas fa-users"></i>
                            Assigned Team
                        </h6>
                    </div>
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

                @if($demande->status === 'Nouvelle_demande')
                <div class="modern-card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fas fa-user-plus"></i>
                            Assign Technicians
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre_techniciens" class="form-label">Number of Technicians</label>
                            <input type="number" min="1" max="{{ $techniciens->count() }}"
                                   class="form-control" id="nombre_techniciens" value="1">
                        </div>

                        <form id="assignTechniciensForm">
                            <div id="techniciens_select_container">
                                <div class="mb-3">
                                    <label class="form-label">Technician 1</label>
                                    <select class="form-select" name="techniciens[]" required>
                                        <option value="" disabled selected>-- Select Technician --</option>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Assign Team
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Gestion des techniciens
        const nombreInput = document.getElementById('nombre_techniciens');
        const container = document.getElementById('techniciens_select_container');
        const techniciens = @json($techniciens);

        function createSelect(index) {
            const div = document.createElement('div');
            div.classList.add('mb-3');

            const label = document.createElement('label');
            label.classList.add('form-label');
            label.textContent = `Technician ${index + 1}`;

            const select = document.createElement('select');
            select.classList.add('form-select');
            select.name = 'techniciens[]';
            select.required = true;

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            defaultOption.textContent = '-- Select Technician --';
            select.appendChild(defaultOption);

            techniciens.forEach(t => {
                const option = document.createElement('option');
                option.value = t.id;
                option.textContent = (t.prenom ?? '') + ' ' + (t.nom ?? t.name);
                select.appendChild(option);
            });

            div.appendChild(label);
            div.appendChild(select);

            return div;
        }

        nombreInput.addEventListener('input', () => {
            let count = parseInt(nombreInput.value) || 1;
            if(count < 1) count = 1;
            if(count > techniciens.length) count = techniciens.length;

            container.innerHTML = '';
            for(let i = 0; i < count; i++) {
                container.appendChild(createSelect(i));
            }
        });

        // Gestion du submit
        document.getElementById('assignTechniciensForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const selects = this.querySelectorAll('select[name="techniciens[]"]');
            const techniciensData = Array.from(selects).map(select => {
                return {
                    id_technicien: parseInt(select.value),
                    nom: select.options[select.selectedIndex].text
                };
            });

            fetch("{{ route('demandes.updateTechniciensInconnu', $demande->id) }}", {
                method: 'put',
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
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to contact the server',
                    confirmButtonColor: '#ef4444',
                });
            });
        });

        // Action buttons functionality
        document.querySelector('.btn-print').addEventListener('click', function() {
            window.print();
        });

        document.querySelector('.btn-edit').addEventListener('click', function() {
            // Add edit functionality here
            Swal.fire({
                title: 'Edit Request',
                text: 'This functionality will be implemented soon.',
                icon: 'info',
                confirmButtonColor: '#4361ee'
            });
        });

        document.querySelector('.btn-delete').addEventListener('click', function() {
            // Add delete functionality here
            Swal.fire({
                title: 'Delete Request?',
                text: 'Are you sure you want to delete this request? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'The request has been deleted.',
                        'success'
                    );
                }
            });
        });
    </script>
</body>
</html>
