<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - ICAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1e88e5;
            --secondary: #42a5f5;
            --background: #f4f6f9;
            --card-bg: #ffffff;
            --text-dark: #263238;
            --text-light: #90a4ae;
        }

        body {
            background-color: var(--background);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            padding: 40px 30px;
            margin-top: 60px;
            margin-left: 100px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 40px;
            border-bottom: 3px solid var(--primary);
            display: inline-block;
            padding-bottom: 8px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-title {
            font-size: 1rem;
            text-transform: uppercase;
            color: var(--text-light);
            letter-spacing: 1px;
        }

        .chart-container {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        @media (max-width: 992px) {
            .main-container {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    @include('Sidebar.sidebar')

    <div class="main-container" style="margin-right: 20%;">
        <h1 class="page-title">
            <i class="fas fa-chart-line me-2"></i>Tableau de Bord Statistique
        </h1>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-screwdriver-wrench"></i></div>
                    <div class="stat-value">{{ $techniciensCount }}</div>
                    <div class="stat-title">Techniciens</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                    <div class="stat-value">{{ $expertsCount }}</div>
                    <div class="stat-title">Experts</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user"></i></div>
                    <div class="stat-value">{{ $employesCount }}</div>
                    <div class="stat-title">Employés</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-building"></i></div>
                    <div class="stat-value">{{ $entreprisesCount }}</div>
                    <div class="stat-title">Entreprises</div>
                </div>
            </div>
        </div>

        <div class="row mt-5 g-4">
            <div class="col-lg-5">
                <div class="chart-container">
                    <h5 class="chart-title"><i class="fas fa-chart-pie me-2"></i>Répartition des Utilisateurs</h5>
                    <canvas id="userPieChart"></canvas>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="chart-container">
                    <h5 class="chart-title"><i class="fas fa-chart-bar me-2"></i>Statistiques Globales</h5>
                    <canvas id="statsBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const colors = {
            technicien: '#1e88e5',
            expert: '#42a5f5',
            employe: '#64b5f6',
            entreprise: '#90caf9'
        };

        const userData = {
            labels: ['Techniciens', 'Experts', 'Employés'],
            datasets: [{
                data: [{{ $techniciensCount }}, {{ $expertsCount }}, {{ $employesCount }}],
                backgroundColor: [colors.technicien, colors.expert, colors.employe],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        };

        const statsData = {
            labels: ['Techniciens', 'Experts', 'Employés', 'Entreprises'],
            datasets: [{
                label: 'Nombre',
                data: [{{ $techniciensCount }}, {{ $expertsCount }}, {{ $employesCount }}, {{ $entreprisesCount }}],
                backgroundColor: [colors.technicien, colors.expert, colors.employe, colors.entreprise],
                borderRadius: 8,
                borderSkipped: false
            }]
        };

        document.addEventListener('DOMContentLoaded', () => {
            const pieCtx = document.getElementById('userPieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: userData,
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = Math.round((value / total) * 100);
                                    return `${context.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });

            const barCtx = document.getElementById('statsBarChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: statsData,
                options: {
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
