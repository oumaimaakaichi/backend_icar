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
            --primary: #6366f1;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #3b82f6;
            --light: #f8fafc;
            --dark: #0f172a;
            --border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: white;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

            line-height: 1.6;
            overflow-x: hidden;
        }

        .main-container {
            min-height: 200vh;

margin-right: 100px;
            margin-top: 80px;
        }

        /* Header moderne */
        .dashboard-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
            border-radius: 24px;
margin-top: 50px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--secondary) 50%, var(--success) 100%);
        }

        .header-content {
            position: relative;
            z-index: 2;
            margin: 20px
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--success) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
            margin-left: 60px
        }

        .dashboard-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            font-weight: 500;
            margin: 0;
             margin-left: 60px
        }

        .live-indicator {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .live-text {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--success);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }

        /* Cartes statistiques modernes */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1rem;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card:nth-child(1) { --accent: var(--primary); }
        .stat-card:nth-child(2) { --accent: var(--secondary); }
        .stat-card:nth-child(3) { --accent: var(--success); }
        .stat-card:nth-child(4) { --accent: var(--warning); }

        .stat-card:nth-child(1)::before { background: var(--primary); }
        .stat-card:nth-child(2)::before { background: var(--secondary); }
        .stat-card:nth-child(3)::before { background: var(--success); }
        .stat-card:nth-child(4)::before { background: var(--warning); }

        .stat-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .stat-card:nth-child(1) .stat-icon-wrapper { background: linear-gradient(135deg, var(--primary), #8b5cf6); }
        .stat-card:nth-child(2) .stat-icon-wrapper { background: linear-gradient(135deg, var(--secondary), #0ea5e9); }
        .stat-card:nth-child(3) .stat-icon-wrapper { background: linear-gradient(135deg, var(--success), #059669); }
        .stat-card:nth-child(4) .stat-icon-wrapper { background: linear-gradient(135deg, var(--warning), #d97706); }

        .stat-icon {
            font-size: 2rem;
            color: white;
            z-index: 2;
            position: relative;
        }

        .stat-icon-wrapper::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%) rotate(45deg);
            transition: transform 0.8s;
        }

        .stat-card:hover .stat-icon-wrapper::after {
            transform: translateX(100%) rotate(45deg);
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .stat-label {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-change {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Graphiques modernes */
        .charts-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 1rem;
        }

        .chart-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .chart-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--success));
        }

        .chart-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .chart-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: r1em;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .chart-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-size: 1.25rem;
        }

        .chart-canvas {
            position: relative;
            height: 300px;
        }

        /* Animations */
        .animate-in {
            opacity: 0;
            transform: translateY(30px);
            animation: slideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .chart-card:nth-child(1) { animation-delay: 0.5s; }
        .chart-card:nth-child(2) { animation-delay: 0.6s; }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 1200px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .main-container {
                margin-left: 0;
                padding: 1rem;
                margin-top: 20px;
            }

            .dashboard-title {
                font-size: 2.5rem;
            }

            .dashboard-header {
                padding: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .stat-card {
                padding: 2rem;
            }

            .stat-icon-wrapper {
                width: 60px;
                height: 60px;
            }

            .stat-icon {
                font-size: 1.5rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .chart-card {
                padding: 1.5rem;
            }

            .live-indicator {
                position: static;
                margin-top: 1rem;
                align-self: flex-start;
            }
        }

        /* Effet de chargement */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 2s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    </style>
</head>
<body>
     @include('Sidebar.sidebar')
    <div class="container py-5" style="margin-right: 50px">
        <!-- En-tête du tableau de bord -->
        <div class="dashboard-header animate-in">
            <div class="header-content">
                <h2 class="dashboard-title">
                    <i class="fas fa-chart-line me-3"></i>
                   Dashboard ICAR
                </h2>
                <p class="dashboard-subtitle">
    Comprehensive analysis and real-time monitoring of your ecosystem
</p>

            </div>

        </div>

        <!-- Cartes statistiques -->
        <div class="stats-grid">
            <div class="stat-card animate-in">
                <div class="stat-change">+12%</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-screwdriver-wrench stat-icon"></i>
                </div>
                <div class="stat-number">{{ $techniciensCount ?? 25 }}</div>
                <div class="stat-label">Technicians</div>
            </div>

            <div class="stat-card animate-in">
                <div class="stat-change">+8%</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-user-tie stat-icon"></i>
                </div>
                <div class="stat-number">{{ $expertsCount ?? 15 }}</div>
                <div class="stat-label">Experts</div>
            </div>

            <div class="stat-card animate-in">
                <div class="stat-change">+23%</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-users stat-icon"></i>
                </div>
                <div class="stat-number">{{ $employesCount ?? 35 }}</div>
                <div class="stat-label">Customers</div>
            </div>


        </div>

        <!-- Graphiques -->
        <div class="charts-container">
            <div class="chart-card animate-in">
                <div class="chart-header">
                    <div class="chart-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                 <h3 class="chart-title">User Distribution</h3>

                </div>
                <div class="chart-canvas">
                    <canvas id="userPieChart"></canvas>
                </div>
            </div>

            <div class="chart-card animate-in">
                <div class="chart-header">
                    <div class="chart-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                 <h3 class="chart-title">Overview</h3>

                </div>
                <div class="chart-canvas">
                    <canvas id="statsBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration des couleurs modernes
        const modernColors = {
            primary: '#6366f1',
            secondary: '#06b6d4',
            success: '#10b981',
            warning: '#f59e0b',
            gradients: {
                primary: 'rgba(99, 102, 241, 0.8)',
                secondary: 'rgba(6, 182, 212, 0.8)',
                success: 'rgba(16, 185, 129, 0.8)',
                warning: 'rgba(245, 158, 11, 0.8)'
            }
        };

        // Données pour le graphique circulaire
        const pieData = {
            labels: ['Techniciens', 'Experts', 'Clients'],
            datasets: [{
                data: [25, 15, 35],
                backgroundColor: [
                    modernColors.gradients.primary,
                    modernColors.gradients.secondary,
                    modernColors.gradients.success
                ],
                borderColor: [
                    modernColors.primary,
                    modernColors.secondary,
                    modernColors.success
                ],
                borderWidth: 3,
                hoverBorderWidth: 4
            }]
        };

        // Données pour le graphique en barres
        const barData = {
            labels: ['Techniciens', 'Experts', 'Clients', 'Entreprises'],
            datasets: [{
                label: 'Effectif',
                data: [25, 15, 35, 12],
                backgroundColor: [
                    modernColors.gradients.primary,
                    modernColors.gradients.secondary,
                    modernColors.gradients.success,
                    modernColors.gradients.warning
                ],
                borderColor: [
                    modernColors.primary,
                    modernColors.secondary,
                    modernColors.success,
                    modernColors.warning
                ],
                borderWidth: 2,
                borderRadius: 12,
                borderSkipped: false
            }]
        };

        // Configuration commune des graphiques
        const commonChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 16,
                    padding: 12,
                    titleFont: { size: 14, weight: '600' },
                    bodyFont: { size: 13 }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutCubic'
            }
        };

        // Initialisation des graphiques
        document.addEventListener('DOMContentLoaded', () => {
            // Graphique circulaire
            const pieCtx = document.getElementById('userPieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: pieData,
                options: {
                    ...commonChartOptions,
                    cutout: '70%',
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 13, weight: '600' },
                                color: '#64748b'
                            }
                        },
                        tooltip: {
                            ...commonChartOptions.plugins.tooltip,
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

            // Graphique en barres
            const barCtx = document.getElementById('statsBarChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    ...commonChartOptions,
                    plugins: {
                        ...commonChartOptions.plugins,
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { weight: '600', size: 12 },
                                color: '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.8)',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 5,
                                font: { weight: '600', size: 12 },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });

            // Animation des nombres
            const animateNumbers = () => {
                const numbers = document.querySelectorAll('.stat-number');
                numbers.forEach(element => {
                    const target = parseInt(element.textContent);
                    let current = 0;
                    const increment = target / 60;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            element.textContent = target;
                            clearInterval(timer);
                        } else {
                            element.textContent = Math.floor(current);
                        }
                    }, 30);
                });
            };

            // Démarrer l'animation après un délai
            setTimeout(animateNumbers, 1000);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
