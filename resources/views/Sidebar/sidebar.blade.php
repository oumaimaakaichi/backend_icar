<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --text-color: #2d3748;
            --text-light: #a0aec0;
            --text-white: #ffffff;
            --bg-color: #f7fafc;
            --sidebar-bg: linear-gradient(135deg, #3f5a6e 0%, #3f5a6e 100%);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --hover-bg: rgba(255, 255, 255, 0.1);
            --active-bg: rgba(255, 255, 255, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow);
            z-index: 1000;
            transition: var(--transition);
            backdrop-filter: blur(10px);
            width: 250px
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .menu-section-title,
        .sidebar.collapsed .menu-link-text {
            display: none;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 14px 0;
        }

        .sidebar.collapsed .menu-link i {
            margin-right: 0;
            font-size: 20px;
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 20px 0;
        }

        .sidebar.collapsed .user-profile {
            justify-content: center;
        }

        .sidebar.collapsed .user-profile-info {
            display: none;
        }

        .sidebar-logo-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 30px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 25px;
            transition: var(--transition);
        }

        .sidebar.collapsed .sidebar-logo-container {
            justify-content: center;
            padding: 30px 0;
        }

        .sidebar-logo {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 12px;
            margin-right: 15px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition);
        }

        .sidebar-logo:hover {
            transform: scale(1.05);
        }

        .sidebar-logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-white);
            transition: var(--transition);
            letter-spacing: -0.5px;
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 20px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-menu::-webkit-scrollbar {
            display: none;
        }

        .menu-section {
            margin-bottom: 35px;
        }

        .menu-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 18px;
            padding-left: 15px;
            font-weight: 600;
            transition: var(--transition);
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 14px 18px;
            border-radius: var(--border-radius);
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            margin-bottom: 6px;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            white-space: nowrap;
            backdrop-filter: blur(10px);
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            margin-right: 15px;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .menu-link:hover {
            background: var(--hover-bg);
            color: var(--text-white);
            transform: translateX(5px);
        }

        .menu-link:hover i {
            color: var(--text-white);
            transform: scale(1.1);
        }

        .menu-link.active {
            background: var(--active-bg);
            color: var(--text-white);
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu-link.active i {
            color: var(--text-white);
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--text-white);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .menu-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-white);
            font-size: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .sidebar-footer {
            padding: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .user-profile:hover {
            background: var(--hover-bg);
            transform: translateY(-2px);
        }

        .user-profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: var(--text-white);
            font-weight: bold;
            font-size: 16px;
            backdrop-filter: blur(10px);
        }

        .user-profile-info {
            flex: 1;
            overflow: hidden;
        }

        .user-profile-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--text-white);
        }

        .user-profile-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-profile-dropdown {
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .sidebar.collapsed .user-profile-dropdown {
            display: none;
        }

        /* Header Styles */
        .main-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 80px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            z-index: 100;
            transition: var(--transition);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar.collapsed ~ .main-header {
            left: var(--sidebar-collapsed-width);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .toggle-sidebar {
            font-size: 20px;
            color: var(--text-color);
            cursor: pointer;
            transition: var(--transition);
            padding: 10px;
            border-radius: 50%;
            background: var(--bg-color);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.05);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .page-breadcrumb {
            font-size: 14px;
            color: var(--text-light);
            margin-top: 2px;
        }

        .breadcrumb-item {
            color: var(--text-light);
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        .breadcrumb-separator {
            margin: 0 8px;
            color: var(--text-light);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            position: relative;
            cursor: pointer;
            color: var(--text-light);
            font-size: 18px;
            transition: var(--transition);
            padding: 8px;
            border-radius: 50%;
            background: var(--bg-color);
        }

        .header-icon:hover {
            color: var(--primary-color);
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.05);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 2px solid white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .user-info:hover {
            background: var(--bg-color);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .user-avatar:hover {
            transform: scale(1.05);
        }

        /* User info popup */
        .user-popup {
            position: absolute;
            top: 80px;
            right: 30px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            width: 220px;
            z-index: 1000;
            display: none;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .user-popup.show {
            display: block;
            animation: fadeInUp 0.3s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-popup::before {
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

        .user-popup-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .popup-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .popup-user-name {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 4px;
            font-size: 16px;
        }

        .popup-user-email {
            font-size: 12px;
            color: var(--text-light);
        }

        .user-popup-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user-popup-menu li {
            padding: 0;
            margin-bottom: 8px;
        }

        .user-popup-menu li:last-child {
            margin-bottom: 0;
        }

        .user-popup-menu li a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            transition: var(--transition);
            padding: 10px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .user-popup-menu li a:hover {
            background: var(--bg-color);
            color: var(--primary-color);
        }

        .user-popup-menu li a i {
            width: 18px;
            text-align: center;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 80px;
            padding: 0px;
            flex: 1;
            transition: var(--transition);

          
            padding-right: 50px
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .menu-link .tooltip {
            visibility: hidden;
            width: auto;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 12px;
            position: absolute;
            z-index: 1;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 15px;
            opacity: 0;
            transition: opacity 0.3s;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar.collapsed .menu-link .tooltip::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent rgba(0, 0, 0, 0.8) transparent transparent;
        }

        .sidebar.collapsed .menu-link:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        /* Content Card */
        .content-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .welcome-text {
            font-size: 18px;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            color: var(--text-light);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content,
            .main-header {
                margin-left: 0;
            }

            .page-title {
                font-size: 20px;
            }
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
                <a href="#" class="menu-link active" data-page="Dashboard" data-breadcrumb="Home > Dashboard">
                    <i class="fas fa-home"></i>
                    <span class="menu-link-text">Dashboard</span>
                    <span class="tooltip">Dashboard</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="technicien" class="menu-link" data-page="Techniciens" data-breadcrumb="Home > Gestion > Techniciens">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span class="menu-link-text">Technicians</span>
                    <span class="tooltip">Technicians</span>
                </a>
                <a href="employee" class="menu-link" data-page="Customers" data-breadcrumb="Home > Gestion > Customers">
                    <i class="fa-solid fa-users"></i>
                    <span class="menu-link-text">Customers</span>
                    <span class="tooltip">Customers</span>
                </a>
                <a href="experts" class="menu-link" data-page="Experts" data-breadcrumb="Home > Gestion > Experts">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="menu-link-text">Experts</span>
                    <span class="tooltip">Experts</span>
                </a>
                <a href="entrepriseContractante" class="menu-link" data-page="Companies" data-breadcrumb="Home > Gestion > Companies">
                    <i class="fa-solid fa-building"></i>
                    <span class="menu-link-text">Companies</span>
                    <span class="tooltip">Companies</span>
                </a>
                <a href="atelier" class="menu-link" data-page="Workshop" data-breadcrumb="Home > Gestion > Workshop">
                    <i class="fa-solid fa-tools"></i>
                    <span class="menu-link-text">Workshop</span>
                    <span class="tooltip">Workshop</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Inventory</div>
                <a href="catalogues" class="menu-link" data-page="Catalogue" data-breadcrumb="Home > Inventory > Catalogue">
                    <i class="fa-solid fa-book-open"></i>
                    <span class="menu-link-text">Catalogs</span>
                    <span class="tooltip">Catalogs</span>
                </a>
                <a href="categorie" class="menu-link" data-page="Categories" data-breadcrumb="Home > Inventory > Categories">
                    <i class="fa-solid fa-tags"></i>
                    <span class="menu-link-text">Categories</span>
                    <span class="tooltip">Categories</span>
                </a>
                <a href="camions" class="menu-link" data-page="Vehicles" data-breadcrumb="Home > Inventory > Vehicles">
                    <i class="fa-solid fa-truck"></i>
                    <span class="menu-link-text">Vehicles</span>
                    <span class="tooltip">Vehicles</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Operations</div>
                <a href="statistiques" class="menu-link" data-page="Statistics" data-breadcrumb="Home > Operations > Statistics">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="menu-link-text">Statistics</span>
                    <span class="tooltip">Statistics</span>
                </a>
                <a href="{{ route('tickets.index') }}" class="menu-link" data-page="Assistance Ticket" data-breadcrumb="Home > Operations > Assistance">
                    <i class="fa-solid fa-headset"></i>
                    <span class="menu-link-text">Assistance Ticket</span>
                    <span class="tooltip">Assistance Ticket</span>
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile" id="sidebar-user-profile">
                <div class="user-profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-profile-info">
                    @auth('web')
                    <div class="user-profile-name">
                        {{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}
                    </div>
                    <div class="user-profile-role">Administrator</div>
                    @else
                    <div class="user-profile-name">Invité</div>
                    <div class="user-profile-role">Guest</div>
                    @endauth
                </div>
                <div class="user-profile-dropdown">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header class="main-header">
        <div class="header-left">
            <button class="toggle-sidebar" id="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="page-title" id="page-title">Dashboard</h1>
                <div class="page-breadcrumb" id="page-breadcrumb">
                    <span class="breadcrumb-item">Home</span>
                    <span class="breadcrumb-separator">></span>
                    <span class="breadcrumb-item active">Dashboard</span>
                </div>
            </div>
        </div>

        <div class="header-right">
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

            <div class="user-info" id="user-info-trigger">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <!-- User info popup -->
            <div class="user-popup" id="user-popup">
                <div class="user-popup-info">
                    <div class="popup-user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    @auth('web')
                    <div class="popup-user-name">
                        {{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}
                    </div>
                    <div class="popup-user-email">
                        {{ Auth::guard('web')->user()->email }}
                    </div>
                    @else
                    <div class="popup-user-name">Invité</div>
                    <div class="popup-user-email">guest@example.com</div>
                    @endauth
                </div>
                <ul class="user-popup-menu">
                    <li><a href="{{ route('profile.editAdmin') }}"><i class="fas fa-user-cog"></i> Profile</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="#" id="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to update page title and breadcrumb based on current URL
            function updatePageInfo() {
                const currentPath = window.location.pathname;
                const pageTitle = document.getElementById('page-title');
                const pageBreadcrumb = document.getElementById('page-breadcrumb');
                const menuLinks = document.querySelectorAll('.menu-link');

                // Define route mappings
                const routeMappings = {
                    '/': { title: 'Dashboard', breadcrumb: 'Home > Dashboard' },
                    '/technicien': { title: 'Technicians', breadcrumb: 'Home > Gestion > Technicians' },
                    '/employee': { title: 'Customers', breadcrumb: 'Home > Gestion > Customers' },
                    '/experts': { title: 'Experts', breadcrumb: 'Home > Gestion > Experts' },
                    '/entrepriseContractante': { title: 'Companies', breadcrumb: 'Home > Gestion > Companies' },
                    '/atelier': { title: 'Workshop', breadcrumb: 'Home > Gestion > Workshop' },
                    '/catalogues': { title: 'Catalogs', breadcrumb: 'Home > Inventory > Catalogs' },
                    '/categorie': { title: 'Categories', breadcrumb: 'Home > Inventory > Categories' },
                    '/camions': { title: 'Vehicles', breadcrumb: 'Home > Inventory > Vehicles' },
                    '/statistiques': { title: 'Statistics', breadcrumb: 'Home > Operations > Statistics' }
                };

                // Handle tickets route (could be different format)
                if (currentPath.includes('tickets')) {
                    routeMappings[currentPath] = { title: 'Assistance Ticket', breadcrumb: 'Home > Operations > Assistance' };
                }

                // Find matching route
                let matchedRoute = null;
                for (const [route, info] of Object.entries(routeMappings)) {
                    if (currentPath === route || currentPath.endsWith(route)) {
                        matchedRoute = info;
                        break;
                    }
                }

                // Update page title and breadcrumb
                if (matchedRoute) {
                    pageTitle.textContent = matchedRoute.title;

                    const breadcrumbParts = matchedRoute.breadcrumb.split(' > ');
                    let breadcrumbHTML = '';

                    breadcrumbParts.forEach((part, index) => {
                        if (index === breadcrumbParts.length - 1) {
                            breadcrumbHTML += `<span class="breadcrumb-item active">${part}</span>`;
                        } else {
                            breadcrumbHTML += `<span class="breadcrumb-item">${part}</span>`;
                            if (index < breadcrumbParts.length - 1) {
                                breadcrumbHTML += `<span class="breadcrumb-separator">></span>`;
                            }
                        }
                    });

                    pageBreadcrumb.innerHTML = breadcrumbHTML;

                    // Update active menu item
                    menuLinks.forEach(link => {
                        link.classList.remove('active');
                        const linkHref = link.getAttribute('href');

                        if (linkHref === currentPath ||
                            (currentPath === '/' && linkHref === '#') ||
                            (linkHref !== '#' && currentPath.includes(linkHref))) {
                            link.classList.add('active');
                        }
                    });
                }
            }

            // Call on page load
            updatePageInfo();

            // Toggle sidebar
            const toggleSidebar = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');

                // Change icon based on state
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-indent');
                } else {
                    icon.classList.remove('fa-indent');
                    icon.classList.add('fa-bars');
                }
            });

            // Active menu item and page title update
            const menuLinks = document.querySelectorAll(".menu-link");
            const pageTitle = document.getElementById('page-title');
            const pageBreadcrumb = document.getElementById('page-breadcrumb');

            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Only prevent default for Dashboard link (href="#")
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();

                        // Remove active class from all links
                        menuLinks.forEach(l => l.classList.remove('active'));

                        // Add active class to clicked link
                        this.classList.add('active');

                        // Update page title and breadcrumb for dashboard only
                        const pageNameAttr = this.getAttribute('data-page');
                        const breadcrumbAttr = this.getAttribute('data-breadcrumb');

                        if (pageNameAttr) {
                            pageTitle.textContent = pageNameAttr;
                        }

                        if (breadcrumbAttr) {
                            const breadcrumbParts = breadcrumbAttr.split(' > ');
                            let breadcrumbHTML = '';

                            breadcrumbParts.forEach((part, index) => {
                                if (index === breadcrumbParts.length - 1) {
                                    breadcrumbHTML += `<span class="breadcrumb-item active">${part}</span>`;
                                } else {
                                    breadcrumbHTML += `<span class="breadcrumb-item">${part}</span>`;
                                    if (index < breadcrumbParts.length - 1) {
                                        breadcrumbHTML += `<span class="breadcrumb-separator">></span>`;
                                    }
                                }
                            });

                            pageBreadcrumb.innerHTML = breadcrumbHTML;
                        }
                    }
                    // For all other links with actual routes, let them navigate normally
                });
            });

            // User popup toggle
            const userInfoTrigger = document.getElementById('user-info-trigger');
            const userPopup = document.getElementById('user-popup');

            userInfoTrigger.addEventListener('click', function(e) {
                e.stopPropagation();
                userPopup.classList.toggle('show');
            });

            // Close popup when clicking outside
            document.addEventListener('click', function() {
                userPopup.classList.remove('show');
            });

            // Prevent popup from closing when clicking inside it
            userPopup.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Logout functionality
            document.getElementById("logout-button").addEventListener("click", function(event) {
                event.preventDefault();
                document.getElementById("logout-form").submit();
            });

            // Mobile responsive
            function handleResize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('mobile');
                } else {
                    sidebar.classList.remove('mobile');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Call on initial load

            // Add smooth scrolling to sidebar menu
            const sidebarMenu = document.querySelector('.sidebar-menu');
            let isScrolling = false;

            sidebarMenu.addEventListener('scroll', function() {
                if (!isScrolling) {
                    window.requestAnimationFrame(function() {
                        // Add any scroll-based animations here
                        isScrolling = false;
                    });
                    isScrolling = true;
                }
            });

            // Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Toggle sidebar with Ctrl+B
                if (e.ctrlKey && e.key === 'b') {
                    e.preventDefault();
                    sidebar.classList.toggle('collapsed');
                }

                // Close user popup with Escape
                if (e.key === 'Escape') {
                    userPopup.classList.remove('show');
                }
            });

            // Add loading states for menu items (only for dashboard)
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Only add loading state for dashboard link
                    if (this.getAttribute('href') === '#') {
                        const linkText = this.querySelector('.menu-link-text');
                        if (linkText) {
                            const originalText = linkText.textContent;
                            linkText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

                            // Simulate loading
                            setTimeout(() => {
                                linkText.textContent = originalText;
                            }, 800);
                        }
                    }
                });
            });

            // Add notification animations
            const notificationBadges = document.querySelectorAll('.notification-badge');
            notificationBadges.forEach(badge => {
                setInterval(() => {
                    badge.style.animation = 'pulse 0.5s ease-in-out';
                    setTimeout(() => {
                        badge.style.animation = '';
                    }, 500);
                }, 3000);
            });
        });

        // CSS Animation for pulse effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }

            .mobile {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .mobile.mobile-open {
                transform: translateX(0);
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
