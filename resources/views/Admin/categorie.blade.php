<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5e8899;
            --secondary-color: #6d9db3;
            --accent-color: #4a6d7a;
            --light-color: #f8f9fa;
            --dark-color: #2b2d42;
            --success-color: #5e8899;
            --card-hover: #f0f7fa;
            --text-light: #adb5bd;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: var(--dark-color);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }

        .sidebar-container {
            flex-shrink: 0;
        }

        .main-content {
            flex-grow: 1;
            overflow-x: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 70px;
        }

        h1 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .category-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.08);
            position: relative;
            height: 150px;
            display: flex;
            flex-direction: column;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background-color: var(--card-hover);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .category-card:hover::before {
            opacity: 1;
            height: 6px;
        }

        .card-header {
            background-color: #6d9db3;
            color: white;
            padding: 1.9rem;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 25px;
            min-height: 50px;
        }

        .card-header i {
            font-size: 1.5rem;
            width: 30px;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 50%;
        }

        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .category-item {
            padding: 0.85rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.2s;
            border-radius: 6px;
            padding-left: 10px;
        }

        .category-item:hover {
            color: var(--primary-color);
            background-color: rgba(94, 136, 153, 0.05);
            transform: translateX(5px);
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-item i {
            color: var(--accent-color);
            width: 24px;
            text-align: center;
            font-size: 1rem;
            transition: transform 0.2s;
        }

        .category-item:hover i {
            transform: scale(1.2);
            color: var(--primary-color);
        }

        .btn-back {
            background: white;
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(94, 136, 153, 0.3);
        }

        .btn-back:hover {
            background: #f1f5f9;
            transform: translateX(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-back i {
            transition: transform 0.3s;
        }

        .btn-back:hover i {
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .category-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .category-card {
                height: auto;
                min-height: 250px;
            }

            .container {
                padding: 15px;
                margin-top: 60px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .category-card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .category-card:nth-child(1) { animation-delay: 0.1s; }
        .category-card:nth-child(2) { animation-delay: 0.2s; }
        .category-card:nth-child(3) { animation-delay: 0.3s; }
        .category-card:nth-child(4) { animation-delay: 0.4s; }
        .category-card:nth-child(5) { animation-delay: 0.5s; }
        .category-card:nth-child(6) { animation-delay: 0.6s; }
        .category-card:nth-child(7) { animation-delay: 0.7s; }
        .category-card:nth-child(8) { animation-delay: 0.8s; }
        .category-card:nth-child(9) { animation-delay: 0.9s; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar-container">
        @include('Sidebar.sidebar')
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="min-h-screen">
            <div class="container">
                <div class="category-grid">
                    <!-- Cities Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('ville.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-city"></i>
                            Cities
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-map-marker-alt"></i>
                                List of available cities
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new city
                            </div>
                        </div>
                    </div>

                    <!-- Services Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('service.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-concierge-bell"></i>
                            Services
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-tools"></i>
                                Maintenance services
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new service
                            </div>
                        </div>
                    </div>

                    <!-- Tickets Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('ticket.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-ticket-alt"></i>
                            Support Tickets
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-tags"></i>
                                Category types
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Create a new ticket
                            </div>
                        </div>
                    </div>

                    <!-- Automobile Companies Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('entrepriseAutomobile.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-car"></i>
                            Automobile Companies
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-industry"></i>
                                List of companies
                            </div>
                            <div class="category-item">
                                <i class="fas fa-car-side"></i>
                                Car types
                            </div>
                        </div>
                    </div>

                    <!-- Packages Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('forfait.index') }}'">
                        <div class="card-header" >
                            <i class="fas fa-box-open"></i>
                            Packages
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-list-ol"></i>
                                List of packages
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new package
                            </div>
                        </div>
                    </div>

                    <!-- Specializations Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('specialisation.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-user-graduate"></i>
                            Specializations
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-list-ul"></i>
                                List of specializations
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new specialization
                            </div>
                        </div>
                    </div>

                    <!-- Banks Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('banque.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-university"></i>
                            Banks
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-list"></i>
                                List of banks
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new bank
                            </div>
                        </div>
                    </div>

                    <!-- Colors Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('couleur.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-palette"></i>
                            Colors
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-list"></i>
                                List of colors
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new color
                            </div>
                        </div>
                    </div>

                    <!-- Spare Parts Card -->
                    <div class="category-card" onclick="window.location.href='{{ route('classificationPiece.index') }}'">
                        <div class="card-header">
                            <i class="fas fa-cogs"></i>
                            Spare Parts
                        </div>
                        <div class="card-body">
                            <div class="category-item">
                                <i class="fas fa-tag"></i>
                                Part categories
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                Add a new part
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
