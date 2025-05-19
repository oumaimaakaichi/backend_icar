<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Pièces Recommandées</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .toggle-icon {
            cursor: pointer;
            font-size: 1.5rem;
            margin-left: 10px;
        }
        .price-section {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;

        }
        .price-card {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .availability-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .availability-card {
            width: 48%;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .hidden-section {
            display: none;
        }
    </style>
</head>
<body class="container mt-5">
    <div class="sidebar-container">
        @include('Sidebar.responsablePiece')
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('piece_recommandee.store') }}" style="margin-top: 50px">
        @csrf
        <input type="hidden" name="demande_id" value="{{ $demandeId }}">

        <div id="pieces-container"></div>

        <button type="button" class="btn btn-outline-primary mb-3" onclick="ajouterPiece()">
            <i class="bi bi-plus-circle"></i> Ajouter une pièce
        </button>
        <button type="submit" class="btn btn-success" style="margin-bottom:10px">
            <i class="bi bi-save"></i> Enregistrer
        </button>
    </form>

    <script>
        let pieceIndex = 0;

        function ajouterPiece() {
            const container = document.getElementById('pieces-container');

            const pieceHTML = `
                <div class="border rounded p-3 mb-3" style="background-color: #fff;">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom de la pièce</label>
                        <select class="form-select" name="pieces[${pieceIndex}][idPiece]" required>
                            @foreach($pieces as $piece)
                                <option value="{{ $piece->id }}">{{ $piece->nom_piece }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="price-section">
                        <div class="price-card">
                            <div class="mb-3">
                                <label class="form-label">Prix Main d'œuvre</label>
                                <input type="number" step="0.01" name="pieces[${pieceIndex}][prix_main_oeuvre]" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="availability-section">
                        <div class="availability-card">
                            <div class="d-flex align-items-center mb-2">
                                <label class="form-label me-2">Disponibilité piéce Originale</label>
                                <span class="toggle-icon bi bi-toggle-on text-success"
                                      onclick="toggleDisponibilite(this, 'pieces[${pieceIndex}][disponibiliteOriginal]', 'original-section-${pieceIndex}')"></span>
                                <input type="hidden" name="pieces[${pieceIndex}][disponibiliteOriginal]" value="1">
                            </div>
                            <div id="original-section-${pieceIndex}">
                                <div class="mb-3">
                                    <label class="form-label">Prix Original</label>
                                    <input type="number" step="0.01" name="pieces[${pieceIndex}][prixOriginal]" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date dispo Originale</label>
                                    <input type="date" name="pieces[${pieceIndex}][datedisponibiliteOriginale]" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="availability-card">
                            <div class="d-flex align-items-center mb-2">
                                <label class="form-label me-2">Disponibilité piéce Commerciale</label>
                                <span class="toggle-icon bi bi-toggle-on text-success"
                                      onclick="toggleDisponibilite(this, 'pieces[${pieceIndex}][disponibilitCommercial]', 'commercial-section-${pieceIndex}')"></span>
                                <input type="hidden" name="pieces[${pieceIndex}][disponibilitCommercial]" value="1">
                            </div>
                            <div id="commercial-section-${pieceIndex}">
                                <div class="mb-3">
                                    <label class="form-label">Prix Commercial</label>
                                    <input type="number" step="0.01" name="pieces[${pieceIndex}][prixCommercial]" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date dispo Commercial</label>
                                    <input type="date" name="pieces[${pieceIndex}][dateDisponibiliteComercial]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', pieceHTML);
            pieceIndex++;
        }

        function toggleDisponibilite(icon, inputName, sectionId) {
            const hiddenInput = icon.parentElement.querySelector('input[type=hidden]');
            const section = document.getElementById(sectionId);
            const isActive = icon.classList.contains('bi-toggle-on');

            if (isActive) {
                // Désactiver
                icon.classList.remove('bi-toggle-on', 'text-success');
                icon.classList.add('bi-toggle-off', 'text-danger');
                hiddenInput.value = 0;
                section.classList.add('hidden-section');

                // Rendre les champs non requis quand masqués
                const inputs = section.querySelectorAll('input');
                inputs.forEach(input => {
                    input.removeAttribute('required');
                    input.value = '';
                });
            } else {
                // Activer
                icon.classList.remove('bi-toggle-off', 'text-danger');
                icon.classList.add('bi-toggle-on', 'text-success');
                hiddenInput.value = 1;
                section.classList.remove('hidden-section');

                // Rendre les champs requis à nouveau
                const inputs = section.querySelectorAll('input');
                inputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            }
        }

        // Ajouter une première pièce automatiquement au chargement
        document.addEventListener('DOMContentLoaded', function() {
            ajouterPiece();
        });
    </script>
</body>
</html>
