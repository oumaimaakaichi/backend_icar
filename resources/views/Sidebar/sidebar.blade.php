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
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --text-color: #2b2d42;
            --text-light: #8d99ae;
            --bg-color: #f8f9fa;
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
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
            padding: 12px 0;
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
            padding: 25px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .sidebar.collapsed .sidebar-logo-container {
            justify-content: center;
            padding: 25px 0;
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 12px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .sidebar-logo-text {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 15px;
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
            transition: var(--transition);
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
            white-space: nowrap;
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
            background-color: rgba(67, 97, 238, 0.1);
        }

        .user-profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: var(--primary-color);
            font-weight: bold;
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
        }

        .user-profile-role {
            font-size: 12px;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-profile-dropdown {
            color: var(--text-light);
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
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transition: var(--transition);
        }

        .sidebar.collapsed ~ .main-header {
            left: var(--sidebar-collapsed-width);
        }

        .toggle-sidebar {
            font-size: 20px;
            color: var(--text-color);
            cursor: pointer;
            transition: var(--transition);
            padding: 5px;
            border-radius: 50%;
        }

        .toggle-sidebar:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
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
        }

        .header-icon:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: transparent;
            font-size: 20px,
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: bold;
            transition: var(--transition);
        }

        .user-avatar:hover {
            transform: scale(1.05);
        }

        /* User info popup */
        .user-popup {
            position: absolute;
            top: 70px;
            right: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            width: 200px;
            z-index: 1000;
            display: none;
        }

        .user-popup.show {
            display: block;
        }

        .user-popup::before {
            content: '';
            position: absolute;
            top: -10px;
            right: 15px;
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
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
        }

        .popup-user-name {
            font-weight: 600;
            color: var(--text-color);
            margin-top: 8px;
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
            padding: 8px 0;
        }

        .user-popup-menu li a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: color 0.3s;
        }

        .user-popup-menu li a:hover {
            color: var(--primary-color);
        }

        .user-popup-menu li a i {
            width: 18px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 50px;
            padding: 10px;
            flex: 1;
            transition: var(--transition);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .menu-link .tooltip {
            visibility: hidden;
            width: auto;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px 10px;
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
        }

        .sidebar.collapsed .menu-link .tooltip::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            margin-top: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent #333 transparent transparent;
        }

        .sidebar.collapsed .menu-link:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo-container">
            <img  src="{{ asset('images/avatar.png') }}"  alt="Logo" class="sidebar-logo">
            <span class="sidebar-logo-text">AdminPro</span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="#" class="menu-link active">
                    <i class="fas fa-home"></i>
                    <span class="menu-link-text">Dashboard</span>
                    <span class="tooltip">Dashboard</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="technicien" class="menu-link">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span class="menu-link-text">Technicians</span>
                    <span class="tooltip">Technicians</span>
                </a>
                <a href="employee" class="menu-link">
                    <i class="fa-solid fa-users"></i>
                    <span class="menu-link-text">Customers</span>
                    <span class="tooltip">Customers</span>
                </a>
                <a href="experts" class="menu-link">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="menu-link-text">Experts</span>
                    <span class="tooltip">Experts</span>
                </a>
                <a href="entrepriseContractante" class="menu-link">
                    <i class="fa-solid fa-building"></i>
                    <span class="menu-link-text">Companies</span>
                    <span class="tooltip">Companies</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Inventory</div>
                <a href="catalogues" class="menu-link">
                    <i class="fa-solid fa-book-open"></i>
                    <span class="menu-link-text">Catalogue</span>
                    <span class="tooltip">Catalogue</span>
                </a>
                <a href="categorie" class="menu-link">
                    <i class="fa-solid fa-tags"></i>
                    <span class="menu-link-text">Categories</span>
                    <span class="tooltip">Categories</span>
                </a>
                <a href="camions" class="menu-link">
                    <i class="fa-solid fa-truck"></i>
                    <span class="menu-link-text">Vehicles</span>
                    <span class="tooltip">Vehicles</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Operations</div>
                <a href="atelier" class="menu-link">
                    <i class="fa-solid fa-tools"></i>
                    <span class="menu-link-text">Workshop</span>
                    <span class="tooltip">Workshop</span>
                </a>
                <a href="statistiques" class="menu-link">
                    <i class="fa-solid fa-chart-line"></i>
                    <span class="menu-link-text">Statistics</span>
                    <span class="tooltip">Statistics</span>
                </a>
                <a href="points" class="menu-link">
                    <i class="fa-solid fa-gem"></i>
                    <span class="menu-link-text">Loyalty Points</span>
                    <span class="tooltip">Loyalty Points</span>
                </a>
            </div>
        </div>
<div class="sidebar-footer">
            <div class="user-profile" id="sidebar-user-profile">


                <div class="user-dropdown">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Header Section -->
    <header class="main-header">
        <div class="toggle-sidebar" id="toggle-sidebar">
            <i class="fas fa-bars"></i>
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
               <i class="fas fa-user" style="font-size: 20px; color: rgb(150, 148, 148); margin-top:6px;"></i>

            </div>
        </div>

            <!-- User info popup -->
            <div class="user-popup" id="user-popup">
            <div class="user-popup-info">

                @auth('web')
                <div class="popup-user-name">
                    {{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}
                </div>
                <div class="popup-user-email">
                    {{ Auth::guard('web')->user()->email }}
                </div>
                @else
                <div class="popup-user-name">Invité</div>
                @endauth
            </div>
            <ul class="user-popup-menu">
                <li><a href="{{ route('profile.editAdmin') }}"><i class="fas fa-user-cog"></i> Profile</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="#" id="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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

            // Active menu item
            const menuLinks = document.querySelectorAll(".menu-link");

            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    menuLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
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
        });
    </script>
     <script>
        document.getElementById("logout-button").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("logout-form").submit();
        });
    </script>
</body>
</html>
