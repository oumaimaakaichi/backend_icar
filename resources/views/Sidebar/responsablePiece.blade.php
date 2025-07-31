<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sidebar Moderne avec Animation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
      <meta name="csrf-token" content="{{ csrf_token() }}">
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
            position: relative;
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

        /* User Popup Styles */
        .user-popup {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            min-width: 250px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1001;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            margin-top: 10px;
        }

        .user-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-popup::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 16px;
            height: 16px;
            background: white;
            transform: rotate(45deg);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-popup-header {
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .popup-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin: 0 auto 10px;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .popup-user-name {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 5px;
        }

        .popup-user-email {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .user-popup-menu {
            padding: 10px 0;
        }

        .popup-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
        }

        .popup-menu-item:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .popup-menu-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
        }
        /* Notification Dropdown Styles */
.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 350px;
    max-height: 400px;
    overflow-y: auto;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: var(--transition);
    z-index: 1001;
    margin-top: 10px;
}

.notification-icon:hover .notification-dropdown,
.notification-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.notification-dropdown::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 15px;
    width: 16px;
    height: 16px;
    background: white;
    transform: rotate(45deg);
    border-left: 1px solid rgba(0, 0, 0, 0.05);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.notification-header {
    padding: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-header h5 {
    margin: 0;
    font-size: 1rem;
    color: var(--text-color);
}

.notification-header small {
    color: var(--text-light);
    font-size: 0.8rem;
}

.notification-list {
    padding: 0;
}

.notification-item {
    padding: 12px 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    display: flex;
    align-items: flex-start;
}

.notification-item.unread {
    background: rgba(67, 97, 238, 0.05);
}

.notification-item:hover {
    background: rgba(67, 97, 238, 0.1);
}

.notification-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: rgba(67, 97, 238, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    color: var(--primary-color);
    flex-shrink: 0;
}

.notification-content {
    flex-grow: 1;
}

.notification-message {
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: var(--text-color);
}

.notification-time {
    font-size: 0.75rem;
    color: var(--text-light);
}

.notification-empty {
    padding: 20px;
    text-align: center;
    color: var(--text-light);
    font-size: 0.9rem;
}

.notification-footer {
    padding: 10px 15px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    text-align: center;
}

.notification-footer a {
    color: var(--primary-color);
    font-size: 0.8rem;
    text-decoration: none;
    transition: var(--transition);
}

.notification-footer a:hover {
    color: var(--secondary-color);
    text-decoration: underline;
}

        .popup-menu-item.logout {
            color: #e74c3c;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 5px;
        }

        .popup-menu-item.logout:hover {
            background: rgba(231, 76, 60, 0.1);
            color: #c0392b;
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
        .tooltip {
            position: relative;
        }
.notification-badge {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 3px 7px;
    font-size: 9px;
    position: absolute;
    top: 0;
    right: 0;
    display: none; /* caché par défaut */
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
                <a href="{{ route('profile.editResponsable') }}" class="menu-link" data-tooltip="Paramètres">
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
           <div class="notification-icon" id="notification-icon">
    <i class="fas fa-bell"></i>
    <span class="notification-badge" id="notification-badge">0</span>

    <!-- Dropdown des notifications -->
    <div class="notification-dropdown" id="notification-dropdown">
        <div class="notification-header">
            <h5>Notifications</h5>
            <small id="notification-count">0 nouvelles</small>
        </div>
        <div class="notification-list" id="notification-list">
            <!-- Les notifications seront chargées ici dynamiquement -->
            <div class="notification-empty">Aucune notification</div>
        </div>
        <div class="notification-footer">
            <a href="#" id="mark-all-read">Marquer tout comme lu</a>
        </div>
    </div>
</div>
            <div class="user-info" id="user-info-trigger">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                @auth('web')
                    <span class="user-name">{{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}</span>
                @else
                    <span class="user-name">Invité</span>
                @endauth

                <!-- User Popup -->
                <div class="user-popup" id="user-popup">
                    <div class="user-popup-header">
                        <div class="popup-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        @auth('web')
                            <div class="popup-user-name">{{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}</div>
                            <div class="popup-user-email">{{ Auth::guard('web')->user()->email ?? 'Email non renseigné' }}</div>
                        @else
                            <div class="popup-user-name">Invité</div>
                            <div class="popup-user-email">Non connecté</div>
                        @endauth
                    </div>
                    <div class="user-popup-menu">
                        <a href="{{ route('profile.editResponsable') }}" class="popup-menu-item">
                            <i class="fas fa-user-circle"></i>
                            <span>Mon Profil</span>
                        </a>
                        <a href="#" class="popup-menu-item">
                            <i class="fas fa-cog"></i>
                            <span>Paramètres</span>
                        </a>
                        <a href="#" class="popup-menu-item logout" id="popup-logout-button">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Toggle sidebar
            const toggleBtn = document.getElementById('toggleBtn');
            const sidebar = document.getElementById('sidebar');

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');

                // Store state in localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });

            // Check localStorage for saved state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }

            // Active menu item
            const menuLinks = document.querySelectorAll(".menu-link");
            const currentURL = window.location.pathname;

            menuLinks.forEach(link => {
                if (link.getAttribute("href") === currentURL) {
                    link.classList.add("active");
                }

                link.addEventListener('click', function(e) {
                    e.preventDefault();
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
                    if (!userPopup.contains(e.target) && !userInfoTrigger.contains(e.target)) {
                        userPopup.classList.remove('show');
                    }
                });

                // Prevent popup from closing when clicking inside it
                userPopup.addEventListener('click', function(e) {
                    e.stopPropagation();
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

            // Sidebar logout button
            document.getElementById("logout-button").addEventListener("click", function(event) {
                event.preventDefault();
                document.getElementById("logout-form").submit();
            });
        });
    </script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
 <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0"></script>

    <script>
       document.addEventListener("DOMContentLoaded", function() {
    // Initialisation Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true,
        forceTLS: true
    });

    // Abonnement au canal
    const channel = pusher.subscribe('notifications.{{ Auth::id() }}');

    // Écoute de l'événement
    channel.bind('notification.sent', function(data) {
        console.log('Notification reçue:', data);

        // Mettre à jour le badge
        const badge = document.getElementById('notification-badge');
        if (badge) {
            const currentCount = parseInt(badge.textContent) || 0;
            badge.textContent = currentCount + 1;
            badge.style.display = 'flex';
        }

        // Afficher un toast
        Toastify({
            text: data.message,
            duration: 5000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #4361ee, #3f37c9)",
            onClick: function() {
                if (data.data && data.data.url) {
                    window.location.href = data.data.url;
                }
            }
        }).showToast();

        // Recharger les notifications si le dropdown est ouvert
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown && dropdown.classList.contains('show')) {
            loadNotifications();
        }
    });

    // Fonction pour charger les notifications
function loadNotifications() {
    fetch('/api/notifications')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            // 🔹 Mettre à jour la liste
            updateNotificationList(data);

            // 🔹 Mettre à jour le badge avec le nombre de notifications
            const badge = document.getElementById('notification-badge');
            if (badge) {
                badge.textContent = data.length; // nombre de notifications reçues
                badge.style.display = data.length > 0 ? 'inline-block' : 'none';
            }
        })
        .catch(error => {
            console.error('Erreur complète:', error);

            const list = document.getElementById('notification-list');
            if (list) {
                list.innerHTML = '<div class="notification-empty">Erreur de chargement</div>';
            }

            // En cas d'erreur, cacher le badge
            const badge = document.getElementById('notification-badge');
            if (badge) {
                badge.style.display = 'none';
            }
        });
}


    // Fonction pour mettre à jour la liste
  function updateNotificationList(notifications) {
    const list = document.getElementById('notification-list');
    if (!list) {
        console.error('Element notification-list non trouvé');
        return;
    }

    if (!Array.isArray(notifications) || notifications.length === 0) {
        list.innerHTML = '<div class="notification-empty">Aucune notification</div>';
        return;
    }

    list.innerHTML = notifications.map(notif => {
        // Gestion des données sérialisées JSON
        const message = notif.message || 'Notification sans message';
        const type = notif.type || 'default';
        const createdAt = notif.created_at ? formatDate(notif.created_at) : 'Date inconnue';
        const isUnread = !notif.read_at;

        return `
            <div class="notification-item ${isUnread ? 'unread' : ''}" data-id="${notif.id}">
                <div class="notification-icon">
                    <i class="fas ${getNotificationIcon(type)}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-message">${message}</div>
                    <div class="notification-time">${createdAt}</div>
                </div>
            </div>
        `;
    }).join('');

    // Ajoutez cette fonction helper
    function getNotificationIcon(type) {
        const icons = {
            'new_demande': 'fa-tools',
            'default': 'fa-bell'
        };
        return icons[type] || icons['default'];
    }

    // Gestion des clics
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-id');
            markAsRead(notificationId);

            // Redirection si URL disponible
            const notification = notifications.find(n => n.id == notificationId);
            if (notification?.data?.url) {
                window.location.href = notification.data.url;
            }
        });
    });
}

    // Fonction pour formater la date
    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // différence en secondes

        if (diff < 60) return 'À l\'instant';
        if (diff < 3600) return `Il y a ${Math.floor(diff / 60)} min`;
        if (diff < 86400) return `Il y a ${Math.floor(diff / 3600)} h`;
        return date.toLocaleDateString('fr-FR');
    }

    // Fonction pour marquer comme lu
    function markAsRead(notificationId) {
        fetch(`/api/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(() => loadNotifications())
        .catch(error => console.error('Error:', error));
    }

    // Chargement initial
    loadNotifications();
});




    </script>

</body>
</html>



