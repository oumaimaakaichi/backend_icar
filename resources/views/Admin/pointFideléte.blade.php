<!DOCTYPE html>
<html lang="fr">
<body>
<!-- Sidebar -->
@include('Sidebar.sidebar')

<div class="container-fluid py-4"  style="margin-top: 70px">
    <!-- En-tête -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="mb-0">
                <i class="fas fa-star me-2 text-warning"></i>Loyalty Points Management
            </h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transactionModal">
                <i class="fas fa-plus-circle me-1"></i>New Transaction
            </button>
        </div>
    </div>
    <!-- Carte des statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-2 py-2 h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Points Awarded
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                2000 pts
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal de transaction -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exchange-alt me-2"></i>New Transaction
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('loyalty-points.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Sélection de l'utilisateur -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Client</label>
                                <select class="form-select select2" id="user_id" name="user_id" required>
                                    <option value="">Select a client</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" data-balance="{{ $user->loyaltyPointsBalance() }}">
                                            {{ $user->nom }}   {{ $user->prenom }} (Balance: {{ $user->loyaltyPointsBalance() }} pts)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sélection du technicien -->
                            <div class="col-md-6">
                                <label for="technician_id" class="form-label">Technician</label>
                                <select class="form-select select2" id="technician_id" name="technician_id" required>
                                    <option value="">Select a technician</option>
                                    @foreach($technicians as $tech)
                                        <option value="{{ $tech->id }}">{{ $tech->nom }}    {{ $user->prenom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type de transaction -->
                            <div class="col-md-4">
                                <label for="type" class="form-label">Type d'opération</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="credit">Credit (part discount)</option>
                                    <option value="debit">Debit (part withdrawal)</option>

                                </select>
                            </div>

                            <!-- Pièce de rechange -->
                            <div class="col-md-8">
                                <label for="spare_part_id" class="form-label">Spare Part</label>
                                <select class="form-select select2" id="spare_part_id" name="spare_part_id" required>
                                    <option value="">Select a part</option>

                                    @foreach($spareParts as $part)
                                        <option value="{{ $part->id }}" data-value="{{ $part->base_point_value }}">
                                            {{ $part->nom_piece }} (Valeur: {{ $part->base_point_value }} pts)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Valeur réelle -->
                            <div class="col-md-4">
                                <label for="actual_value" class="form-label"> Actual Value.</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" id="actual_value"
                                           name="actual_value" min="0" required>
                                    <span class="input-group-text">pts</span>
                                </div>
                                <small class="text-muted">Determined by the technician</small>
                            </div>
                            <!-- Facteur d'ajustement -->
                            <div class="col-md-4">
                                <label for="adjustment_factor" class="form-label"> Adjustment factor</label>
                                <div class="input-group">
                                    <span class="input-group-text">×</span>
                                    <input type="number" step="0.1" class="form-control" id="adjustment_factor"
                                           name="adjustment_factor" min="0.1" max="10" value="1" required>
                                </div>
                            </div>
                            <!-- Quantité -->
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity"
                                       name="quantity" min="1" value="1" required>
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Détails supplémentaires..."></textarea>
                            </div>

                            <!-- Calcul des points -->
                            <div class="col-12">
                                <div class="alert alert-info py-2 mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            <strong>Calculated points:</strong>
                                            <span id="calculated-points" class="fw-bold">0</span> pts
                                        </span>
                                        <span id="balance-info" class="badge bg-secondary d-none">
                                            New balance: <span id="new-balance">0</span> pts
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Historique des transactions -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2 text-primary"></i>Transaction History
                </h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter me-1"></i>  c
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                        <li><a class="dropdown-item" href="#">Cette semaine</a></li>
                        <li><a class="dropdown-item" href="#">Ce mois</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Toutes</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Client</th>
                            <th>Technicien</th>
                            <th>Points</th>
                            <th>Type</th>
                            <th>Pièce</th>

                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($points as $point)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $point->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $point->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">

                                    <div>{{ $point->user->nom }} {{ $point->user->prenom }}</div>
                                </div>
                            </td>
                            <td>{{ $point->technician->nom }} {{ $point->technician->prenom }}</td>
                            <td class="{{ $point->type === 'credit' ? 'text-success' : 'text-danger' }} fw-bold">
                                {{ $point->type === 'credit' ? '+' : '-' }}{{ number_format($point->points, 2) }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $point->type === 'credit' ? 'success' : 'danger' }}">
                                    {{ $point->type === 'credit' ? 'Crédit' : 'Débit' }}
                                </span>
                            </td>
                            <td>
                                {{ $point->sparePart->nom_piece }}
                            </td>

                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('loyalty-points.edit', $point->id) }}"
                                       class="btn btn-outline-primary" title="Modifier">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    &nbsp;

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <h5>Aucune transaction enregistrée</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: bold;
    }
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .table-hover tbody tr {
        transition: all 0.2s;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser Select2
    $('.select2').select2({
        width: '100%',
        dropdownParent: $('#transactionModal')
    });

    // Éléments du formulaire
    const sparePartSelect = document.getElementById('spare_part_id');
    const userSelect = document.getElementById('user_id');
    const actualValueInput = document.getElementById('actual_value');
    const adjustmentInput = document.getElementById('adjustment_factor');
    const quantityInput = document.getElementById('quantity');
    const typeSelect = document.getElementById('type');
    const pointsDisplay = document.getElementById('calculated-points');
    const balanceInfo = document.getElementById('balance-info');
    const newBalanceSpan = document.getElementById('new-balance');

    function calculatePoints() {
        const actualValue = parseFloat(actualValueInput.value) || 0;
        const adjustment = parseFloat(adjustmentInput.value) || 1;
        const quantity = parseInt(quantityInput.value) || 1;
        const type = typeSelect.value;

        let points = actualValue * adjustment * quantity;
        points = type === 'debit' ? -points : points;

        pointsDisplay.textContent = Math.abs(points).toFixed(2);

        // Calcul du nouveau solde
        const selectedUser = userSelect.options[userSelect.selectedIndex];
        if (selectedUser && selectedUser.dataset.balance) {
            const currentBalance = parseFloat(selectedUser.dataset.balance) || 0;
            const newBalance = currentBalance + points;

            newBalanceSpan.textContent = newBalance.toFixed(2);
            balanceInfo.classList.remove('d-none');

            if (type === 'debit' && newBalance < 0) {
                balanceInfo.classList.remove('bg-secondary');
                balanceInfo.classList.add('bg-danger');
            } else {
                balanceInfo.classList.remove('bg-danger');
                balanceInfo.classList.add('bg-secondary');
            }
        } else {
            balanceInfo.classList.add('d-none');s
        }
    }

    // Initialiser la valeur réelle avec la valeur de base quand une pièce est sélectionnée
    sparePartSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const baseValue = parseFloat(selectedOption.dataset.value) || 0;
        actualValueInput.value = baseValue.toFixed(2);
        calculatePoints();
    });

    // Écouteurs d'événements
    [actualValueInput, adjustmentInput, quantityInput, typeSelect, userSelect].forEach(element => {
        element.addEventListener('change', calculatePoints);
        element.addEventListener('input', calculatePoints);
    });
    calculatePoints();
});
</script>
@endsection
</body>
</html>
