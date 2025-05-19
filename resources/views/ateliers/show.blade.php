<html>
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
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            border-radius: 0.25rem;
            text-transform: capitalize;
        }
        
        .status-Non_assigné { background-color: var(--primary); color: white; }
        .status-Assigné { background-color: var(--success); color: white; }
        .status-en_attente { background-color: #e2e3e5; color: #383d41; }
        .status-en_cours { background-color: #fff3cd; color: #856404; }
        .status-termine { background-color: #d4edda; color: #155724; }
        .status-annule { background-color: #f8d7da; color: #721c24; }
        
        .detail-label {
            font-weight: 600;
            color: #5a5c69;
        }
        
        .detail-value {
            color: #858796;
        }
        
        .btn-submit {
            background-color: var(--success);
            border-color: var(--success);
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        
        .btn-submit:hover {
            background-color: #17a673;
            border-color: #17a673;
        }
        
        .section-title {
            color: var(--primary);
            font-weight: 700;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')
    
    <div class="container py-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Détails de la demande #{{ $demande->id }}</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations principales</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="detail-label">Client</p>
                                <p class="detail-value">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ $demande->client->prenom }} {{ $demande->client->nom }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="detail-label">Téléphone</p>
                                <p class="detail-value">
                                    <i class="fas fa-phone mr-2"></i>
                                    {{ $demande->client->phone }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="detail-label">Véhicule</p>
                                <p class="detail-value">
                                    <i class="fas fa-car mr-2"></i>
                                    {{ $demande->voiture->model }} ({{ $demande->voiture->serie }})
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="detail-label">Statut</p>
                                <p>
                                    <span class="status-badge status-{{ str_replace(' ', '_', $demande->status) }}">
                                        {{ str_replace('_', ' ', $demande->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <p class="detail-label">Service</p>
                                <p class="detail-value">
                                    <i class="fas fa-tools mr-2"></i>
                                    {{ $demande->servicePanne->titre }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="detail-label">Catégorie</p>
                                <p class="detail-value">
                                    <i class="fas fa-list-alt mr-2"></i>
                                    {{ $demande->servicePanne->categoryPane->titre }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Proposition de prix</h6>
                    </div>
                    <div class="card-body">
                        <form id="prixForm" action="{{ route('demandes.ajouterPrixMainOeuvre', $demande->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="prix_main_oeuvre" class="form-label detail-label">
                                    <i class="fas fa-euro-sign mr-2"></i>Prix main d'œuvre (€)
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control" 
       id="prix_main_oeuvre" name="prix_main_oeuvre" 
       value="{{ old('prix_main_oeuvre', $demande->prix_main_oeuvre) }}"
       @if($demande->status !== 'Nouvelle_demande') disabled @endif
       required>

                                @error('prix_main_oeuvre')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-submit w-100">
                                <i class="fas fa-paper-plane mr-2"></i>Envoyer l'offre
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Forfait</h6>
                    </div>
                    <div class="card-body">
                        <p class="detail-value">
                            <i class="fas fa-tag mr-2"></i>
                            {{ $demande->forfait->nomForfait }}
                        </p>
                    </div>
                </div>
                @if($demande->status === 'offre_acceptee')
    <div class="card mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Assigner des techniciens</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="nombre_techniciens" class="form-label">Nombre de techniciens à assigner</label>
                <input type="number" min="1" max="{{ $techniciens->count() }}" class="form-control" id="nombre_techniciens" value="1">
            </div>

            <form id="assignTechniciensForm">
                <div id="techniciens_select_container">
                    <div class="mb-3">
                        <label class="form-label">Technicien 1</label>
                        <select class="form-select" name="techniciens[]" required>
                            <option value="" disabled selected>-- Sélectionner un technicien --</option>
                            @foreach($techniciens as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->prenom ?? '' }} {{ $tech->nom ?? $tech->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Assigner</button>
            </form>
        </div>
    </div>
@endif

            </div>
        </div>
    </div>
<script>
    const nombreInput = document.getElementById('nombre_techniciens');
    const container = document.getElementById('techniciens_select_container');
    const techniciens = @json($techniciens); // Passe la liste des techniciens en JS

    function createSelect(index) {
        const div = document.createElement('div');
        div.classList.add('mb-3');

        const label = document.createElement('label');
        label.classList.add('form-label');
        label.textContent = `Technicien ${index + 1}`;

        const select = document.createElement('select');
        select.classList.add('form-select');
        select.name = 'techniciens[]';
        select.required = true;

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = '-- Sélectionner un technicien --';
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

        const form = this;
        const formData = new FormData(form);

        fetch("{{ route('demandes.updateTechniciens', $demande->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Techniciens assignés',
                    text: data.message || "Les techniciens ont bien été assignés.",
                    confirmButtonColor: '#4e73df',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: data.message || "Une erreur est survenue lors de l'assignation.",
                    confirmButtonColor: '#e74a3b',
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "Une erreur réseau est survenue.",
                confirmButtonColor: '#e74a3b',
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
                        confirmButtonColor: '#4e73df',
                    }).then(() => {
                        // Optional: Reload or redirect if needed
                        // window.location.reload();
                    });
                } else {
                      Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: "L'offre a été envoyée, en attente d'acceptation du client.",
                        confirmButtonColor: '#4e73df',
                    })
                }
            })
            .catch(error => {
                  Swal.fire({
                        icon: 'success',
                        title: 'Succès!',
                        text: "L'offre a été envoyée, en attente d'acceptation du client.",
                        confirmButtonColor: '#4e73df',
                    })
            });
        });
    </script>
</body>
</html>