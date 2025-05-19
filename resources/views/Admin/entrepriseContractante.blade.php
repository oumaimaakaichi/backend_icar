<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contracting Companies Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 40px;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebar')
<div class="container" style="margin-top: 100px">
    <h2 class="mb-4 text-center">Contracting Companies Management</h2>
    <!-- Tableau des entreprises -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Activated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entreprises as $key => $entreprise)
                    <tr>
                        <td>{{ $entreprise->nom_entreprise }}</td>
                        <td>{{ $entreprise->email }}</td>
                        <td>{{ $entreprise->ville }}</td>
                        <td>{{ $entreprise->num_contact }}</td>
                        <td>
                            @if($entreprise->statut_demande === 'en_attente')
                                <span style="color: blue;">Pending</span>
                            @elseif($entreprise->statut_demande === 'acceptee')
                                <span style="color: green;">Accepted</span>
                            @elseif($entreprise->statut_demande === 'refusee')
                                <span style="color: red;">Refused</span>
                            @endif
                        </td>
                        <td>
                            @if($entreprise->est_actif)
                                <span style="color: green;">Yes</span>
                            @else
                                <span style="color: red;">No</span>
                            @endif
                        </td>
                        <td>
                            @if($entreprise->statut_demande === 'en_attente')
                                <!-- Accept Button with Tooltip -->
                                <form action="{{ route('entreprises.accepter', $entreprise->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Accept Request">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>

                                <!-- Reject Button with Tooltip -->
                                <form action="{{ route('entreprises.refuser', $entreprise->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm ms-1"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Reject Request">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </form>
                            @endif

                            @if($entreprise->est_actif)
                                <!-- Deactivate Button with Tooltip -->
                                <form action="{{ route('entreprises.desactiver', $entreprise->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-warning btn-sm ms-1"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Deactivate Company">
                                        <i class="fa-solid fa-power-off"></i> Off
                                    </button>
                                </form>
                            @else
                                <!-- Activate Button with Tooltip -->
                                <form action="{{ route('entreprises.activer', $entreprise->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-primary btn-sm ms-1"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Activate Company">
                                        <i class="fa-solid fa-power-off"></i> On
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addEntrepriseModal" tabindex="-1" aria-labelledby="addEntrepriseLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a Contracting Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEntrepriseForm" method="POST" action="{{ route('entreprises.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="nom_entreprise" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="ville" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="num_contact" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
<!-- Scripts Bootstrap & JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // supprimer une entreprise
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            let entrepriseId = this.getAttribute('data-id');
            if (confirm("Are you sure you want to delete this company?")) {
                fetch(`/entreprises/${entrepriseId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        location.reload();
                    }
                });
            }
        });
    });

    // Pré-remplir et afficher le modal d'édition
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            let entrepriseId = this.getAttribute('data-id');
            window.location.href = `/entreprises/${entrepriseId}/edit`;
        });
    });
});
</script>
</body>
</html>
