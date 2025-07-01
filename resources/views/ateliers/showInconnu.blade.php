<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Demande #{{ $demande->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4e73df;
            --primary-light: #e8f1ff;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #5a5c69;
            --light: #f8f9fc;
            --border: #e3e6f0;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        .status-badge {
            padding: 0.5em 1em;
            font-size: 0.85em;
            font-weight: 700;
            border-radius: 50px;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
        }

        .status-Non_assigné { background-color: var(--primary-light); color: var(--primary); }
        .status-Assignée_now { background-color: #e2e3e5; color: #5a5c69; }
        .status-en_attente { background-color: #fff8e1; color: #ff8f00; }
        .status-en_cours { background-color: #fff3cd; color: #856404; }
        .status-termine { background-color: #e6ffed; color: #1b5e20; }
        .status-annule { background-color: #ffebee; color: #c62828; }

        .detail-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
            font-size: 0.85rem;
        }

        .detail-value {
            color: var(--dark);
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .detail-value i {
            margin-right: 10px;
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .btn-submit {
            background-color: var(--success);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #17a673;
            transform: translateY(-2px);
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary);
            border-radius: 3px;
        }

        .list-group-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 0.5rem;
            border-radius: 8px !important;
        }

        .list-group-item i {
            margin-right: 12px;
            color: var(--primary);
        }

        .technicien-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: 600;
        }

        .price-input {
            position: relative;
        }

        .price-input:before {
            content: '€';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-weight: 600;
        }

        .price-input input {
            padding-left: 30px !important;
        }

        .progress-track {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
            margin-top: 20px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: var(--primary);
            transition: width 0.6s ease;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }

        .timeline:before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--primary-light);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -30px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: white;
            border: 3px solid var(--primary);
            z-index: 1;
        }

        .timeline-content {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .timeline-date {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .timeline-text {
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="container-fluid py-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-2 text-gray-800" style="margin-top: 50px">Détails de la demande</h1>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Informations sur la demande</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <p class="detail-label">Client</p>
                                    <p class="detail-value">
                                        <i class="fas fa-user"></i>
                                        {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <p class="detail-label">Véhicule</p>
                                    <p class="detail-value">
                                        <i class="fas fa-car"></i>
                                        {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <p class="detail-label">Contact</p>
                                    <p class="detail-value">
                                        <i class="fas fa-phone"></i>
                                        {{ $demande->client->phone }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <p class="detail-label">Catgorie demandé</p>
                                    <p class="detail-value">
                                        <i class="fas fa-tools"></i>
                                        {{ $demande->category->titre }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <p class="detail-label">Date et heure de maintenance</p>
                                    <p class="detail-value">
                                        <i class="fas fa-tools"></i>
                                        {{ $demande->date_maintenance}}   {{ $demande->heure_maintenance }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="mt-3">
                            <h6 class="section-title">Historique des statuts</h6>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">Aujourd'hui, 10:30</div>
                                        <div class="timeline-text">Demande créée</div>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date">Aujourd'hui, 11:45</div>
                                        <div class="timeline-text">En attente de validation</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-lg-4">

                @if($demande->techniciens && count($demande->techniciens) > 0)
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Équipe assignée</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($demande->techniciens as $tech)
                                <li class="list-group-item">
                                    <div class="technicien-avatar">
                                        {{ substr($tech['nom'], 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $tech['nom'] }}</h6>
                                        <small class="text-muted">ID: {{ $tech['id'] }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

@if($demande->status === 'Nouvelle_demande')
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Assigner des techniciens</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre_techniciens" class="form-label detail-label">Nombre de techniciens</label>
                            <input type="number" min="1" max="{{ $techniciens->count() }}"
                                   class="form-control" id="nombre_techniciens" value="1">
                        </div>

                        <form id="assignTechniciensForm">
                            <div id="techniciens_select_container">
                                <div class="mb-3">
                                    <label class="form-label detail-label">Technicien 1</label>
                                    <select class="form-select" name="techniciens[]" required>
                                        <option value="" disabled selected>-- Sélectionner --</option>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Assigner l'équipe
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
            label.classList.add('form-label', 'detail-label');
            label.textContent = `Technicien ${index + 1}`;

            const select = document.createElement('select');
            select.classList.add('form-select');
            select.name = 'techniciens[]';
            select.required = true;

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            defaultOption.textContent = '-- Sélectionner --';
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
                        title: 'Succès',
                        text: data.message,
                        confirmButtonColor: '#4e73df',
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message || 'Une erreur est survenue',
                        confirmButtonColor: '#e74a3b',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur réseau',
                    text: 'Impossible de contacter le serveur',
                    confirmButtonColor: '#e74a3b',
                });
            });
        });

        // Gestion du formulaire de prix
        document.getElementById('prixForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: "L'offre a été envoyée, en attente d'acceptation du client.",
                        confirmButtonColor: '#4e73df',
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message || "Une erreur est survenue lors de l'envoi de l'offre",
                        confirmButtonColor: '#e74a3b',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: "Une erreur réseau est survenue",
                    confirmButtonColor: '#e74a3b',
                });
            });
        });
    </script>
</body>
</html>
