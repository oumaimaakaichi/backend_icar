<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des Ateliers</title>
    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
,   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 300px;
            width: 100%;
            margin-bottom: 20px;
        }
        .table-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }

        .btn-sm {
            padding: 5px 10px;
        }

        .btn-info {
            background-color: cadetblue;
            border: none;
        }

        .btn-outline-primary {
            border: 1px solid #007bff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .header-title {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
        }

        .table thead tr {
            background-color: #007bff !important;
            color: white !important;
        }

        .table th, .table td {
            text-align: center;
            padding: 10px;
        }
        .search-box {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin-bottom: 10px
        }

        .search-box input {
            width: 100%;
            padding: 12px 10px 12px 40px;
            font-size: 16px;
            border: 2px solid #999b9e;
            border-radius: 10px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .search-box::before {
            content: "🔍";
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #007bff;
            pointer-events: none;
        }

        .search-box input::placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

<!-- Sidebar inclusion (assurez-vous que le fichier sidebar.blade.php existe) -->
@include('Sidebar.sidebar')
<div class="container mt-5">
    <!-- Titre centré -->
    <div class="header-title">
        <h1  style="margin-top: 70px">Workshop List</h1>
    </div>

    <!-- Tableau des ateliers -->
    <div class="search-box">
        <input type="text" id="search" placeholder="Search ...">
    </div>

    <div class="table-responsive table-container">
        <table class="table table-bordered table-hover" id="workshopTable">
            <thead>
                <tr>
                    <th>Trade Name</th>
                    <th>Email</th>
                    <th>Website Link</th>
                    <th>City</th>
                    <th>Bank Name</th>
                    <th>Director Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="AtelierTable">
                @foreach ($ateliers as $atelier)
                    <tr>
                        <td>{{ $atelier->nom_commercial }}</td>
                        <td>{{ $atelier->email }}</td>
                        <td>
                            <a href="{{ $atelier->site_web }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-map-marked-alt"></i> View Site
                            </a>
                        </td>
                        <td>{{ $atelier->ville }}</td>
                        <td>{{ $atelier->nom_banque }}</td>
                        <td>{{ $atelier->nom_directeur }}</td>
                        <td class="{{ $atelier->is_active == 0 ? 'text-primary' : 'text-success' }}">
                            {{ $atelier->is_active == 0 ? 'Désactivé ' : 'Activé' }}
                        </td>
                        <td>
                            @if ($atelier->is_active == 0)
                                <button class="btn btn-success btn-sm activate-btn" data-id="{{ $atelier->id }}" title="activate workshop">
                                    <i class="fas fa-toggle-off"></i>
                                </button>
                            @else
                                <button class="btn btn-secondary btn-sm deactivate-btn" data-id="{{ $atelier->id }}" title="desactivate workshop">
                                    <i class="fas fa-toggle-on"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex " style="margin-left: 50%">
            <button id="prevBtn" class="btn btn-secondary" disabled>  <i class="fas fa-arrow-left" ></i></button> &nbsp;
            <button id="nextBtn" class="btn btn-secondary">  <i class="fas fa-arrow-right"></i></button>
        </div>
    </div>

</div>

<!-- Bootstrap JS et dépendances -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Leaflet JS pour la carte -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Activation d'un atelier
        document.querySelectorAll('.activate-btn').forEach(button => {
            button.addEventListener('click', function () {
                let atelierId = this.getAttribute('data-id');

                fetch(`/ateliers/${atelierId}/activate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || "Atelier activé !");
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    alert("Une erreur s'est produite lors de l'activation.");
                });
            });
        });

        // Désactiver d'un atelier
        document.querySelectorAll('.deactivate-btn').forEach(button => {
            button.addEventListener('click', function () {
                let atelierId = this.getAttribute('data-id');

                fetch(`/ateliers/${atelierId}/desactivate`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || "Atelier désactivé !");
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    alert("Une erreur s'est produite lors de la désactivation.");
                });
            });
        });
    });

    //recherche par nom et email une atelier
    document.getElementById("search").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#workshopTable tbody tr");

        rows.forEach(row => {
            let name = row.cells[0].textContent.toLowerCase();
            let email = row.cells[1].textContent.toLowerCase();

            if (name.includes(filter) || email.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
<script>
    // Afficher 5 atelier par defaut et ajouter les bouttons next et previous
    let currentPage = 0;
    const rowsPerPage = 5;
    const rows = document.querySelectorAll("#AtelierTable tr");

    function showPage(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= page * rowsPerPage && index < (page + 1) * rowsPerPage) ? "" : "none";
        });
        document.getElementById("prevBtn").disabled = page === 0;
        document.getElementById("nextBtn").disabled = (page + 1) * rowsPerPage >= rows.length;
    }

    document.getElementById("prevBtn").addEventListener("click", () => {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    });

    document.getElementById("nextBtn").addEventListener("click", () => {
        if ((currentPage + 1) * rowsPerPage < rows.length) {
            currentPage++;
            showPage(currentPage);
        }
    });

    showPage(currentPage);
</script>
<script>
    // Activation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>
