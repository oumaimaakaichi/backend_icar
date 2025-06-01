<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 80px;
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --text-color: #495057;
            --text-light: #6c757d;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
        }

        /* Modern Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: var(--transition);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .sidebar-logo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .sidebar-logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 20px;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-light);
            margin-bottom: 15px;
            padding-left: 15px;
            font-weight: 600;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            color: var(--text-color);
            text-decoration: none;
            margin-bottom: 5px;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
        }

        .menu-link i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 18px;
            color: var(--text-light);
            transition: var(--transition);
        }

        .menu-link:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .menu-link:hover i {
            color: var(--primary-color);
        }

        .menu-link.active {
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(67, 97, 238, 0.05));
            color: var(--primary-color);
            font-weight: 600;
        }

        .menu-link.active i {
            color: var(--primary-color);
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary-color);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .menu-badge {
            margin-left: auto;
            background-color: var(--primary-color);
            color: white;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 12px;
            font-size: 16px;
        }

        .user-info {
            flex-grow: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .user-role {
            font-size: 12px;
            color: var(--text-light);
        }

        .user-dropdown {
            color: var(--text-light);
            transition: var(--transition);
        }

        .user-profile:hover .user-dropdown {
            color: var(--primary-color);
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
        }

        /* Header */
        .main-header {
            height: var(--header-height);
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 1px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .search-bar {
            position: relative;
            margin-left: 20px;
        }

        .search-bar input {
            padding: 10px 15px 10px 40px;
            border-radius: var(--border-radius);
            border: 1px solid rgba(0, 0, 0, 0.1);
            width: 250px;
            transition: var(--transition);
            font-size: 14px;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            position: relative;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: var(--transition);
        }

        .header-icon:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-profile-header {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-left: 20px;
            padding: 5px 10px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .user-profile-header:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .user-avatar-header {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
            font-size: 16px;
        }

        .user-name-header {
            font-weight: 600;
            font-size: 14px;
            margin-right: 8px;
        }

        .user-dropdown-header {
            color: var(--text-light);
            transition: var(--transition);
        }

        .user-profile-header:hover .user-dropdown-header {
            color: var(--primary-color);
        }

        /* User dropdown menu */
        .user-dropdown-menu {
            position: absolute;
            top: calc(var(--header-height) + 10px);
            right: 30px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            width: 250px;
            z-index: 1000;
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: var(--transition);
        }

        .user-dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .user-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -10px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid white;
        }

        .dropdown-header {
            padding: 0 20px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .dropdown-header-info {
            margin-left: 12px;
        }

        .dropdown-header-name {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .dropdown-header-email {
            font-size: 13px;
            color: var(--text-light);
        }

        .dropdown-menu-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .dropdown-menu-list li a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            font-size: 14px;
        }

        .dropdown-menu-list li a i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
            color: var(--text-light);
        }

        .dropdown-menu-list li a:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .dropdown-menu-list li a:hover i {
            color: var(--primary-color);
        }

        .dropdown-footer {
            padding: 10px 20px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dropdown-footer a {
            display: flex;
            align-items: center;
            color: var(--danger-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 0;
        }

        .dropdown-footer a i {
            margin-right: 10px;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        .breadcrumb {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        .breadcrumb-item {
            color: var(--text-light);
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            padding: 0 8px;
            color: var(--text-light);
        }

        .page-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: var(--border-radius);
            font-weight: 500;
            font-size: 14px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .card-icon.primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .card-icon.success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .card-icon.warning {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .card-icon.danger {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger-color);
        }

        .card-title {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
            font-weight: 500;
        }

        .card-value {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .card-change {
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .card-change.positive {
            color: #28a745;
        }

        .card-change.negative {
            color: #dc3545;
        }

        /* Recent Activity */
        .activity-card {
            margin-bottom: 30px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header-title {
            font-weight: 600;
            font-size: 16px;
            margin: 0;
        }

        .card-header-actions {
            display: flex;
            gap: 10px;
        }

        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: flex-start;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .activity-icon.primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .activity-icon.success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .activity-icon.warning {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .activity-icon.danger {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger-color);
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-message {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 12px;
            color: var(--text-light);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
            }
        }

        /* Toggle button for mobile */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-color);
            cursor: pointer;
            margin-right: 15px;
        }

        /* Dark mode toggle */
        .dark-mode-toggle {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .dark-mode-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin: 0 10px;
        }

        .dark-mode-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .dark-mode-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .dark-mode-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .dark-mode-slider {
            background-color: var(--primary-color);
        }

        input:checked + .dark-mode-slider:before {
            transform: translateX(26px);
        }

        /* Dark mode styles */
        body.dark-mode {
            background-color: #1a1a2e;
            color: #e6e6e6;
        }

        body.dark-mode .sidebar {
            background-color: #16213e;
            color: #e6e6e6;
            border-right-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .main-header {
            background-color: #16213e;
            box-shadow: 0 1px 15px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .card {
            background-color: #16213e;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode .card-header {
            background-color: #16213e;
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .user-dropdown-menu {
            background-color: #16213e;
        }

        body.dark-mode .user-dropdown-menu::before {
            border-bottom-color: #16213e;
        }

        body.dark-mode .dropdown-header {
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .dropdown-footer {
            border-top-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .activity-item {
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .menu-link {
            color: #e6e6e6;
        }

        body.dark-mode .menu-section-title {
            color: rgba(255, 255, 255, 0.5);
        }

        body.dark-mode .card-title {
            color: rgba(255, 255, 255, 0.7);
        }

        body.dark-mode .card-value {
            color: #ffffff;
        }

        body.dark-mode .activity-time {
            color: rgba(255, 255, 255, 0.5);
        }

        body.dark-mode .dropdown-menu-list li a {
            color: #e6e6e6;
        }

        body.dark-mode .search-bar input {
            background-color: #0f3460;
            border-color: rgba(255, 255, 255, 0.1);
            color: #e6e6e6;
        }

        body.dark-mode .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        body.dark-mode .search-bar i {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo-container">
            <img src="{{ asset('images/avatar.png') }}" alt="Logo" class="sidebar-logo">
            <span class="sidebar-logo-text">AdminPro</span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="dashboard" class="menu-link active">
                    <i class="fas fa-home"></i>Dashboard
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="technicien" class="menu-link">
                    <i class="fa-solid fa-screwdriver-wrench"></i>Technicians
                </a>
                <a href="employee" class="menu-link">
                    <i class="fa-solid fa-users"></i>Customers
                </a>
                <a href="experts" class="menu-link">
                    <i class="fa-solid fa-user-tie"></i>Experts
                </a>
                <a href="entrepriseContractante" class="menu-link">
                    <i class="fa-solid fa-building"></i>Contracting Companies
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Inventory</div>
                <a href="catalogues" class="menu-link">
                    <i class="fa-solid fa-book-open"></i>Catalogue
                </a>
                <a href="categorie" class="menu-link">
                    <i class="fa-solid fa-tags"></i>Categories
                </a>
                <a href="camions" class="menu-link">
                    <i class="fa-solid fa-truck"></i>Vehicles
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Operations</div>
                <a href="atelier" class="menu-link">
                    <i class="fa-solid fa-tools"></i>Workshop
                </a>
                <a href="statistiques" class="menu-link">
                    <i class="fa-solid fa-chart-line"></i>Statistics
                </a>
                <a href="points" class="menu-link">
                    <i class="fa-solid fa-gem"></i>Loyalty Points
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile" id="sidebar-user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::guard('web')->user()->nom, 0, 1)) }}{{ strtoupper(substr(Auth::guard('web')->user()->prenom, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <div class="user-dropdown">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="main-header">
            <div class="header-left">
                <button class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
            </div>

            <div class="header-right">
                <div class="dark-mode-toggle">
                    <i class="fas fa-sun"></i>
                    <label class="dark-mode-switch">
                        <input type="checkbox" id="dark-mode-toggle">
                        <span class="dark-mode-slider"></span>
                    </label>
                    <i class="fas fa-moon"></i>
                </div>

                <div class="header-icons">
                    <div class="header-icon">
                        <i class="fas fa-envelope"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </div>
                </div>

                <div class="user-profile-header" id="user-profile-header">
                    <div class="user-avatar-header">
                        {{ strtoupper(substr(Auth::guard('web')->user()->nom, 0, 1)) }}{{ strtoupper(substr(Auth::guard('web')->user()->prenom, 0, 1)) }}
                    </div>
                    <div class="user-name-header">{{ Auth::guard('web')->user()->nom }}</div>
                    <div class="user-dropdown-header">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <!-- User Dropdown Menu -->
            <div class="user-dropdown-menu" id="user-dropdown-menu">
                <div class="dropdown-header">
                    <div class="user-avatar-header">
                        {{ strtoupper(substr(Auth::guard('web')->user()->nom, 0, 1)) }}{{ strtoupper(substr(Auth::guard('web')->user()->prenom, 0, 1)) }}
                    </div>
                    <div class="dropdown-header-info">
                        <div class="dropdown-header-name">{{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}</div>
                        <div class="dropdown-header-email">{{ Auth::guard('web')->user()->email }}</div>
                    </div>
                </div>

                <ul class="dropdown-menu-list">
                    <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="#"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li>
                </ul>

                <div class="dropdown-footer">
                    <a href="#" id="logout-button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
                <div class="page-actions">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </button>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-title">Total Customers</div>
                        <div class="card-value">1,254</div>
                        <div class="card-change positive">
                            <i class="fas fa-arrow-up"></i> 12.5% from last month
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-icon success">
                            <i class="fas fa-screwdriver-wrench"></i>
                        </div>
                        <div class="card-title">Active Technicians</div>
                        <div class="card-value">48</div>
                        <div class="card-change positive">
                            <i class="fas fa-arrow-up"></i> 3.2% from last month
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-icon warning">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="card-title">Pending Repairs</div>
                        <div class="card-value">24</div>
                        <div class="card-change negative">
                            <i class="fas fa-arrow-down"></i> 8.1% from last month
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="card-icon danger">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-title">Monthly Revenue</div>
                        <div class="card-value">$34,567</div>
                        <div class="card-change positive">
                            <i class="fas fa-arrow-up"></i> 15.7% from last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card activity-card">
                <div class="card-header">
                    <h3 class="card-header-title">Recent Activity</h3>
                    <div class="card-header-actions">
                        <button class="btn btn-outline-primary btn-sm">View All</button>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-icon primary">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-message">
                                    <strong>John Doe</strong> registered as a new customer
                                </div>
                                <div class="activity-time">10 minutes ago</div>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-message">
                                    Repair order <strong>#RO-2023-0456</strong> has been completed
                                </div>
                                <div class="activity-time">1 hour ago</div>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-message">
                                    <strong>3 vehicles</strong> are awaiting parts delivery
                                </div>
                                <div class="activity-time">3 hours ago</div>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-message">
                                    Appointment with <strong>ABC Contracting</strong> was cancelled
                                </div>
                                <div class="activity-time">5 hours ago</div>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon primary">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-message">
                                    New vehicle <strong>Ford F-150</strong> added to fleet
                                </div>
                                <div class="activity-time">Yesterday</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--