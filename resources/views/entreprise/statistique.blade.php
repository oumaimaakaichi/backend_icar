<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Statistics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome & Chart.js -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 80px auto 30px auto;
            padding: 20px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 30px;
            color: #2d3436;
            border-left: 6px solid #74b9ff;
            padding-left: 15px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #636e72;
        }

        .stat-title {
            font-weight: 500;
            color: #636e72;
            margin-bottom: 8px;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #2d3436;
        }

        .chart-card {
            margin-top: 40px;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
        }

        .chart-title {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.2rem;
            color: #2d3436;
        }

        .chart-container {
            height: 350px;
        }
    </style>
</head>
<body>

@include('Sidebar.sidebarEntreprise')

<div class="container">
    <h2 class="section-title">Employee Statistics</h2>

    <div class="stat-grid">
        <div class="stat-card">
            <i class="fas fa-users stat-icon"></i>
            <div class="stat-title">Total Employees</div>
            <div class="stat-value">{{ $stats['employes']['total'] }}</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle stat-icon"></i>
            <div class="stat-title">Approved</div>
            <div class="stat-value">{{ $stats['employes']['approuves'] }}</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-times-circle stat-icon"></i>
            <div class="stat-title">Rejected</div>
            <div class="stat-value">{{ $stats['employes']['rejetes'] }}</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-title">Pending</div>
            <div class="stat-value">{{ $stats['employes']['en_attente'] }}</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-user-check stat-icon"></i>
            <div class="stat-title">Active</div>
            <div class="stat-value">{{ $stats['employes']['actifs'] }}</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-user-slash stat-icon"></i>
            <div class="stat-title">Inactive</div>
            <div class="stat-value">{{ $stats['employes']['inactifs'] }}</div>
        </div>
    </div>

    <div class="chart-card">
        <div class="chart-title">Employee Distribution</div>
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Rejected', 'Pending'],
            datasets: [{
                data: [
                    {{ $stats['employes']['approuves'] }},
                    {{ $stats['employes']['rejetes'] }},
                    {{ $stats['employes']['en_attente'] }}
                ],
                backgroundColor: ['#55efc4', '#fab1a0', '#ffeaa7'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: '#2d3436'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.7)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    padding: 10,
                    cornerRadius: 8
                }
            },
            cutout: '65%'
        }
    });
</script>

</body>
</html>
