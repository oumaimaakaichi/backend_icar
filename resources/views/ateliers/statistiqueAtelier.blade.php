

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestion des specialisations</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    </head>

    <body>
        <body class="bg-light">
            @include('Sidebar.sidebarAtelier')
            <div class="container py-5" style="margin-top: 50px">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 md:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
                        <p class="text-gray-500 mt-2">Statistiques globales du personnel</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Dernière mise à jour:</span>
                        <span class="text-sm font-medium text-gray-700">{{ now()->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <!-- Stats Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    <!-- Techniciens Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Techniciens</p>
                                    <h3 class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['techniciens']['total'] }}</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-blue-50 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between">
                                <div class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1 h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        {{ $stats['techniciens']['actifs'] }} Actifs
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="-ml-0.5 mr-1 h-3 w-3 text-red-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        {{ $stats['techniciens']['inactifs'] }} Inactifs
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employés Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Clients</p>
                                    <h3 class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['employes']['total'] }}</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-green-50 text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between">
                                <div class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1 h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        {{ $stats['employes']['actifs'] }} Actifs
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="-ml-0.5 mr-1 h-3 w-3 text-red-500" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        {{ $stats['employes']['inactifs'] }} Inactifs
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Personnel Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Personnel Total</p>
                                    <h3 class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['total_personnel'] }}</h3>
                                </div>
                                <div class="p-3 rounded-lg bg-purple-50 text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-6">
                                @php
                                    $total = $stats['total_personnel'] ?: 1;
                                    $percentTech = round(($stats['techniciens']['total'] / $total) * 100);
                                    $percentEmp = round(($stats['employes']['total'] / $total) * 100);
                                @endphp
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-1">
                                    <span>Techniciens</span>
                                    <span>{{ $percentTech }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-2 rounded-full" style="width: {{ $percentTech }}%"></div>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-500 mt-3 mb-1">
                                    <span>Clients</span>
                                    <span>{{ $percentEmp }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-green-400 h-2 rounded-full" style="width: {{ $percentEmp }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    <!-- Pie Chart Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Répartition du Personnel</h2>
                            <p class="text-sm text-gray-500">Proportion entre techniciens et Clients</p>
                        </div>
                        <div class="p-4">
                            <canvas id="personnelChart" class="w-full h-72"></canvas>
                        </div>
                    </div>

                    <!-- Bar Chart Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Statut Actif/Inactif</h2>
                            <p class="text-sm text-gray-500">Comparaison entre les différents statuts</p>
                        </div>
                        <div class="p-4">
                            <canvas id="statusChart" class="w-full h-72"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-10">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Activité Récente</h2>
                        <p class="text-sm text-gray-500">Dernières modifications dans le système</p>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <!-- Sample Activity Items - Replace with dynamic content -->
                        <div class="p-4 flex items-start hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex-shrink-0 mt-1">
                                <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">Nouveau technicien ajouté</p>
                                <p class="text-sm text-gray-500">Jean Dupont a été ajouté au système</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-start hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex-shrink-0 mt-1">
                                <div class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">Statut modifié</p>
                                <p class="text-sm text-gray-500">Marie Martin marquée comme inactive</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 5 heures</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-start hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex-shrink-0 mt-1">
                                <div class="h-8 w-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">Mise à jour du profil</p>
                                <p class="text-sm text-gray-500">Pierre Bernard a mis à jour ses informations</p>
                                <p class="text-xs text-gray-400 mt-1">Il y a 1 jour</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t border-gray-100 text-center">
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Voir toute l'activité</a>
                    </div>
                </div>
            </div>
        </div>

            </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Personnel Pie Chart with animation
            document.addEventListener('DOMContentLoaded', function() {
                const personnelCtx = document.getElementById('personnelChart').getContext('2d');
                const personnelChart = new Chart(personnelCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Techniciens', 'Employés'],
                        datasets: [{
                            data: [{{ $stats['techniciens']['total'] }}, {{ $stats['employes']['total'] }}],
                            backgroundColor: ['#3B82F6', '#10B981'],
                            borderWidth: 0,
                            hoverOffset: 10
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
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
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
                            animateRotate: true
                        }
                    }
                });

                // Status Bar Chart
                const statusCtx = document.getElementById('statusChart').getContext('2d');
                const statusChart = new Chart(statusCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Techniciens', 'Employés'],
                        datasets: [
                            {
                                label: 'Actifs',
                                data: [{{ $stats['techniciens']['actifs'] }}, {{ $stats['employes']['actifs'] }}],
                                backgroundColor: '#10B981',
                                borderRadius: 4,
                                borderSkipped: false,
                            },
                            {
                                label: 'Inactifs',
                                data: [{{ $stats['techniciens']['inactifs'] }}, {{ $stats['employes']['inactifs'] }}],
                                backgroundColor: '#EF4444',
                                borderRadius: 4,
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
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        animation: {
                            delay: function(context) {
                                return context.dataIndex * 100;
                            }
                        }
                    }
                });
            });
        </script>
    </body>
</html>



