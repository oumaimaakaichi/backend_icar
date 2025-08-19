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
            --primary: #667eea;
            --primary-light: #f0f3ff;
            --secondary: #764ba2;
            --accent: #4facfe;
            --success: #00d4aa;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #2c3e50;
            --light: #ffffff;
            --border: #e2e8f0;
            --shadow: rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }

        .main-content {
            padding: 2rem 0;
            position: relative;
            z-index: 1;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            margin-top: 60px;
            box-shadow: 0 10px 30px var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50px, -50px);
        }

        .page-title {
            color: white;
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        .modern-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px var(--shadow);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            margin-bottom: 2rem;
            overflow: hidden;
            border: 1px solid rgba(102, 126, 234, 0.1);
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        .modern-card:nth-child(1) { animation-delay: 0.1s; }
        .modern-card:nth-child(2) { animation-delay: 0.2s; }
        .modern-card:nth-child(3) { animation-delay: 0.3s; }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
            border-color: var(--primary);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.05));
            border-bottom: 1px solid var(--border);
            padding: 1.5rem 2rem;
            position: relative;
        }

        .card-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            margin: 0;
        }

        .card-title i {
            margin-right: 12px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.4rem;
            margin-top: 10px;
            margin-left: 10px
        }

        .card-body {
            padding: 2rem;
            position: relative;
        }

        .status-badge {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, var(--success), var(--accent));
            color: white;
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
        }

        .status-Non_assigné {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .status-Assignée_now {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }
        .status-en_attente {
            background: linear-gradient(135deg, var(--warning), #ff8f00);
            box-shadow: 0 4px 15px rgba(246, 194, 62, 0.3);
        }
        .status-en_cours {
            background: linear-gradient(135px, var(--info), var(--accent));
            box-shadow: 0 4px 15px rgba(54, 185, 204, 0.3);
        }
        .status-termine {
            background: linear-gradient(135deg, var(--success), #00a693);
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.3);
        }
        .status-annule {
            background: linear-gradient(135deg, var(--danger), #dc3545);
            box-shadow: 0 4px 15px rgba(231, 74, 59, 0.3);
        }

        .detail-group {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03), rgba(255, 255, 255, 0.8));
            border-radius: 15px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-group::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--accent));
            border-radius: 0 4px 4px 0;
        }

        .detail-group:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(255, 255, 255, 0.9));
            transform: translateX(5px);
            border-color: var(--primary);
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .detail-value {
            color: var(--dark);
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .detail-value i {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 3px;
        }

        .section-title i {
            margin-right: 12px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--primary), var(--accent));
            border-radius: 3px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-dot {
            position: absolute;
            left: -32px;
            top: 8px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            box-shadow: 0 0 0 4px white, 0 0 0 6px rgba(102, 126, 234, 0.2);
        }

        .timeline-content {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 15px var(--shadow);
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            border-color: var(--primary);
            transform: translateX(10px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        .timeline-date {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .timeline-text {
            color: var(--dark);
            font-weight: 500;
        }

        .team-member {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03), rgba(255, 255, 255, 0.8));
            border-radius: 15px;
            margin-bottom: 1rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        .team-member:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08), rgba(255, 255, 255, 0.9));
            transform: translateX(5px);
            border-color: var(--primary);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }

        .team-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .team-info h6 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .team-info small {
            color: #6c757d;
        }

        .form-control, .form-select {
            background: white;
            border: 2px solid var(--border);
            border-radius: 12px;
            color: var(--dark);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            color: var(--dark);
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .form-label {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            padding: 0.875rem 2rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover::before {
            left: 100%;
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

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .timeline {
                padding-left: 30px;
            }

            .main-content {
                padding: 1rem 0;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

  <div class="container-fluid animate-slide-up" style="margin-top: 60px">
        <div class="page-header">
            <h1 class="page-title">Request Details</h1>
            <p class="page-subtitle">Manage and track maintenance requests with advanced tools</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Request Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-group">
                                    <p class="detail-label">Client</p>
                                    <p class="detail-value">
                                        <i class="fas fa-user"></i>
                                        {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                    </p>
                                </div>

                                <div class="detail-group">
                                    <p class="detail-label">Vehicle</p>
                                    <p class="detail-value">
                                        <i class="fas fa-car"></i>
                                        {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-group">
                                    <p class="detail-label">Contact</p>
                                    <p class="detail-value">
                                        <i class="fas fa-phone"></i>
                                        {{ $demande->client->phone }}
                                    </p>
                                </div>

                                <div class="detail-group">
                                    <p class="detail-label">Maintenance Date & Time</p>
                                    <p class="detail-value">
                                        <i class="fas fa-tools"></i>
                                        {{ $demande->date_maintenance}} {{ $demande->heure_maintenance }}
                                    </p>
                                </div>
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
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if($demande->techniciens && count($demande->techniciens) > 0)
                <div class="modern-card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fas fa-users" style="margin-top:10px"></i>
                            Assigned Team
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($demande->techniciens as $tech)
                            <div class="team-member">
                                <div class="team-avatar">
                                    {{ substr($tech['nom'], 0, 1) }}
                                </div>
                                <div class="team-info">
                                    <h6>{{ $tech['nom'] }}</h6>
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
                        confirmButtonColor: '#667eea',
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'An error occurred',
                        confirmButtonColor: '#e74a3b',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to contact the server',
                    confirmButtonColor: '#e74a3b',
                });
            });
        });
    </script>
</body>
</html>
