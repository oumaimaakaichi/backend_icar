<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des Spécialisations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #ffffff;
            color: #0f172a;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 15% 25%, rgba(79, 70, 229, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 85% 75%, rgba(236, 72, 153, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .dashboard-container {
width: 1500px;
            margin-top: 100px;
margin-right: 40px;

            position: relative;
            z-index: 1;
            max-width: 1600px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Section */
        .page-header {
             background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 30px;
            padding: 3rem;
            margin-bottom: 3rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;

        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

        }

        @keyframes patternSlide {
            0% { transform: translate(0, 0); }
            100% { transform: translate(40px, 40px); }
        }

        .page-header-content {
            position: relative;
            z-index: 2;
        }

        .page-header h1 {
            color: rgb(50, 45, 45);
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 0.75rem;
            letter-spacing: -0.03em;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .page-header p {
            color: rgba(145, 140, 140, 0.9);
            font-size: 1.125rem;
            font-weight: 500;
        }

        /* Modern Cards */
        .card-modern {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #4f46e5, #ec4899);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform 0.4s ease;
        }

        .card-modern:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: #c7d2fe;
        }

        .card-modern:hover::before {
            transform: scaleY(1);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 1.75rem;
            margin-bottom: 3rem;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-icon-box {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .card-modern:hover .stat-icon-box {
            transform: scale(1.1) rotate(-5deg);
        }

        .stat-number {
            font-size: 2.75rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .status-badges {
            display: flex;
            gap: 0.875rem;
            flex-wrap: wrap;
        }

        .badge-status {
            padding: 0.625rem 1.125rem;
            border-radius: 50px;
            font-size: 0.8125rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid;
        }

        .badge-status:hover {
            transform: scale(1.05);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .badge-active {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .badge-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .badge-pending {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
            border-color: rgba(59, 130, 246, 0.2);
        }

        .badge-assigned {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-color: rgba(16, 185, 129, 0.2);
        }

        /* Progress Section */
        .progress-section {
            margin-top: 1.5rem;
        }

        .progress-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .progress-bar-container {
            width: 100%;
            height: 10px;
            background: #f1f5f9;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 0.5rem;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .progress-bar-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s ease-out;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 1.75rem;
            margin-bottom: 3rem;
        }

        .chart-card {
            min-height: 450px;
        }

        .chart-header {
            margin-bottom: 2rem;
            text-align: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .chart-title {
            color: #0f172a;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .chart-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .chart-wrapper {
            position: relative;
            height: 320px;
            padding: 1rem;
        }

        /* Activity Section */
        .activity-section {
            margin-bottom: 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-title {
            color: #0f172a;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1rem;
            font-weight: 500;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            padding: 1.75rem;
            background: white;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease-out;
        }

        .activity-item:hover {
            background: #f8fafc;
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .activity-item.new { border-left: 4px solid #3b82f6; }
        .activity-item.update { border-left: 4px solid #10b981; }
        .activity-item.profile { border-left: 4px solid #8b5cf6; }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .activity-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .activity-content h4 {
            color: #0f172a;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
        }

        .activity-content p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .activity-time {
            color: #94a3b8;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        /* Button */
        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-view-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(79, 70, 229, 0.35);
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
        }

        .btn-container {
            text-align: center;
            margin-top: 2rem;
        }

        /* Responsive */
        @media (max-width: 1600px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .dashboard-container {
                margin-left: 0;
                margin-right: 20px;
                padding: 1.5rem;
                margin-top: 30px;
            }

            .page-header {
                padding: 2rem;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .page-header h1 {
                font-size: 1.75rem;
            }

            .stat-number {
                font-size: 2.25rem;
            }
        }
    </style>
</head>

<body>
    @include('Sidebar.sidebarAtelier')

    <div class="dashboard-container">
        <!-- Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h1><i class="fas fa-chart-line me-3"></i>Workshop Dashboard</h1>
                <p>Comprehensive overview of specializations and operations</p>
            </div>
        </div>

        <!-- Maintenance Requests Cards -->
        <div class="stats-grid">
            <div class="card-modern">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Known Failures</div>
                        <div class="stat-number">{{ $stats['demandes']['total'] }}</div>
                    </div>
                    <div class="stat-icon-box" style="background: linear-gradient(135deg, #6c889a, #5a7a8e);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="status-badges">
                    <div class="badge-status badge-pending">
                        <div class="status-dot" style="background: #3b82f6;"></div>
                        {{ $stats['demandes']['en_attente'] }} Pending
                    </div>
                    <div class="badge-status badge-assigned">
                        <div class="status-dot" style="background: #10b981;"></div>
                        {{ $stats['demandes']['assignees'] }} Assigned
                    </div>
                </div>
            </div>

            <div class="card-modern">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Unknown Failures</div>
                        <div class="stat-number">{{ $stats['demandesIN']['total'] }}</div>
                    </div>
                    <div class="stat-icon-box" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="status-badges">
                    <div class="badge-status badge-pending">
                        <div class="status-dot" style="background: #3b82f6;"></div>
                        {{ $stats['demandesIN']['en_attente'] }} Pending
                    </div>
                    <div class="badge-status badge-assigned">
                        <div class="status-dot" style="background: #10b981;"></div>
                        {{ $stats['demandesIN']['assignees'] }} Assigned
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Statistics -->
        <div class="stats-grid">
            <div class="card-modern">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Technicians</div>
                        <div class="stat-number">{{ $stats['techniciens']['total'] }}</div>
                    </div>
                    <div class="stat-icon-box" style="background: linear-gradient(135deg, #3b82f6, #1e40af);">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
                <div class="status-badges">
                    <div class="badge-status badge-active">
                        <div class="status-dot" style="background: #10b981;"></div>
                        {{ $stats['techniciens']['actifs'] }} Active
                    </div>
                    <div class="badge-status badge-inactive">
                        <div class="status-dot" style="background: #ef4444;"></div>
                        {{ $stats['techniciens']['inactifs'] }} Inactive
                    </div>
                </div>
            </div>

            <div class="card-modern">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Clients</div>
                        <div class="stat-number">{{ $stats['employes']['total'] }}</div>
                    </div>
                    <div class="stat-icon-box" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="status-badges">
                    <div class="badge-status badge-active">
                        <div class="status-dot" style="background: #10b981;"></div>
                        {{ $stats['employes']['actifs'] }} Active
                    </div>
                    <div class="badge-status badge-inactive">
                        <div class="status-dot" style="background: #ef4444;"></div>
                        {{ $stats['employes']['inactifs'] }} Inactive
                    </div>
                </div>
            </div>

            <div class="card-modern">
                <div class="stat-card-header">
                    <div>
                        <div class="stat-label">Total Staff</div>
                        <div class="stat-number">{{ $stats['total_personnel'] }}</div>
                    </div>
                    <div class="stat-icon-box" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
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
                        <span>Technicians</span>
                        <span>{{ $percentTech }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $percentTech }}%; background: linear-gradient(90deg, #3b82f6, #1e40af);"></div>
                    </div>
                    <div class="progress-item" style="margin-top: 1rem;">
                        <span>Clients</span>
                        <span>{{ $percentEmp }}%</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $percentEmp }}%; background: linear-gradient(90deg, #10b981, #059669);"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <div class="card-modern chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Request Progress</h3>
                    <p class="chart-subtitle">Number of Requests per Month ({{ date('Y') }})</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="demandesChart"></canvas>
                </div>
            </div>

            <div class="card-modern chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Staff Distribution</h3>
                    <p class="chart-subtitle">Ratio of Technicians to Clients</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="personnelChart"></canvas>
                </div>
            </div>


        </div>

        <!-- Activity Section -->
        <div class="card-modern activity-section">
            <div class="section-header">
                <h3 class="section-title">Recent Activity</h3>
                <p class="section-subtitle">Latest Changes in the System</p>
            </div>

            <div class="activity-list">
                <div class="activity-item new">
                    <div class="activity-icon-wrapper" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="activity-content">
                        <h4>New Technician Added</h4>
                        <p>Jean Dupont was added to the system</p>
                        <span class="activity-time">2 hours ago</span>
                    </div>
                </div>

                <div class="activity-item update">
                    <div class="activity-icon-wrapper" style="background: rgba(16, 185, 129, 0.15); color: #10b981;">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Status Change</h4>
                        <p>Marie Martin marked as inactive</p>
                        <span class="activity-time">5 hours ago</span>
                    </div>
                </div>

                <div class="activity-item profile">
                    <div class="activity-icon-wrapper" style="background: rgba(139, 92, 246, 0.15); color: #8b5cf6;">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Profile Updated</h4>
                        <p>Pierre Bernard updated his information</p>
                        <span class="activity-time">1 day ago</span>
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <a href="#" class="btn-view-all">
                    <i class="fas fa-eye"></i>
                    View All Activity
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Requests Line Chart
            const demandesCtx = document.getElementById('demandesChart').getContext('2d');
            const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const demandesData = Array(12).fill(0);

            @foreach ($stats['demandes_par_mois'] as $mois => $total)
                demandesData[{{ $mois - 1 }}] = {{ $total }};
            @endforeach

            new Chart(demandesCtx, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Requests',
                        data: demandesData,
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderColor: '#f59e0b',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#64748b',
                                font: { size: 12, weight: '600', family: 'Inter' }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                color: '#64748b',
                                font: { size: 12, family: 'Inter' },
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 12,
                            titleFont: { size: 13, weight: 'bold', family: 'Inter' },
                            bodyFont: { size: 12, family: 'Inter' }
                        }
                    },
                    animation: { duration: 1500, easing: 'easeInOutQuart' }
                }
            });

            // Personnel Doughnut Chart
            const personnelCtx = document.getElementById('personnelChart').getContext('2d');
            new Chart(personnelCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Technicians', 'Clients'],
                    datasets: [{
                        data: [{{ $stats['techniciens']['total'] }}, {{ $stats['employes']['total'] }}],
                        backgroundColor: ['rgba(59, 130, 246, 0.85)', 'rgba(16, 185, 129, 0.85)'],
                        borderColor: ['#3b82f6', '#10b981'],
                        borderWidth: 2,
                        hoverOffset: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: '#475569',
                                font: { size: 13, weight: '600', family: 'Inter' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 12,
                            titleFont: { size: 13, weight: 'bold', family: 'Inter' },
                            bodyFont: { size: 12, family: 'Inter' }
                        }
                    },
                    animation: { animateScale: true, animateRotate: true, duration: 1500 }
                }
            });

            // Status Bar Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'bar',
                data: {
                    labels: ['Technicians', 'Clients'],
                    datasets: [
                        {
                            label: 'Active',
                            data: [{{ $stats['techniciens']['actifs'] }}, {{ $stats['employes']['actifs'] }}],
                            backgroundColor: 'rgba(16, 185, 129, 0.85)',
                            borderRadius: 10,
                            borderSkipped: false
                        },
                        {
                            label: 'Inactive',
                            data: [{{ $stats['techniciens']['inactifs'] }}, {{ $stats['employes']['inactifs'] }}],
                            backgroundColor: 'rgba(239, 68, 68, 0.85)',
                            borderRadius: 10,
                            borderSkipped: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: { display: false },
                            ticks: {
                                color: '#64748b',
                                font: { size: 13, weight: '600', family: 'Inter' }
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                color: '#64748b',
                                font: { size: 12, family: 'Inter' }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                color: '#475569',
                                font: { size: 13, weight: '600', family: 'Inter' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 12,
                            titleFont: { size: 13, weight: 'bold', family: 'Inter' },
                            bodyFont: { size: 12, family: 'Inter' },
                            mode: 'index',
                            intersect: false
                        }
                    },
                    animation: {
                        delay: function(context) {
                            return context.dataIndex * 150;
                        },
                        duration: 1500
                    }
                }
            });

            // Animate progress bars
            setTimeout(() => {
                document.querySelectorAll('.progress-bar-fill').forEach(fill => {
                    const width = fill.style.width;
                    fill.style.width = '0%';
                    setTimeout(() => {
                        fill.style.width = width;
                    }, 100);
                });
            }, 300);
        });
    </script>
</body>
</html>
