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
            --primary: #596c92;
            --primary-dark: #3730a3;
            --secondary: #596c92;
            --accent: #06b6d4;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --light: #f1f5f9;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: white;
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .main-container {

            margin-top: 80px;
            margin-right: 100px;
            padding: 2rem;
            position: relative;
            width: 1400px;
            z-index: 1;
        }

        /* Header avec effet glassmorphism */
        .dashboard-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 30px;
            padding: 3rem;
            margin-bottom: 3rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #476378, #3f5a6e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            text-shadow: none;
            letter-spacing: -0.02em;
        }

        .dashboard-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .live-badge {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: rgba(34, 197, 94, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
        }

        .live-dot {
            width: 10px;
            height: 10px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
            box-shadow: 0 0 15px #4ade80;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }

        .section-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
        }

        /* Cartes statistiques avec effet 3D */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            padding: 2rem;
            position: relative;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .stat-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card:nth-child(1) .stat-icon-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #667eea 100%);
        }
        .stat-card:nth-child(2) .stat-icon-wrapper {
            background: linear-gradient(135deg, #7aa3b7 0%, #7aa3b7 100%);
        }
        .stat-card:nth-child(3) .stat-icon-wrapper {
            background: linear-gradient(135deg, #4facfe 0%, #4facfe 100%);
        }
        .stat-card:nth-child(4) .stat-icon-wrapper {
            background: linear-gradient(135deg, #43e97b 0%, #43e97b 100%);
        }
        .stat-card:nth-child(5) .stat-icon-wrapper {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .stat-card:nth-child(6) .stat-icon-wrapper {
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        }
        .stat-card:nth-child(7) .stat-icon-wrapper {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: white;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .stat-sublabel {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed var(--border);
        }

        .stat-change {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(16, 185, 129, 0.3));
            backdrop-filter: blur(10px);
            color: var(--success);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            border: 1px solid rgba(34, 197, 94, 0.3);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
        }

        /* Graphiques avec design moderne */
        .charts-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .chart-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent), var(--success));
        }

        .chart-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
        }

        .chart-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 3px solid var(--border);
        }

        .chart-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }

        .chart-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text);
        }

        .chart-canvas {
            position: relative;
            height: 350px;
        }

        /* Animations */
        .animate-in {
            opacity: 0;
            transform: translateY(50px);
            animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }
        .stat-card:nth-child(5) { animation-delay: 0.5s; }
        .stat-card:nth-child(6) { animation-delay: 0.6s; }
        .stat-card:nth-child(7) { animation-delay: 0.7s; }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
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

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebar')

    <div class="main-container">
        <!-- Header -->
        <div class="dashboard-header animate-in">
            <div class="header-content">
                <h1 class="dashboard-title">
                    <i class="fas fa-chart-line me-3"></i>
                    ICAR Analytics
                </h1>
                <p class="dashboard-subtitle">
Interactive dashboard and real-time analysis of your ecosystem
                </p>
            </div>

        </div>
<div class="section-header animate-in">
            <div class="section-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h2 class="section-title">Maintenance Requests</h2>
        </div>

        <div class="stats-grid">
            <div class="stat-card animate-in">
                <div class="stat-change">{{ $totalDemandes > 0 ? '+' . round(($demandesConnuesCount / $totalDemandes) * 100) . '%' : '0%' }}</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-tools stat-icon"></i>
                </div>
                <div class="stat-number">{{ $demandesConnuesCount ?? 0 }}</div>
                <div class="stat-label">Known Requests</div>
                <div class="stat-sublabel">
                    <i class="fas fa-building text-info"></i> {{ $demandesConnuesEntreprisesCount ?? 0 }} At home |
                    <i class="fas fa-wrench text-success"></i> {{ $demandesConnuesAteliersCount ?? 0 }} Workshops
                </div>
            </div>

            <div class="stat-card animate-in">
                <div class="stat-change">{{ $totalDemandes > 0 ? '+' . round(($demandesInconnuesCount / $totalDemandes) * 100) . '%' : '0%' }}</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-question-circle stat-icon"></i>
                </div>
                <div class="stat-number">{{ $demandesInconnuesCount ?? 0 }}</div>
                <div class="stat-label">UnKnown Requests</div>
                <div class="stat-sublabel">
                    <i class="fas fa-building text-info"></i> {{ $demandesInconnuesEntreprisesCount ?? 0 }} At home |
                    <i class="fas fa-wrench text-success"></i> {{ $demandesInconnuesAteliersCount ?? 0 }} Workshops
                </div>
            </div>

            <div class="stat-card animate-in">
                <div class="stat-change">Total</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-list-check stat-icon"></i>
                </div>
                <div class="stat-number">{{ $totalDemandes ?? 0 }}</div>
                <div class="stat-label">Total Requests</div>
                <div class="stat-sublabel">
                 All Categories Combined
                </div>
            </div>
        </div>
        <!-- Section Utilisateurs -->
        <div class="section-header animate-in">
            <div class="section-icon">
                <i class="fas fa-users"></i>
            </div>
            <h2 class="section-title">System Users</h2>
        </div>

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
                <div class="stat-label">Clients</div>
            </div>

            <div class="stat-card animate-in">
                <div class="stat-change">+15%</div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-building stat-icon"></i>
                </div>
                <div class="stat-number">{{ $entreprisesCount ?? 12 }}</div>
                <div class="stat-label">Companies</div>
            </div>
        </div>

        <!-- Section Demandes -->


        <!-- Graphiques -->
        <div class="charts-container">
            <div class="chart-card animate-in">
                <div class="chart-header">
                    <div class="chart-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="chart-title">Distribution</h3>
                </div>
                <div class="chart-canvas">
                    <canvas id="demandesPieChart"></canvas>
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
                    <canvas id="overviewBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const modernColors = {
            primary: '#667eea',
            secondary: '#ec4899',
            accent: '#06b6d4',
            success: '#22c55e',
            warning: '#f59e0b',
            danger: '#ef4444'
        };

        const demandesData = {
            connues: {{ $demandesConnuesCount ?? 0 }},
            inconnues: {{ $demandesInconnuesCount ?? 0 }}
        };

        const usersData = {
            techniciens: {{ $techniciensCount ?? 0 }},
            experts: {{ $expertsCount ?? 0 }},
            clients: {{ $employesCount ?? 0 }},
            entreprises: {{ $entreprisesCount ?? 0 }}
        };

        const pieData = {
            labels: ['Know Requests', 'Unknow Requests'],
            datasets: [{
                data: [demandesData.connues, demandesData.inconnues],
                backgroundColor: ['rgba(102, 126, 234, 0.8)', 'rgba(236, 72, 153, 0.8)'],
                borderColor: ['#667eea', '#ec4899'],
                borderWidth: 3,
                hoverOffset: 20
            }]
        };

        const barData = {
            labels: ['Technicians', 'Experts', 'Clients', 'Companies', 'Know request', 'UnKnow request'],
            datasets: [{
                label: 'Effectif',
                data: [
                    usersData.techniciens,
                    usersData.experts,
                    usersData.clients,
                    usersData.entreprises,
                    demandesData.connues,
                    demandesData.inconnues
                ],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderRadius: 15,
                borderSkipped: false
            }]
        };

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    padding: 15,
                    cornerRadius: 15,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const pieCtx = document.getElementById('demandesPieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: pieData,
                options: {
                    ...chartOptions,
                    cutout: '65%',
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 13, weight: 'bold' }
                            }
                        }
                    }
                }
            });

            const barCtx = document.getElementById('overviewBarChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: 'bold' } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: { font: { weight: 'bold' } }
                        }
                    }
                }
            });

            const animateNumbers = () => {
                document.querySelectorAll('.stat-number').forEach(el => {
                    const target = parseInt(el.textContent.replace(/[^\d]/g, ''));
                    if (target > 0) {
                        let current = 0;
                        const increment = target / 50;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                el.textContent = target;
                                clearInterval(timer);
                            } else {
                                el.textContent = Math.floor(current);
                            }
                        }, 30);
                    }
                });
            };

            setTimeout(animateNumbers, 1000);

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-in').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
