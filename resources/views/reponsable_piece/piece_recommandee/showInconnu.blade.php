<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Pièces Recommandées | GaragePro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3f37c9;
            --accent: #f72585;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #f1f3f5;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1e293b;
            line-height: 1.6;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            transform: translateY(-2px);
        }

        .header-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.75rem;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .badge-pill {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 500;
            color: var(--dark);
        }

        .divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.08);
            margin: 1.5rem 0;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
        }

        .btn-outline-modern {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-modern:hover {
            background: var(--primary-light);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .status-new {
            background-color: #e6f7ff;
            color: #1890ff;
        }

        .status-assigned {
            background-color: #fff7e6;
            color: #fa8c16;
        }

        .status-completed {
            background-color: #f6ffed;
            color: #52c41a;
        }

        .floating-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .floating-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 4px;
            background: var(--primary);
            border-radius: 4px;
        }

        .problem-description {
            background-color: var(--light-gray);
            border-radius: 12px;
            padding: 1.5rem;
            white-space: pre-line;
        }

        /* Styles pour le tableau des pièces */
        .piece-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .piece-table thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .piece-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .piece-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        .piece-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .piece-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .add-piece-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .add-piece-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        }

        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .piece-img {
                width: 40px;
                height: 40px;
            }

            .floating-btn {
                width: 48px;
                height: 48px;
                bottom: 1rem;
                right: 1rem;
            }
        }
    </style>
</head>
<body style="margin-left: 00px">

@include('Sidebar.responsablePiece')

<div class="container py-4" style="margin-top: 60px;margin-right:40px">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Add Recommended Parts
</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('reponsable_piece.demandesInconnu') }}" class="text-decoration-none">Requests</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Request</li>
                </ol>
            </nav>
        </div>
        <span class="status-badge status-new">
            <i class="fas fa-circle me-2" style="font-size: 8px;"></i>
             @if ($demande->status === 'en_attente')
        New
    @elseif ($demande->status === 'Assignée')
        Assigned
    @else
        {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
    @endif
        </span>
    </div>

    <div class="row">
        <!-- Client Info -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-4 h-100">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar me-3">
                        {{ substr($demande->client->prenom, 0, 1) }}{{ substr($demande->client->nom, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $demande->client->prenom }} {{ $demande->client->nom }}</h5>
                        <div class="text-muted">Demande #{{ $demande->id }}</div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="info-label">Contact</div>
                    <div class="info-value">
                        <a href="tel:{{ $demande->client->phone }}" class="text-decoration-none d-block mb-1">
                            <i class="fas fa-phone me-2"></i>{{ $demande->client->phone }}
                        </a>
                    </div>
                </div>

                <div class="divider"></div>

                <h6 class="section-title mb-3">Car</h6>

                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="info-label">Model</div>
                        <div class="info-value">{{ $demande->voiture->model }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="info-label">Serie</div>
                        <div class="info-value">{{ $demande->voiture->serie ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Year</div>
                        <div class="info-value">{{ $demande->voiture->date_fabrication ?? '-' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="info-label">Color</div>
                        <div class="info-value">{{ $demande->voiture->couleur ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8 mb-4">
            <!-- Pièces déjà ajoutées -->
            @if(count($pieces) > 0)
                <div class="glass-card p-4 mb-4">
                    <h6 class="section-title">Spare parts
 </h6>

                    <div class="table-responsive">
                        <table class="piece-table">
                            <thead>
                                <tr>
    <th>Part</th>
    <th>Reference</th>
    <th>Vehicle Type</th>
    <th>Actions</th>
</tr>

                            </thead>
                            <tbody>
                                @foreach($pieces as $piece)
                                <tr>
                                    <td>{{ $piece->nom_piece }}</td>
                                    <td>{{ $piece->num_piece }}</td>
                                    <td>{{ $piece->type_voiture }}</td>
                      <td>
    @php
        $pieceAlreadyAdded = false;
        if (!empty($demande->disponibilite_pieces)) {
            foreach ($demande->disponibilite_pieces as $dispoPiece) {
                if (isset($dispoPiece['idPiece']) && $dispoPiece['idPiece'] == $piece->id) {
                    $pieceAlreadyAdded = true;
                    break;
                }
                // Compatibilité avec l'ancienne structure si nécessaire
                if (isset($dispoPiece['piece_id']) && $dispoPiece['piece_id'] == $piece->id) {
                    $pieceAlreadyAdded = true;
                    break;
                }
            }
        }
    @endphp

    @if(!$pieceAlreadyAdded)
        <button class="btn btn-sm btn-outline-success add-piece" data-piece-id="{{ $piece->id }}">
            <i class="fas fa-plus"></i>
        </button>
    @else
        <span class="badge bg-success">Already added</span>
    @endif
</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Recherche de pièces -->



        </div>
    </div>
</div>

<!-- Floating Action Button -->
<a  class="floating-btn bg-primary text-white">
    <i class="fas fa-arrow-left"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Recherche de pièces
    document.getElementById('pieceSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#piecesTableBody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });






</script>
<script>
// Attendre que le DOM soit chargé
// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Check that the buttons exist before adding event listeners
    const addPieceButtons = document.querySelectorAll('.add-piece');

    if (addPieceButtons.length > 0) {
        addPieceButtons.forEach(button => {
            button.addEventListener('click', function() {
                const pieceId = this.dataset.pieceId;
                const pieceRow = this.closest('tr');

                if (!pieceRow) return;

                const pieceName = pieceRow.querySelector('td:first-child')?.textContent || '';

                Swal.fire({
                    title: `<strong>Add Availability - ${pieceName}</strong>`,
                    icon: 'question',
                    width: 700,
                    padding: '2em',
                    background: '#f0f4ff',
                    html: `
                        <div style="text-align: left;">
                            <h5 class="mb-3">Original Part</h5>

                            <label for="disponibiliteOriginal" class="form-label">Available?</label>
                            <select id="disponibiliteOriginal" class="form-select mb-3">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>

                            <label for="prixOriginal" class="form-label">Original Price (DH)</label>
                            <input type="number" id="prixOriginal" class="form-control mb-3" min="0" step="0.01">

                            <label for="dateDisponibiliteOriginale" class="form-label">Availability Date</label>
                            <input type="date" id="dateDisponibiliteOriginale" class="form-control mb-4">

                            <hr class="my-4">

                            <h5 class="mb-3">Commercial Part</h5>

                            <label for="disponibiliteCommercial" class="form-label">Available?</label>
                            <select id="disponibiliteCommercial" class="form-select mb-3">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>

                            <label for="prixCommercial" class="form-label">Commercial Price (DH)</label>
                            <input type="number" id="prixCommercial" class="form-control mb-3" min="0" step="0.01">

                            <label for="dateDisponibiliteComercial" class="form-label">Availability Date</label>
                            <input type="date" id="dateDisponibiliteComercial" class="form-control mb-3">
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3f37c9',
                    cancelButtonColor: '#f44336',
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            piece_id: pieceId,
                            prixOriginal: document.getElementById('prixOriginal')?.value || null,
                            prixCommercial: document.getElementById('prixCommercial')?.value || null,
                            dateDisponibiliteOriginale: document.getElementById('dateDisponibiliteOriginale')?.value || null,
                            dateDisponibiliteComercial: document.getElementById('dateDisponibiliteComercial')?.value || null,
                            disponibiliteOriginal: document.getElementById('disponibiliteOriginal')?.value || 0,
                            disponibiliteCommercial: document.getElementById('disponibiliteCommercial')?.value || 0
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = result.value;

                        fetch(`/disponibilite-piece/{{ $demande->id }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                idPiece: data.piece_id,
                                prixOriginal: data.prixOriginal,
                                prixCommercial: data.prixCommercial,
                                datedisponibiliteOriginale: data.dateDisponibiliteOriginale,
                                dateDisponibiliteComercial: data.dateDisponibiliteComercial,
                                disponibiliteOriginal: data.disponibiliteOriginal,
                                disponibiliteCommercial: data.disponibiliteCommercial
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error('Invalid server response');
                            }
                            return res.json();
                        })
                        .then(response => {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                throw new Error(response.message || 'Unknown error');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message || 'An error occurred while saving.',
                            });
                        });
                    }
                });
            });
        });
    } else {
        console.warn('No ".add-piece" button found in the document');
    }
});

</script>


</body>
</html>
