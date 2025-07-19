<html>

<head>
    <style>
.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-text {
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.table td {
    vertical-align: middle;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

</head>
<body>

  @include('Sidebar.sidebarExpert')

<div class="container-fluid">
    <div class="row"  style="margin-top: 90px">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Liste des Techniciens</h3>
                    <div class="btn-group">


                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtres -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="approved">Approuvé</option>
                                <option value="rejected">Rejeté</option>
                            </select>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="activeFilter">
                                <option value="">Tous</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchFilter" placeholder="Rechercher...">
                        </div>
                    </div>

                    <!-- Tableau des techniciens -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="techniciensTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Logo</th>
                                    <th>Nom Complet</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>

                                    <th>État</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($techniciens as $technicien)
                                    <tr>
                                        <td> <div class="avatar me-2">
                                                    <span class="avatar-text">{{ strtoupper(substr($technicien->nom, 0, 1)) }}{{ strtoupper(substr($technicien->prenom, 0, 1)) }}</span>
                                                </div></td>
                                        <td>
                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <strong>{{ $technicien->nom }} {{ $technicien->prenom }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $technicien->email }}</td>
                                        <td>{{ $technicien->phone }}</td>


                                        <td>
                                            @if($technicien->isSuspended())
                                                <span class="badge bg-danger">Suspendu</span>
                                                @if($technicien->suspension_reason)
                                                    <br><small class="text-muted">{{ $technicien->suspension_reason }}</small>
                                                @endif
                                            @elseif($technicien->isActive)
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-secondary">Inactif</span>
                                            @endif
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Aucun technicien trouvé</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <p class="text-muted">
                                Affichage de {{ $techniciens->firstItem() ?? 0 }} à {{ $techniciens->lastItem() ?? 0 }}
                                sur {{ $techniciens->total() }} techniciens
                            </p>
                        </div>
                        <div>
                            {{ $techniciens->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let currentTechnicienId = null;

// Filtres
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const atelierFilter = document.getElementById('atelierFilter');
    const activeFilter = document.getElementById('activeFilter');
    const searchFilter = document.getElementById('searchFilter');

    // Implémentation des filtres côté client
    [statusFilter, atelierFilter, activeFilter, searchFilter].forEach(filter => {
        filter.addEventListener('change', applyFilters);
        filter.addEventListener('input', applyFilters);
    });
});

function applyFilters() {
    const statusValue = document.getElementById('statusFilter').value.toLowerCase();
    const atelierValue = document.getElementById('atelierFilter').value.toLowerCase();
    const activeValue = document.getElementById('activeFilter').value;
    const searchValue = document.getElementById('searchFilter').value.toLowerCase();

    const rows = document.querySelectorAll('#techniciensTable tbody tr');

    rows.forEach(row => {
        const cells = row.cells;
        if (cells.length < 2) return; // Skip empty rows

        const statusText = cells[6].textContent.toLowerCase();
        const atelierText = cells[4].textContent.toLowerCase();
        const activeText = cells[7].textContent.toLowerCase();
        const searchText = (cells[1].textContent + ' ' + cells[2].textContent).toLowerCase();

        let show = true;

        if (statusValue && !statusText.includes(statusValue)) show = false;
        if (atelierValue === 'sans_atelier' && !atelierText.includes('sans atelier')) show = false;
        if (atelierValue && atelierValue !== 'sans_atelier' && !atelierText.includes(atelierValue)) show = false;
        if (activeValue && !activeText.includes(activeValue === '1' ? 'actif' : 'inactif')) show = false;
        if (searchValue && !searchText.includes(searchValue)) show = false;

        row.style.display = show ? '' : 'none';
    });
}








</script>
</body>

</html>














