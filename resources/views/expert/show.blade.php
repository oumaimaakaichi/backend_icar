<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Demande #{{ $demande->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f8961e;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #f1f3f5;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #495057;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
            background-color: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
            color: var(--primary);
        }

        .card-body {
            padding: 1.5rem;
        }

        .status-badge {
            padding: 0.5em 0.8em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 50px;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
        }

        .status-badge i {
            margin-right: 5px;
            font-size: 0.8em;
        }

        .status-Non_assigné { background-color: var(--primary); color: white; }
        .status-Assignée_now { background-color: var(--gray); color: white; }
        .status-en_attente { background-color: var(--warning); color: white; }
        .status-en_cours { background-color: var(--info); color: white; }
        .status-termine { background-color: var(--success); color: white; }
        .status-annule { background-color: var(--danger); color: white; }

        .detail-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }

        .detail-value {
            color: var(--gray);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .detail-value i {
            margin-right: 8px;
            color: var(--primary);
            width: 18px;
            text-align: center;
        }

        .btn-submit {
            background-color: var(--primary);
            border: none;
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-submit:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-submit i {
            margin-right: 8px;
        }

        .section-title {
            color: var(--primary);
            font-weight: 700;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            font-size: 1.5rem;
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

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
        }

        .list-group-item i {
            margin-right: 12px;
            color: var(--primary);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .page-title {
            color: var(--dark);
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
        }

        .info-box {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .info-box-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .info-box-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
        }

        .info-box-value i {
            margin-right: 10px;
            color: var(--primary);
        }

        .divider {
            height: 1px;
            background-color: rgba(0, 0, 0, 0.05);
            margin: 1.5rem 0;
        }

        .technician-select-container {
            margin-bottom: 15px;
        }

        .technician-select-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarExpert')

    <div class="container py-4">
        <div class="page-header">
            <h1 class="page-title">Détails de la demande #{{ $demande->id }}</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Informations principales</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">Client</div>
                                    <div class="info-box-value">
                                        <i class="fas fa-user"></i>
                                        {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">Téléphone</div>
                                    <div class="info-box-value">
                                        <i class="fas fa-phone"></i>
                                        {{ $demande->client->phone }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">Véhicule</div>
                                    <div class="info-box-value">
                                        <i class="fas fa-car"></i>
                                        {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">Statut</div>
                                    <div class="info-box-value">
                                        <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                            <i class="fas fa-circle"></i>
                                            {{ str_replace('_', ' ', $demande->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">Service</div>
                                    <div class="info-box-value">
                                        <i class="fas fa-tools"></i>
                                        {{ $demande->servicePanne->titre }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="info-box">
                                    <div class="info-box-title">Catégorie</div>
                                    <div class="info-box-value">
                                        <i class="fas fa-list-alt"></i>
                                        {{ $demande->servicePanne->categoryPane->titre }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Proposition de prix</h6>
                    </div>
                    <div class="card-body">
                        <form id="prixForm" action="{{ route('demandes.ajouterPrixMainOeuvre', $demande->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="prix_main_oeuvre" class="form-label info-box-title">
                                    Prix main d'œuvre (€)
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control"
                                       id="prix_main_oeuvre" name="prix_main_oeuvre"
                                       value="{{ old('prix_main_oeuvre', $demande->prix_main_oeuvre) }}"
                                       @if($demande->status !== 'Nouvelle_demande') disabled @endif
                                       required>
                                @error('prix_main_oeuvre')
                                    <div class="text-danger mt-2 small">{{ $message }}</div>
                                @enderror
                            </div>
                            @if($demande->status === 'Nouvelle_demande')
                            <button type="submit" class="btn btn-submit w-100">
                                <i class="fas fa-paper-plane"></i>Envoyer l'offre
                            </button>
                            @endif
                        </form>
                    </div>
                </div>

@if($demande->techniciens && count($demande->techniciens) > 0)
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-users-cog me-2"></i>Techniciens assignés
        </h6>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            @foreach($demande->techniciens as $tech)
                @php
                    $flux = App\Models\FluxDirect::where('demande_id', $demande->id)
                                                ->where('technicien_id', $tech['id'])
                                                ->first();
                @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">
                            <i class="fas fa-user-tie text-secondary me-2"></i>{{ $tech['nom'] }}

                        </div>
  @if($flux && $flux->lien_meet)
                        <button class="btn btn-sm btn-outline-success mt-2">
                            <i class="fas fa-share-square me-1"></i> Autoriser le partage avec le client
                        </button> &nbsp;&nbsp;
                         @endif
                    </div>

                    <div>
                        @if($flux && $flux->lien_meet)
                            <a href="{{ $flux->lien_meet }}" target="_blank" class="btn btn-sm btn-primary"   style="margin-top: 30px">
                                <i class="fas fa-video me-1" style="color: wheat"></i> Meet
                            </a>
                        @else
                            <span class="badge bg-secondary">Aucun lien disponible</span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif


                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Forfait</h6>
                    </div>
                    <div class="card-body">
                        <div class="info-box-value">
                            <i class="fas fa-tag"></i>
                            {{ $demande->forfait->nomForfait }}
                        </div>
                    </div>
                </div>

                @if($demande->status === 'offre_acceptee')
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Assigner des techniciens</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nombre_techniciens" class="info-box-title">Nombre de techniciens</label>
                            <input type="number" min="1" max="{{ $techniciens->count() }}" class="form-control" id="nombre_techniciens" value="1">
                        </div>

                        <form id="assignTechniciensForm">
                            <div id="techniciens_select_container">
                                <div class="technician-select-container">
                                    <label>Technicien 1</label>
                                    <select class="form-select" name="techniciens[]" required>
                                        <option value="" disabled selected>Sélectionner un technicien</option>
                                        @foreach($techniciens as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit w-100 mt-3">
                                <i class="fas fa-user-plus"></i>Assigner
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
<script>
    // Gestion de l'ouverture du flux direct
    document.querySelectorAll('.open-flux').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const demandeId = this.getAttribute('data-demande-id');
            const technicienId = this.getAttribute('data-technicien-id');

            // Appel API pour créer/obtenir le flux direct
            fetch(`/api/flux-direct/${demandeId}/${technicienId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Ouvrir le flux dans une nouvelle fenêtre ou un modal
                    window.open(`/flux-direct/${data.flux.id}`, '_blank');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: data.message || 'Impossible d\'ouvrir le flux',
                        confirmButtonColor: 'var(--primary)',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Erreur réseau',
                    confirmButtonColor: 'var(--primary)',
                });
            });
        });
    });
</script>
<script>
    const nombreInput = document.getElementById('nombre_techniciens');
    const container = document.getElementById('techniciens_select_container');
    const techniciens = @json($techniciens);

    function createSelect(index) {
        const div = document.createElement('div');
        div.classList.add('technician-select-container');

        const label = document.createElement('label');
        label.textContent = `Technicien ${index + 1}`;

        const select = document.createElement('select');
        select.classList.add('form-select');
        select.name = 'techniciens[]';
        select.required = true;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Sélectionner un technicien';
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

    document.getElementById('assignTechniciensForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const selects = this.querySelectorAll('select[name="techniciens[]"]');
        const techniciensData = Array.from(selects).map(select => {
            return {
                id_technicien: parseInt(select.value),
                nom: select.options[select.selectedIndex].text
            };
        });

        fetch("{{ route('demandes.updateTechniciens', $demande->id) }}", {
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
                    confirmButtonColor: 'var(--primary)',
                }).then(() => window.location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: data.message || 'Une erreur est survenue',
                    confirmButtonColor: 'var(--primary)',
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Erreur réseau',
                confirmButtonColor: 'var(--primary)',
            });
        });
    });
</script>

<script>
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
                    confirmButtonColor: 'var(--primary)',
                }).then(() => {
                    // Optional: Reload or redirect if needed
                    // window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: "L'offre a été envoyée, en attente d'acceptation du client.",
                    confirmButtonColor: 'var(--primary)',
                })
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: "L'offre a été envoyée, en attente d'acceptation du client.",
                confirmButtonColor: 'var(--primary)',
            })
        });
    });
</script>
</body>
</html>
