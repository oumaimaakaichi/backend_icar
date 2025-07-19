<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sidebar Moderne avec Animation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --text-color: #2b2d42;
            --text-light: #8d99ae;
            --bg-color: #f8f9fa;
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: var(--transition);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: block;
            border: 3px solid rgba(67, 97, 238, 0.2);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            transition: var(--transition);
        }

        .sidebar.collapsed .sidebar-logo {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
        }

        .sidebar-title {
            color: var(--text-color);
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
            opacity: 1;
            transition: var(--transition);
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            font-size: 0.8rem;
        }

        .toggle-btn {
            position: absolute;
            top: 10px;
            bottom: 10px;
            right: 5px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(67, 97, 238, 0.3);
            transition: var(--transition);
            z-index: 1001;
        }

        .toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 20px rgba(67, 97, 238, 0.4);
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px 10px;
        }

        .menu-section {
            margin-bottom: 30px;
        }

        .menu-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-light);
            margin-bottom: 15px;
            padding-left: 15px;
            font-weight: 600;
            opacity: 1;
            transition: var(--transition);
        }

        .sidebar.collapsed .menu-section-title {
            opacity: 0;
            height: 0;
            margin-bottom: 0;
            overflow: hidden;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: var(--border-radius);
            color: var(--text-color);
            text-decoration: none;
            margin-bottom: 8px;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .menu-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent, rgba(67, 97, 238, 0.1));
            opacity: 0;
            transition: var(--transition);
        }

        .menu-link:hover::before {
            opacity: 1;
        }

        .menu-link i {
            width: 20px;
            text-align: center;
            margin-right: 15px;
            font-size: 18px;
            transition: var(--transition);
            z-index: 1;
            position: relative;
        }

        .menu-link span {
            opacity: 1;
            transition: var(--transition);
            white-space: nowrap;
            z-index: 1;
            position: relative;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 15px 10px;
        }

        .sidebar.collapsed .menu-link span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .menu-link i {
            margin-right: 0;
        }

        .menu-link:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .sidebar.collapsed .menu-link:hover {
            transform: translateX(0) scale(1.05);
        }

        .menu-link:hover i {
            color: var(--primary-color);
            transform: scale(1.2);
        }

        .menu-link.active {
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.15), rgba(67, 97, 238, 0.1));
            color: var(--primary-color);
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .menu-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            border-radius: 0 4px 4px 0;
        }

        .menu-link.active i {
            color: var(--primary-color);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        #logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            border-radius: var(--border-radius);
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        #logout-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(231, 76, 60, 0.1), transparent);
            transition: var(--transition);
        }

        #logout-button:hover::before {
            left: 100%;
        }

        #logout-button:hover {
            background: rgba(231, 76, 60, 0.2);
            color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        #logout-button i {
            margin-right: 10px;
            transition: var(--transition);
            z-index: 1;
            position: relative;
        }

        #logout-button span {
            opacity: 1;
            transition: var(--transition);
            white-space: nowrap;
            z-index: 1;
            position: relative;
        }

        .sidebar.collapsed #logout-button span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.collapsed #logout-button i {
            margin-right: 0;
        }

        /* Header Styles */
        .main-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transition: var(--transition);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar.collapsed ~ .main-header {
            left: var(--sidebar-collapsed-width);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            color: var(--text-light);
            font-size: 1.2rem;
            transition: var(--transition);
            padding: 8px;
            border-radius: 50%;
        }

        .notification-icon:hover {
            color: var(--primary-color);
            background: rgba(67, 97, 238, 0.1);
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .user-info:hover {
            background: rgba(67, 97, 238, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            box-shadow: 0 2px 10px rgba(67, 97, 238, 0.3);
        }

        .user-name {
            font-weight: 600;
            color: var(--text-color);
        }

        /* Main Content */
         .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            padding: 0px;
            flex: 1;
            transition: var(--transition);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Tooltip for collapsed sidebar */
        .tooltip {
            position: relative;
        }

        .sidebar.collapsed .menu-link {
            position: relative;
        }

        .sidebar.collapsed .menu-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: var(--transition);
            margin-left: 10px;
            z-index: 1000;
        }

        .sidebar.collapsed .menu-link:hover::after {
            opacity: 1;
        }

        /* Animation for menu items */
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

        .menu-link {
            animation: slideIn 0.4s ease forwards;
        }

        .menu-link:nth-child(1) { animation-delay: 0.1s; }
        .menu-link:nth-child(2) { animation-delay: 0.2s; }
        .menu-link:nth-child(3) { animation-delay: 0.3s; }
        .menu-link:nth-child(4) { animation-delay: 0.4s; }
        .menu-link:nth-child(5) { animation-delay: 0.5s; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-header {
                left: 0;
            }
        }

        /* Demo content */
        .demo-content {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .demo-content h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .demo-content p {
            color: var(--text-light);
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" id="toggleBtn">
                <i class="fas fa-bars"></i>
            </button>
            <img src="{{ asset('images/5.jpg') }}" alt="Logo" class="sidebar-logo">
            <h3 class="sidebar-title">Maintenance System</h3>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Navigation</div>
                <a href="#" class="menu-link active" data-tooltip="Dashboard">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="menu-link" data-tooltip="Demandes">
                    <i class="fas fa-screwdriver-wrench"></i>
                    <span>Demande de maintenance</span>
                </a>
                <a href="#" class="menu-link" data-tooltip="Requêtes">
                    <i class="fas fa-tools"></i>
                    <span>Requests</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Gestion</div>
                <a href="#" class="menu-link" data-tooltip="Utilisateurs">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="#" class="menu-link" data-tooltip="Rapports">
                    <i class="fas fa-file-alt"></i>
                    <span>Rapports</span>
                </a>
                <a href="#" class="menu-link" data-tooltip="Paramètres">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <a href="logoutA" id="logout-button">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Header Section -->
    <header class="main-header">
        <div></div>
        <div class="header-right">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                @auth('web')
                <span class="user-name">    {{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}</span>
                  @else
                <div class="popup-user-name">Invité</div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
     <main class="main-content">
        <!-- Your main content goes here -->
    </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Toggle sidebar
            const toggleSidebar = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                body.classList.toggle('sidebar-collapsed');

                // Store state in localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            // Check localStorage for saved state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                body.classList.add('sidebar-collapsed');
            }

            // Active menu item
            const menuLinks = document.querySelectorAll(".menu-link");
            const currentURL = window.location.pathname;

            menuLinks.forEach(link => {
                if (link.getAttribute("href") === currentURL) {
                    link.classList.add("active");
                }

                link.addEventListener('click', function() {
                    menuLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // User popup toggle
            const userInfoTrigger = document.getElementById('user-info-trigger');
            const userPopup = document.getElementById('user-popup');

            if (userInfoTrigger && userPopup) {
                userInfoTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userPopup.classList.toggle('show');
                });

                // Close popup when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userPopup.contains(e.target) && e.target !== userInfoTrigger) {
                        userPopup.classList.remove('show');
                    }
                });

                // Logout button in popup
                const popupLogoutButton = document.getElementById('popup-logout-button');
                const logoutForm = document.getElementById('logout-form');

                if (popupLogoutButton && logoutForm) {
                    popupLogoutButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        logoutForm.submit();
                    });
                }
            }
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
