<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Demandes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f7f8fe 0%, #f7f8fe 100%);
            min-height: 300vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            padding: 2rem;
            margin-left: 0px;
            min-height: 100vh;
        }

        .header-section {
            text-align: center;
            margin-bottom: r1em;
            padding: 1rem 0;
        }

        .main-title {
            color: rgb(97, 146, 205);
            font-size: 3rem;
            font-weight: 700;

            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            letter-spacing: -1px;
        }

        .subtitle {
            color: rgba(125, 123, 123, 0.9);
            font-size: 1.2rem;
            font-weight: 300;
        }

        .kpi-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
        }

        .kpi-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .kpi-icon {
            font-size: 2.5rem;
            color: #26d3e2;
            text-shadow: 0 2px 10px rgba(132, 224, 212, 0.5);
        }

        .kpi-text {
            color: rgb(176, 173, 173);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .kpi-value {
            color: #52b1f0;
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(255,215,0,0.3);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        }

        .chart-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .chart-icon {
            font-size: 1.5rem;
            color: #667eea;
        }

        .chart-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .chart-canvas {
            position: relative;
            height: 300px;
        }

        .details-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .details-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .details-icon {
            font-size: 1.5rem;
            color: #667eea;
        }

        .details-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .modern-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border: none;
        }

        .modern-table thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .modern-table thead th {
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .modern-table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            vertical-align: middle;
        }

        .modern-table tbody tr:hover {
            background: rgba(102,126,234,0.1);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        .total-row {
            background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1)) !important;
            font-weight: 700;
            border-top: 2px solid #667eea;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            color: rgb(25, 28, 62);
            font-size: 1.2rem;
        }

        .spinner {
            border: 3px solid rgba(183, 219, 246, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-right: 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                margin-left: 0;
                padding: 1rem;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .main-title {
                font-size: 2rem;
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarExpert')

      <div class="container py-5" style="margin-top: 50px">
        <div class="card shadow p-4">
        <!-- Header Section -->
        <div class="header-section fade-in">
            <h1 class="main-title">
                <i class="fas fa-chart-line"></i>
                Tableau de Bord
            </h1>
            <p class="subtitle">Analyse complète des demandes et statistiques en temps réel</p>
        </div>

        <!-- KPI Section -->
        <div class="kpi-card fade-in">
            <div class="kpi-content">
                <i class="fas fa-clock kpi-icon"></i>
                <div>
                    <div class="kpi-text">Délai moyen de traitement</div>
                    <div class="kpi-value"><span id="avgDelay">...</span> heures</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="chart-card fade-in">
                <div class="chart-header">
                    <i class="fas fa-chart-pie chart-icon"></i>
                    <h3 class="chart-title">Répartition par Statut</h3>
                </div>
                <div class="chart-canvas">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="chart-card fade-in">
                <div class="chart-header">
                    <i class="fas fa-chart-line chart-icon"></i>
                    <h3 class="chart-title">Évolution Mensuelle</h3>
                </div>
                <div class="chart-canvas">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Details Table -->
        <div class="details-card fade-in">
            <div class="details-header">
                <i class="fas fa-table details-icon"></i>
                <h3 class="details-title">Détails des Statistiques</h3>
            </div>
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-tag me-2" style="color: cadetblue"></i><b style="color: cadetblue">Statut</b></th>
                            <th><i class="fas fa-hashtag me-2" style="color: cadetblue"></i><b style="color: cadetblue">Nombre</b></th>
                            <th><i class="fas fa-percentage me-2" style="color: cadetblue"></i><b style="color: cadetblue">Pourcentage</b></th>
                        </tr>
                    </thead>
                    <tbody id="statsTableBody">
                        <tr>
                            <td colspan="3" class="loading-spinner">
                                <div class="spinner"></div>
                                Chargement des données...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
      </div>
    <!-- Script JS (conservé identique) -->
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

                    // Chart: Pie avec style moderne
                    const ctxPie = document.getElementById('statusChart').getContext('2d');
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: labels.map(label => label.replace(/_/g, ' ')),
                            datasets: [{
                                data: values,
                                backgroundColor: [
                                    'rgba(102, 126, 234, 0.8)',
                                    'rgba(118, 75, 162, 0.8)',
                                    'rgba(255, 99, 132, 0.8)',
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(255, 206, 86, 0.8)',
                                    'rgba(75, 192, 192, 0.8)'
                                ],
                                borderColor: [
                                    'rgba(102, 126, 234, 1)',
                                    'rgba(118, 75, 162, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)'
                                ],
                                borderWidth: 2,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: { size: 12 }
                                    }
                                },
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

                    // Tableau de stats avec style moderne
                    const tableBody = document.getElementById('statsTableBody');
                    tableBody.innerHTML = ''; // Clear loading

                    const statusColors = {
                        'Nouvelle_demande': 'background: linear-gradient(135deg, #ffeaa7, #fdcb6e);',
                        'Une_offre_a_été_faite': 'background: linear-gradient(135deg, #74b9ff, #0984e3);',
                        'Assignée': 'background: linear-gradient(135deg, #00b894, #00a085);',
                        'offre_acceptee': 'background: linear-gradient(135deg, #fd79a8, #e84393);'
                    };

                    labels.forEach(label => {
                        const count = statusData[label];
                        const percent = Math.round((count / total) * 100);
                        const row = document.createElement('tr');
                        const colorStyle = statusColors[label] || 'background: linear-gradient(135deg, #ddd, #bbb);';
                        row.innerHTML = `
                            <td>
                                <span class="status-badge" style="${colorStyle} color: white;">
                                    ${label.replace(/_/g, ' ')}
                                </span>
                            </td>
                            <td><strong>${count}</strong></td>
                            <td><strong>${percent}%</strong></td>
                        `;
                        tableBody.appendChild(row);
                    });

                    const totalRow = document.createElement('tr');
                    totalRow.classList.add('total-row');
                    totalRow.innerHTML = `
                        <td><strong><i class="fas fa-calculator me-2"></i>Total</strong></td>
                        <td><strong>${total}</strong></td>
                        <td><strong>100%</strong></td>
                    `;
                    tableBody.appendChild(totalRow);

                    // Chart: Line avec style moderne
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
                                borderColor: 'rgba(102, 126, 234, 1)',
                                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    stepSize: 1,
                                    grid: {
                                        color: 'rgba(0,0,0,0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0,0,0,0.1)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        usePointStyle: true
                                    }
                                }
                            }
                        }
                    });

                })
                .catch(error => {
                    console.error('Erreur chargement stats :', error);
                    document.getElementById('statsTableBody').innerHTML =
                        '<tr><td colspan="3" class="text-center text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Erreur lors du chargement des données</td></tr>';
                });
        });
    </script>
</body>
</html>
