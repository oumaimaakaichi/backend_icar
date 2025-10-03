<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Recommended Parts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3498db;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --dark-color: #2c3e50;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --border-color: #e0e0e0;
            --shadow-light: 0 2px 10px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 5px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
            --border-radius-small: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .sidebar-container {
            min-height: 200vh;
            background: var(--white);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            width: 1100px;
            padding: 30px;
            transition: var(--transition);
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            box-shadow: var(--shadow-medium);
        }

        .page-title {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .form-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            padding: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .piece-card {
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 30px;
            margin-bottom: 30px;
            background: var(--white);
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .piece-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        }

        .piece-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
        }

        .piece-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f3f4;
        }

        .piece-title {
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .piece-number {
            background: var(--primary-color);
            color: var(--white);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .remove-piece {
            color: var(--danger-color);
            cursor: pointer;
            font-size: 1.4rem;
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-piece:hover {
            background: rgba(231, 76, 60, 0.1);
            transform: scale(1.1);
        }

        .price-section, .availability-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        @media (min-width: 768px) {
            .availability-section {
                grid-template-columns: 1fr 1fr;
            }
        }

        .price-card, .availability-card {
            border: 2px solid #f1f3f4;
            border-radius: var(--border-radius-small);
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f3f4 100%);
            transition: var(--transition);
        }

        .price-card:hover, .availability-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .availability-card {
            position: relative;
        }

        .availability-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .availability-label {
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            font-size: 1.1rem;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
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
            background-color: var(--danger-color);
            transition: var(--transition);
            border-radius: 30px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: var(--white);
            transition: var(--transition);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked + .toggle-slider {
            background-color: var(--success-color);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(30px);
        }

        .hidden-section {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
        }

        .visible-section {
            display: block;
            opacity: 1;
            transform: translateY(0);
            transition: var(--transition);
        }

        .btn-add-piece {
            background: linear-gradient(135deg, #2980b9, #2980b9);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-add-piece:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--success-color), #27ae60);
            color: var(--white);
            border: none;
            padding: 15px 35px;
            border-radius: var(--border-radius-small);
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border-radius: var(--border-radius-small);
            padding: 12px 18px;
            border: 2px solid var(--border-color);
            transition: var(--transition);
            font-size: 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.15);
            transform: translateY(-2px);
        }

        .alert-danger {
            border-radius: var(--border-radius-small);
            border: none;
            background: linear-gradient(135deg, #fee, #fdd);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .form-container {
                padding: 20px;
            }

            .piece-card {
                padding: 20px;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        .main-oeuvre-only {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px dashed #6c757d;
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .main-oeuvre-only h4 {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .main-oeuvre-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .main-oeuvre-content {
            display: none;
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div style="margin-left: 50px">
        <div>
            @include('Sidebar.responsablePiece')
        </div>

        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="page-header">
                    <h1 class="page-title">
                        <i class="bi bi-tools"></i>
                        Add Recommended Parts
                    </h1>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Validation Errors
                        </h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('piece_recommandee.store') }}" class="form-container" id="spareParts">
                    @csrf
                    <input type="hidden" name="demande_id" value="{{ $demandeId }}">
                    <input type="hidden" name="main_oeuvre_seule" id="mainOeuvreSeule" value="0">

                    <!-- New section for labor-only option -->
                    <div class="main-oeuvre-only">
                        <h4><i class="bi bi-wrench-adjustable"></i> Alternative Option</h4>
                        <div class="main-oeuvre-toggle">
                            <span>Recommend labor only</span>
                            <label class="toggle-switch">
                                <input type="checkbox" id="toggleMainOeuvre" onchange="toggleMainOeuvreOption(this)">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="main-oeuvre-content" id="mainOeuvreContent">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-currency-euro"></i>
                                    Labor Cost
                                </label>
                                <input type="number" step="0.01" min="0" name="prix_main_oeuvre_seule"
                                    id="prixMainOeuvreSeule" class="form-control" placeholder="0.00 €">
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                No parts will be recommended, only the labor cost.
                            </div>
                        </div>
                    </div>

                    <div id="pieces-container">
                        <div class="empty-state" id="emptyState">
                            <i class="bi bi-box"></i>
                            <h3>No parts added</h3>
                            <p>Click on "Add a part" to get started</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                        <button type="button" class="btn btn-add-piece" id="btnAddPiece" onclick="ajouterPiece()" style="color: rgb(243, 237, 237) ;background-color:#3498db">
                            <i class="bi bi-plus-circle"></i>
                           <b>Add a Part</b>
                        </button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="bi bi-arrow-clockwise"></i>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-save"></i>
                                Save Parts
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <script>
        let pieceIndex = 0;
        const pieces = @json($pieces ?? []);
        let mainOeuvreOnly = false;

        function toggleMainOeuvreOption(checkbox) {
            mainOeuvreOnly = checkbox.checked;
            document.getElementById('mainOeuvreSeule').value = mainOeuvreOnly ? '1' : '0';

            const mainOeuvreContent = document.getElementById('mainOeuvreContent');
            const piecesContainer = document.getElementById('pieces-container');
            const btnAddPiece = document.getElementById('btnAddPiece');
            const emptyState = document.getElementById('emptyState');

            if (mainOeuvreOnly) {
                mainOeuvreContent.style.display = 'block';
                piecesContainer.style.display = 'none';
                btnAddPiece.disabled = true;
                btnAddPiece.style.opacity = '0.5';

                // Empty the parts container but keep the empty state hidden
                piecesContainer.innerHTML = '';
                if (emptyState) emptyState.style.display = 'none';
            } else {
                mainOeuvreContent.style.display = 'none';
                piecesContainer.style.display = 'block';
                btnAddPiece.disabled = false;
                btnAddPiece.style.opacity = '1';

                // Show empty state if no parts
                checkEmptyState();
            }
        }

        function ajouterPiece() {
            if (mainOeuvreOnly) return;

            const container = document.getElementById('pieces-container');
            const emptyState = document.getElementById('emptyState');

            if (emptyState) {
                emptyState.style.display = 'none';
            }

            const pieceHTML = `
                <div class="piece-card fade-in" id="piece-${pieceIndex}">
                    <div class="piece-header">
                        <h3 class="piece-title">
                            <span class="piece-number">${pieceIndex + 1}</span>
                            Spare Part
                        </h3>
                        <i class="bi bi-trash remove-piece" onclick="supprimerPiece(${pieceIndex})" title="Delete this part"></i>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-wrench"></i>
                            Part Name
                        </label>
                        <select class="form-select" name="pieces[${pieceIndex}][idPiece]" required>
                            <option value="">Select a part...</option>
                            ${pieces.map(piece =>
                                `<option value="${piece.id}">${piece.nom_piece}</option>`
                            ).join('')}
                        </select>
                    </div>

                    <div class="price-section">
                        <div class="price-card">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-currency-euro"></i>
                                    Labor Cost
                                </label>
                                <input type="number" step="0.01" min="0" name="pieces[${pieceIndex}][prix_main_oeuvre]" class="form-control" required placeholder="0.00 €">
                            </div>
                        </div>
                    </div>

                    <div class="availability-section">
                        <div class="availability-card">
                            <div class="availability-header">
                                <h5 class="availability-label">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    Original Part
                                </h5>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked onchange="toggleDisponibilite(this, 'pieces[${pieceIndex}][disponibiliteOriginal]', 'original-section-${pieceIndex}')">
                                    <span class="toggle-slider"></span>
                                </label>
                                <input type="hidden" name="pieces[${pieceIndex}][disponibiliteOriginal]" value="1">
                            </div>
                            <div id="original-section-${pieceIndex}" class="visible-section">
                                <div class="mb-3">
                                    <label class="form-label">Original Price</label>
                                    <input type="number" step="0.01" min="0" name="pieces[${pieceIndex}][prixOriginal]" class="form-control" required placeholder="0.00 €">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Availability Date</label>
                                    <input type="date" name="pieces[${pieceIndex}][datedisponibiliteOriginale]" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="availability-card">
                            <div class="availability-header">
                                <h5 class="availability-label">
                                    <i class="bi bi-shop text-primary"></i>
                                    Commercial Part
                                </h5>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked onchange="toggleDisponibilite(this, 'pieces[${pieceIndex}][disponibilitCommercial]', 'commercial-section-${pieceIndex}')">
                                    <span class="toggle-slider"></span>
                                </label>
                                <input type="hidden" name="pieces[${pieceIndex}][disponibilitCommercial]" value="1">
                            </div>
                            <div id="commercial-section-${pieceIndex}" class="visible-section">
                                <div class="mb-3">
                                    <label class="form-label">Commercial Price</label>
                                    <input type="number" step="0.01" min="0" name="pieces[${pieceIndex}][prixCommercial]" class="form-control" required placeholder="0.00 €">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Availability Date</label>
                                    <input type="date" name="pieces[${pieceIndex}][dateDisponibiliteComercial]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', pieceHTML);
            pieceIndex++;
            updatePieceNumbers();
        }

        function supprimerPiece(index) {
            if (confirm('Are you sure you want to delete this part?')) {
                const pieceElement = document.getElementById(`piece-${index}`);
                if (pieceElement) {
                    pieceElement.style.transform = 'translateX(-100%)';
                    pieceElement.style.opacity = '0';
                    setTimeout(() => {
                        pieceElement.remove();
                        updatePieceNumbers();
                        checkEmptyState();
                    }, 300);
                }
            }
        }

        function updatePieceNumbers() {
            const pieces = document.querySelectorAll('.piece-number');
            pieces.forEach((number, index) => {
                number.textContent = index + 1;
            });
        }

        function checkEmptyState() {
            const container = document.getElementById('pieces-container');
            const emptyState = document.getElementById('emptyState');
            const pieces = container.querySelectorAll('.piece-card');

            if (pieces.length === 0 && !mainOeuvreOnly) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }

        function toggleDisponibilite(checkbox, inputName, sectionId) {
            const hiddenInput = checkbox.parentElement.parentElement.querySelector('input[type=hidden]');
            const section = document.getElementById(sectionId);
            const isActive = checkbox.checked;

            if (!isActive) {
                hiddenInput.value = 0;
                section.classList.remove('visible-section');
                section.classList.add('hidden-section');

                const inputs = section.querySelectorAll('input');
                inputs.forEach(input => {
                    input.removeAttribute('required');
                    input.value = '';
                });
            } else {
                hiddenInput.value = 1;
                section.classList.remove('hidden-section');
                section.classList.add('visible-section');

                const inputs = section.querySelectorAll('input');
                inputs.forEach(input => {
                    if (input.type !== 'hidden') {
                        input.setAttribute('required', 'required');
                    }
                });
            }
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
                // Disable labor-only option
                document.getElementById('toggleMainOeuvre').checked = false;
                toggleMainOeuvreOption(document.getElementById('toggleMainOeuvre'));

                // Reset parts container
                document.getElementById('pieces-container').innerHTML = `
                    <div class="empty-state" id="emptyState">
                        <i class="bi bi-box"></i>
                        <h3>No parts added</h3>
                        <p>Click on "Add a part" to get started</p>
                    </div>
                `;

                // Reset labor-only field
                document.getElementById('prixMainOeuvreSeule').value = '';

                pieceIndex = 0;
            }
        }

        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        // Form submission
        document.getElementById('spareParts').addEventListener('submit', function(e) {
            showLoading();

            // Additional validation
            if (mainOeuvreOnly) {
                const prixMainOeuvre = document.getElementById('prixMainOeuvreSeule').value;
                if (!prixMainOeuvre || prixMainOeuvre <= 0) {
                    e.preventDefault();
                    alert('Please enter a valid labor cost');
                    hideLoading();
                    return false;
                }
            }

            // Let the form submit normally
        });

        // Initialize with one piece
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                ajouterPiece();
            }, 500);
        });
    </script>
</body>
</html>
