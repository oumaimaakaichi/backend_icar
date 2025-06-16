<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Demandes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('Sidebar.sidebarExpert')
    <div class="container mt-5">
        <h1 class="mb-4 text-center"  style="margin-top: 40px">📊 Statistiques des Demandes</h1>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info fw-bold text-center fs-5">
                    ⏱️ Délai moyen de traitement : <span id="avgDelay">...</span> heures
                </div>
            </div>
        </div>

        <div class="row" style="margin-left: 150px">

            <div class="col-md-4">
                <div class="card mb-4 shadow">
                    <div class="card-header fw-bold">
                        Répartition par statut
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="250"></canvas>
                    </div>
                </div>
            </div>


            <div class="col-md-4" >
                <div class="card mb-4 shadow">
                    <div class="card-header fw-bold" style="margin-bottom: 50px">
                        Évolution mensuelle des demandes
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau de détails -->
        <div class="card shadow" style="margin-bottom: 50px">
            <div class="card-header fw-bold">
                Détails des statistiques
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Statut</th>
                            <th>Nombre</th>
                            <th>Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody id="statsTableBody">
                        <!-- Inséré par JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
           fetch('/api/demandes/statistics')

                .then(response => response.json())
                .then(data => {
                    // KPI
                    document.getElementById('avgDelay').textContent = data.delai_moyen_heures ?? 'Non calculé';

                    // Données
                    const statusData = data.par_statut;
                    const labels = Object.keys(statusData);
                    const values = labels.map(label => statusData[label]);
                    const total = data.total;

                    // Chart: Pie
                    const ctxPie = document.getElementById('statusChart').getContext('2d');
                    new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: labels.map(label => label.replace(/_/g, ' ')),
                            datasets: [{
                                data: values,
                                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#F77825']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const val = context.raw || 0;
                                            const percent = Math.round((val / total) * 100);
                                            return `${context.label}: ${val} (${percent}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Tableau de stats
                    const tableBody = document.getElementById('statsTableBody');
                    labels.forEach(label => {
                        const count = statusData[label];
                        const percent = Math.round((count / total) * 100);
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${label.replace(/_/g, ' ')}</td>
                            <td>${count}</td>
                            <td>${percent}%</td>
                        `;
                        tableBody.appendChild(row);
                    });

                    const totalRow = document.createElement('tr');
                    totalRow.classList.add('table-primary', 'fw-bold');
                    totalRow.innerHTML = `
                        <td>Total</td>
                        <td>${total}</td>
                        <td>100%</td>
                    `;
                    tableBody.appendChild(totalRow);

                    // Chart: Line
                    const moisLabels = data.par_mois.map(item => item.mois);
                    const moisValues = data.par_mois.map(item => item.total);
                    const ctxLine = document.getElementById('monthlyChart').getContext('2d');
                    new Chart(ctxLine, {
                        type: 'line',
                        data: {
                            labels: moisLabels,
                            datasets: [{
                                label: 'Demandes par mois',
                                data: moisValues,
                                borderColor: '#007bff',
                                backgroundColor: 'rgba(0,123,255,0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }
                        }
                    });

                })
                .catch(error => {
                    console.error('Erreur chargement stats :', error);
                });
        });
    </script>
</body>
</html>
