<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Pièces Recommandées</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar-container {
            min-height: 100vh;
        }
        .main-content {
            margin-left: 150px;
            padding: 30px;
            transition: all 0.3s;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: 20px;
        }
        .form-title {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        .piece-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .piece-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .piece-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .piece-title {
            font-weight: 600;
            color: #3498db;
            margin: 0;
        }
        .remove-piece {
            color: #e74c3c;
            cursor: pointer;
            font-size: 1.2rem;
        }
        .price-section, .availability-section {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .price-card, .availability-card {
            flex: 1;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8fafc;
        }
        .availability-card {
            position: relative;
        }
        .availability-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .availability-label {
            font-weight: 500;
            color: #2c3e50;
            margin: 0;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e74c3c;
            transition: .4s;
            border-radius: 24px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .toggle-slider {
            background-color: #2ecc71;
        }
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        .hidden-section {
            display: none;
        }
        .btn-add-piece {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-add-piece:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .btn-submit {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
        }
        .form-label {
            font-weight: 500;
            color: #34495e;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        .alert-danger {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div >
            @include('Sidebar.responsablePiece')
        </div>

        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <h1 class="form-title" style="margin-top: 50px">    &nbsp;&nbsp;Ajouter des pièces de rechange</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Erreurs de validation</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('piece_recommandee.store') }}" class="form-container">
                    @csrf
                    <input type="hidden" name="demande_id" value="{{ $demandeId }}">

                    <div id="pieces-container"></div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-add-piece" onclick="ajouterPiece()">
                            <i class="bi bi-plus-circle"></i> Ajouter une pièce
                        </button>
                        <button type="submit" class="btn btn-submit">
                            <i class="bi bi-save"></i> Enregistrer les pièces
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let pieceIndex = 0;

        function ajouterPiece() {
            const container = document.getElementById('pieces-container');

            const pieceHTML = `
                <div class="piece-card" id="piece-${pieceIndex}">
                    <div class="piece-header">
                        <h3 class="piece-title">Pièce #${pieceIndex + 1}</h3>
                        <i class="bi bi-trash remove-piece" onclick="supprimerPiece(${pieceIndex})"></i>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nom de la pièce</label>
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
                            <div class="availability-header">
                                <h5 class="availability-label">Pièce Originale</h5>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked onchange="toggleDisponibilite(this, 'pieces[${pieceIndex}][disponibiliteOriginal]', 'original-section-${pieceIndex}')">
                                    <span class="toggle-slider"></span>
                                </label>
                                <input type="hidden" name="pieces[${pieceIndex}][disponibiliteOriginal]" value="1">
                            </div>
                            <div id="original-section-${pieceIndex}">
                                <div class="mb-3">
                                    <label class="form-label">Prix Original</label>
                                    <input type="number" step="0.01" name="pieces[${pieceIndex}][prixOriginal]" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date de disponibilité</label>
                                    <input type="date" name="pieces[${pieceIndex}][datedisponibiliteOriginale]" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="availability-card">
                            <div class="availability-header">
                                <h5 class="availability-label">Pièce Commerciale</h5>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked onchange="toggleDisponibilite(this, 'pieces[${pieceIndex}][disponibilitCommercial]', 'commercial-section-${pieceIndex}')">
                                    <span class="toggle-slider"></span>
                                </label>
                                <input type="hidden" name="pieces[${pieceIndex}][disponibilitCommercial]" value="1">
                            </div>
                            <div id="commercial-section-${pieceIndex}">
                                <div class="mb-3">
                                    <label class="form-label">Prix Commercial</label>
                                    <input type="number" step="0.01" name="pieces[${pieceIndex}][prixCommercial]" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date de disponibilité</label>
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

        function supprimerPiece(index) {
            const pieceElement = document.getElementById(`piece-${index}`);
            if (pieceElement) {
                pieceElement.remove();
                // Réorganiser les numéros des pièces restantes
                const pieces = document.querySelectorAll('.piece-title');
                pieces.forEach((title, i) => {
                    title.textContent = `Pièce #${i + 1}`;
                });
            }
        }

        function toggleDisponibilite(checkbox, inputName, sectionId) {
            const hiddenInput = checkbox.parentElement.parentElement.querySelector('input[type=hidden]');
            const section = document.getElementById(sectionId);
            const isActive = checkbox.checked;

            if (!isActive) {
                // Désactiver
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
