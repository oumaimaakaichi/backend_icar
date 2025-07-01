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
            --primary: #667eea;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary: #42a5f5;
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --tertiary-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --quaternary-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --background: linear-gradient(135deg, #f5f7fa 0%, #d6d7d9 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #2d3748;
            --text-light: #718096;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        body {
           background-color: whitesmoke;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            padding: 40px 30px;
            margin-top: 60px;
            margin-left: 100px;
            position: relative;
        }

        .page-title {
            font-size: 2.8rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            font-size: 2.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            font-weight: 500;
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-hover);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card:nth-child(1)::before { background: var(--primary-gradient); }
        .stat-card:nth-child(2)::before { background: var(--secondary-gradient); }
        .stat-card:nth-child(3)::before { background: var(--tertiary-gradient); }
        .stat-card:nth-child(4)::before { background: var(--quaternary-gradient); }

        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .col-lg-3:nth-child(1) .stat-icon { background: var(--primary-gradient); }
        .col-lg-3:nth-child(2) .stat-icon { background: var(--secondary-gradient); }
        .col-lg-3:nth-child(3) .stat-icon { background: var(--tertiary-gradient); }
        .col-lg-3:nth-child(4) .stat-icon { background: var(--quaternary-gradient); }

        .stat-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(45deg) translate(-100%, -100%);
            transition: transform 0.6s ease;
        }

        .stat-card:hover .stat-icon::before {
            transform: rotate(45deg) translate(0, 0);
        }

        .stat-value {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1;
            position: relative;
        }

        .stat-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-container {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            height: 100%;
        }

        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            padding-bottom: 1rem;
        }

        .chart-title i {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.3rem;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 10%;
            animation-delay: 3s;
        }

        .floating-element:nth-child(3) {
            width: 120px;
            height: 120px;
            bottom: 15%;
            left: 15%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-30px) rotate(180deg);
                opacity: 0.1;
            }
        }

        .stats-row {
            margin-bottom: 3rem;
        }

        .charts-row {
            margin-top: 3rem;
        }

        @media (max-width: 992px) {
            .main-container {
                margin-left: 0;
                padding: 20px;
                margin-top: 20px;
            }

            .page-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .stat-card {
                padding: 2rem;
                margin-bottom: 1rem;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 2.5rem;
            }

            .chart-container {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }
        }

        /* Animation d'entrée pour les cartes */
        .stat-card,
        .chart-container {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s ease forwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .chart-container:first-child { animation-delay: 0.5s; }
        .chart-container:last-child { animation-delay: 0.6s; }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Amélioration des graphiques */
        #userPieChart,
        #statsBarChart {
            max-height: 350px;
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    @include('Sidebar.sidebar')

    <div class="main-container" style="margin-right: 20%;">
        <h1 class="page-title">
            <i class="fas fa-chart-line"></i>Tableau de Bord Statistique
        </h1>
        <p class="page-subtitle">Analyse en temps réel de votre écosystème ICAR</p>

        <div class="row g-4 stats-row">
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

        <div class="row charts-row g-4">
            <div class="col-lg-5">
                <div class="chart-container">
                    <h5 class="chart-title"><i class="fas fa-chart-pie"></i>Répartition des Utilisateurs</h5>
                    <canvas id="userPieChart"></canvas>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="chart-container">
                    <h5 class="chart-title"><i class="fas fa-chart-bar"></i>Statistiques Globales</h5>
                    <canvas id="statsBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const colors = {
            technicien: {
                bg: 'rgba(102, 126, 234, 0.8)',
                border: '#667eea'
            },
            expert: {
                bg: 'rgba(240, 147, 251, 0.8)',
                border: '#f093fb'
            },
            employe: {
                bg: 'rgba(79, 172, 254, 0.8)',
                border: '#4facfe'
            },
            entreprise: {
                bg: 'rgba(67, 233, 123, 0.8)',
                border: '#43e97b'
            }
        };

        const userData = {
            labels: ['Techniciens', 'Experts', 'Employés'],
            datasets: [{
                data: [{{ $techniciensCount }}, {{ $expertsCount }}, {{ $employesCount }}],
                backgroundColor: [
                    colors.technicien.bg,
                    colors.expert.bg,
                    colors.employe.bg
                ],
                borderColor: [
                    colors.technicien.border,
                    colors.expert.border,
                    colors.employe.border
                ],
                borderWidth: 3,
                hoverBorderWidth: 4
            }]
        };

        const statsData = {
            labels: ['Techniciens', 'Experts', 'Employés', 'Entreprises'],
            datasets: [{
                label: 'Nombre',
                data: [{{ $techniciensCount }}, {{ $expertsCount }}, {{ $employesCount }}, {{ $entreprisesCount }}],
                backgroundColor: [
                    colors.technicien.bg,
                    colors.expert.bg,
                    colors.employe.bg,
                    colors.entreprise.bg
                ],
                borderColor: [
                    colors.technicien.border,
                    colors.expert.border,
                    colors.employe.border,
                    colors.entreprise.border
                ],
                borderWidth: 2,
                borderRadius: 12,
                borderSkipped: false
            }]
        };

        document.addEventListener('DOMContentLoaded', () => {
            const pieCtx = document.getElementById('userPieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: userData,
                options: {
                    cutout: '65%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percent = Math.round((value / total) * 100);
                                    return `${context.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });

            const barCtx = document.getElementById('statsBarChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: statsData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1,
                            cornerRadius: 12
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    weight: '600'
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
