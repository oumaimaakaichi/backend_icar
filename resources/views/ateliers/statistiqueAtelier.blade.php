<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des Spécialisations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        .dashboard-container {
            margin-left: 0px;
            margin-top: 50px;
            margin-right: 40px;
            padding: 0rem;
            animation: slideIn 0.8s ease-out;
            width: 1400px
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h1 {
            color: #1f2937;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: none;
            background: linear-gradient(45deg, #3f4d87, #4e6a89);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 50px
        }

        .timestamp {
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            padding: 2rem;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(0, 0, 0, 0.05), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .stat-card:hover::before {
            animation: shimmer 1.5s ease-in-out;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            animation: pulse 2s infinite;
            color: white
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            text-shadow: none;
            line-height: 1;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .status-indicators {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .active-badge {
            background: rgba(16, 185, 129, 0.2);
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .inactive-badge {
            background: rgba(239, 68, 68, 0.2);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .progress-section {
            margin-top: 1.5rem;
        }

        .progress-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: #4b5563;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 1.5s ease-out;
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            animation: progressShine 2s ease-out;
        }

        @keyframes progressShine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .chart-card {
            padding: 2rem;
            min-height: 450px;
        }

        .chart-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .chart-title {
            color: #1f2937;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .chart-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            background: white;
            border-radius: 15px;
            padding: 1rem;
        }

        .activity-section {
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .activity-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .activity-title {
            color: #1f2937;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .activity-subtitle {
            color: #6b7280;
            font-size: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            background: white;
            border-radius: 15px;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
            animation: slideInRight 0.6s ease-out;
        }

        .activity-item:hover {
            background: #f3f4f6;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .activity-item.new { border-left-color: #3B82F6; }
        .activity-item.update { border-left-color: #10B981; }
        .activity-item.profile { border-left-color: #8B5CF6; }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .activity-content h4 {
            color: #1f2937;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .activity-content p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .activity-time {
            color: #9ca3af;
            font-size: 0.8rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .view-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .view-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background: linear-gradient(45deg, #764ba2, #667eea);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                margin-left: 0;
                margin-right: 0;
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .charts-section {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element" style="top: 10%; left: 10%; font-size: 2rem;">⚡</div>
        <div class="floating-element" style="top: 20%; right: 10%; font-size: 1.5rem; animation-delay: -2s;">🔧</div>
        <div class="floating-element" style="bottom: 20%; left: 15%; font-size: 1.8rem; animation-delay: -4s;">👥</div>
        <div class="floating-element" style="top: 60%; right: 20%; font-size: 2.2rem; animation-delay: -1s;">📊</div>
    </div>

    @include('Sidebar.sidebarAtelier')

    <div class="dashboard-container" style="margin-top: 100px">
        <!-- Header -->
        

        <!-- Stats Cards -->
        <div class="stats-grid">
            <!-- Techniciens Card -->
            <div class="glass-card stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Techniciens</div>
                        <div class="stat-number">{{ $stats['techniciens']['total'] }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(45deg, #3B82F6, #1E40AF);">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
                <div class="status-indicators">
                    <div class="status-badge active-badge">
                        <div style="width: 8px; height: 8px; background: #10B981; border-radius: 50%;"></div>
                        {{ $stats['techniciens']['actifs'] }} Actifs
                    </div>
                    <div class="status-badge inactive-badge">
                        <div style="width: 8px; height: 8px; background: #EF4444; border-radius: 50%;"></div>
                        {{ $stats['techniciens']['inactifs'] }} Inactifs
                    </div>
                </div>
            </div>

            <!-- Employés Card -->
            <div class="glass-card stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Clients</div>
                        <div class="stat-number">{{ $stats['employes']['total'] }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(45deg, #10B981, #059669);">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="status-indicators">
                    <div class="status-badge active-badge">
                        <div style="width: 8px; height: 8px; background: #10B981; border-radius: 50%;"></div>
                        {{ $stats['employes']['actifs'] }} Actifs
                    </div>
                    <div class="status-badge inactive-badge">
                        <div style="width: 8px; height: 8px; background: #EF4444; border-radius: 50%;"></div>
                        {{ $stats['employes']['inactifs'] }} Inactifs
                    </div>
                </div>
            </div>

            <!-- Total Personnel Card -->
            <div class="glass-card stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Personnel Total</div>
                        <div class="stat-number">{{ $stats['total_personnel'] }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(45deg, #8B5CF6, #7C3AED);">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
                <div class="progress-section">
                    @php
                        $total = $stats['total_personnel'] ?: 1;
                        $percentTech = round(($stats['techniciens']['total'] / $total) * 100);
                        $percentEmp = round(($stats['employes']['total'] / $total) * 100);
                    @endphp
                    <div class="progress-item">
                        <span>Techniciens</span>
                        <span>{{ $percentTech }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $percentTech }}%; background: linear-gradient(45deg, #3B82F6, #1E40AF);"></div>
                    </div>
                    <div class="progress-item">
                        <span>Clients</span>
                        <span>{{ $percentEmp }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $percentEmp }}%; background: linear-gradient(45deg, #10B981, #059669);"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <!-- Pie Chart -->
            <div class="glass-card chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Répartition du Personnel</h3>
                    <p class="chart-subtitle">Proportion entre Techniciens et Clients</p>
                </div>
                <div class="chart-container">
                    <canvas id="personnelChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="glass-card chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Statut Actif/Inactif</h3>
                    <p class="chart-subtitle">Comparaison entre les différents statuts</p>
                </div>
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="glass-card activity-section">
            <div class="activity-header">
                <h3 class="activity-title">Activité Récente</h3>
                <p class="activity-subtitle">Dernières modifications dans le système</p>
            </div>
            
            <div class="activity-item new">
                <div class="activity-icon" style="background: rgba(59, 130, 246, 0.2); color: #3B82F6;">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="activity-content">
                    <h4>Nouveau technicien ajouté</h4>
                    <p>Jean Dupont a été ajouté au système</p>
                    <span class="activity-time">Il y a 2 heures</span>
                </div>
            </div>

            <div class="activity-item update">
                <div class="activity-icon" style="background: rgba(16, 185, 129, 0.2); color: #10B981;">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="activity-content">
                    <h4>Changement de statut</h4>
                    <p>Marie Martin marquée comme inactive</p>
                    <span class="activity-time">Il y a 5 heures</span>
                </div>
            </div>

            <div class="activity-item profile">
                <div class="activity-icon" style="background: rgba(139, 92, 246, 0.2); color: #8B5CF6;">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="activity-content">
                    <h4>Profil mis à jour</h4>
                    <p>Pierre Bernard a modifié ses informations</p>
                    <span class="activity-time">Il y a 1 jour</span>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="#" class="view-all-btn">
                    <i class="fas fa-eye"></i>
                    Voir toute l'activité
                </a>
            </div>
        </div>
    </div>

    <script>
        // Personnel Pie Chart
        document.addEventListener('DOMContentLoaded', function() {
            const personnelCtx = document.getElementById('personnelChart').getContext('2d');
            
            const personnelChart = new Chart(personnelCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Techniciens', 'Clients'],
                    datasets: [{
                        data: [{{ $stats['techniciens']['total'] }}, {{ $stats['employes']['total'] }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)'
                        ],
                        borderColor: [
                            '#3B82F6',
                            '#10B981'
                        ],
                        borderWidth: 2,
                        hoverOffset: 15,
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 25,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                color: 'black',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(255, 255, 255, 0.3)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percent = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 2000
                    }
                }
            });

            // Status Bar Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            
            const statusChart = new Chart(statusCtx, {
                type: 'bar',
                data: {
                    labels: ['Techniciens', 'Clients'],
                    datasets: [
                        {
                            label: 'Actifs',
                            data: [{{ $stats['techniciens']['actifs'] }}, {{ $stats['employes']['actifs'] }}],
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: '#10B981',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        },
                        {
                            label: 'Inactifs',
                            data: [{{ $stats['techniciens']['inactifs'] }}, {{ $stats['employes']['inactifs'] }}],
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderColor: '#EF4444',
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: 'black',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                color: 'black',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 25,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                color: 'black',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(255, 255, 255, 0.3)',
                            borderWidth: 1,
                            mode: 'index',
                            intersect: false
                        }
                    },
                    animation: {
                        delay: function(context) {
                            return context.dataIndex * 150;
                        },
                        duration: 2000
                    }
                }
            });

            // Add loading animations
            setTimeout(() => {
                document.querySelectorAll('.progress-fill').forEach(fill => {
                    fill.style.width = '0%';
                    setTimeout(() => {
                        fill.style.width = fill.getAttribute('data-width') || fill.style.width;
                    }, 100);
                });
            }, 500);
        });
    </script>
</body>
</html>