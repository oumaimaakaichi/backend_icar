<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expert sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --primary-color: #6366f1;
            --primary-light: #818cf8;
            --secondary-color: #4f46e5;
            --text-color: #1e293b;
            --text-light: #64748b;
            --bg-color: #f8fafc;
            --sidebar-bg: #ffffff;
            --border-radius: 10px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Modern Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-md);
            z-index: 1000;
            transition: var(--transition);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-title,
        .sidebar.collapsed .menu-link span,
        .sidebar.collapsed .menu-section-title,
        .sidebar.collapsed #logout-button span {
            display: none;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 10px;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .menu-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 15px 10px;
        }

        .sidebar-header {
            padding: 25px 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: var(--transition);
        }

        .sidebar-logo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-title {
            color: var(--text-color);
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0;
            white-space: nowrap;
            transition: var(--transition);
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px 10px;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            color: var(--text-light);
            text-decoration: none;
            margin-bottom: 5px;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .menu-link i {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1rem;
            transition: var(--transition);
            color: var(--text-light);
        }

        .menu-link:hover {
            background-color: rgba(99, 102, 241, 0.05);
            color: var(--primary-color);
            transform: translateX(3px);
        }

        .menu-link:hover i {
            color: var(--primary-color);
        }

        .menu-link.active {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            font-weight: 600;
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary-color);
            border-radius: 0 3px 3px 0;
        }

        .menu-link.active i {
            color: var(--primary-color);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        #logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            background: rgba(0, 0, 0, 0.03);
            color: var(--text-color);
            border-radius: var(--border-radius);
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        #logout-button:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        #logout-button i {
            margin-right: 10px;
            font-size: 1rem;
        }

        /* Toggle Button */
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: -12px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            cursor: pointer;
            z-index: 1001;
            border: none;
            color: var(--text-light);
            transition: var(--transition);
        }

        .sidebar-toggle:hover {
            color: var(--primary-color);
            transform: scale(1.1);
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
            box-shadow: var(--shadow-sm);
            z-index: 100;
            transition: var(--transition);
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
            font-size: 18px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            letter-spacing: -0.5px;
            margin-top: 0px
        }
        .page-titlee {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            letter-spacing: -0.5px;
            margin-top: 0px
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
            gap: 20px;
            position: relative;
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
            background-color: rgba(99, 102, 241, 0.05);
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: #ef4444;
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

        /* Notification Dropdown Styles */
        .notification-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 380px;
            z-index: 1000;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease-out;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .notification-dropdown.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .notification-dropdown::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
        }

        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .notification-header small {
            color: var(--text-light);
            font-size: 0.8rem;
        }

        .notification-list {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px 0;
        }

        .notification-item {
            padding: 12px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            cursor: pointer;
            transition: var(--transition);
        }

        .notification-item:hover {
            background-color: rgba(99, 102, 241, 0.03);
        }

        .notification-item.unread {
            background-color: rgba(99, 102, 241, 0.05);
            border-left: 3px solid var(--primary-color);
        }

        .notification-message {
            font-size: 0.9rem;
            color: var(--text-color);
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .notification-empty {
            padding: 30px 20px;
            text-align: center;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .notification-footer {
            padding: 12px 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .notification-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .notification-footer a:hover {
            text-decoration: underline;
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
            background-color: rgba(99, 102, 241, 0.05);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: "grey";
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
        }

        .user-info:hover .user-avatar {
            background-color: rgba(99, 102, 241, 0.2);
        }

        .user-name {
            font-weight: 500;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        /* User Popup Styles */
        .user-popup {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 15px 0;
            width: 250px;
            z-index: 1000;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease-out;
        }

        .user-popup.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .user-popup::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
        }

        .user-popup-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 20px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
        }

        .popup-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(99, 102, 241, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .popup-user-name {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 4px;
            text-align: center;
        }

        .popup-user-email {
            font-size: 12px;
            color: var(--text-light);
            text-align: center;
        }

        .user-popup-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user-popup-menu li {
            padding: 0;
        }

        .user-popup-menu li a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            padding: 10px 20px;
            transition: all 0.2s;
        }

        .user-popup-menu li a:hover {
            background-color: rgba(99, 102, 241, 0.05);
            color: var(--primary-color);
        }

        .user-popup-menu li a i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .user-popup-menu li a:hover i {
            color: var(--primary-color);
        }

        /* Animation for menu items */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .menu-link {
            animation: fadeIn 0.3s ease forwards;
            opacity: 0;
        }

        .menu-link:nth-child(1) { animation-delay: 0.1s; }
        .menu-link:nth-child(2) { animation-delay: 0.2s; }
        .menu-link:nth-child(3) { animation-delay: 0.3s; }
        .menu-link:nth-child(4) { animation-delay: 0.4s; }
        .menu-link:nth-child(5) { animation-delay: 0.5s; }
        .menu-link:nth-child(6) { animation-delay: 0.6s; }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content, .main-header {
                margin-left: 0;
            }

            .notification-dropdown {
                width: 320px;
                right: -50px;
            }

            .notification-dropdown::before {
                right: 70px;
            }
        }

        @media (max-width: 480px) {
            .notification-dropdown {
                width: 280px;
                right: -80px;
            }

            .notification-dropdown::before {
                right: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                @auth('web')
                    {{ strtoupper(substr(Auth::guard('web')->user()->nom, 0, 1)) }}
                    {{ strtoupper(substr(Auth::guard('web')->user()->prenom, 0, 1)) }}
                @else
                    ES
                @endauth
            </div>
            <h3 class="sidebar-title">Expert Space</h3>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="{{ route('demandes.statistics') }}" class="menu-link" data-page="Dashboard" data-breadcrumb="Home > Dashboard">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('expert.request_choice') }}" class="menu-link" data-page="Requests" data-breadcrumb="Home > Requests">
                    <i class="fas fa-tools"></i>
                    <span>Requests</span>
                </a>
                <a href="{{ route('expert.demande_autorisation') }}" class="menu-link" data-page="Authorization" data-breadcrumb="Home > Authorization">
                    <i class="fas fa-key"></i>
                    <span>Authorization</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="{{ route('expert.techniciens') }}" class="menu-link" data-page="Technician" data-breadcrumb="Home > Management > Technician">
                    <i class="fas fa-users"></i>
                    <span>Technician</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="menu-link" data-page="Settings" data-breadcrumb="Home > Management > Settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <button id="logout-button">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
            <form id="logout-form" action="{{ route('login') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Header Section -->
    <header class="main-header">
        <div class="header-left">
            <button class="toggle-sidebar" id="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="header-right">
            <!-- Notification Icon and Dropdown -->
            <div class="notification-icon" id="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge" id="notification-badge" style="display: none;">0</span>
            </div>

            <div class="notification-dropdown" id="notification-dropdown">
                <div class="notification-header">
                    <h5>Notifications</h5>
                    <small id="notification-count">0 nouvelles</small>
                </div>
                <div class="notification-list" id="notification-list">
                    <div class="notification-empty">Aucune notification</div>
                </div>
                <div class="notification-footer">
                    <a href="#" id="mark-all-read">Marquer tout comme lu</a>
                </div>
            </div>

            <!-- User Info -->
            <div class="user-info" id="user-info-trigger">
                <div class="user-avatar">
                    <i class="fas fa-user" style="font-size: 20px;color:rgb(105, 104, 104)"></i>
                </div>
            </div>

            <!-- User Popup -->
            <div class="user-popup" id="user-popup">
                <div class="user-popup-info">
                    <div class="popup-user-avatar">
                        <i class="fas fa-user" style="font-size: 20px;color:gray"></i>
                    </div>
                    @auth('web')
                    <div class="popup-user-name">
                        {{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}
                    </div>
                    <div class="popup-user-email">
                        {{ Auth::guard('web')->user()->email }}
                    </div>
                    @else
                    <div class="popup-user-name">Guest</div>
                    @endauth
                </div>
                <ul class="user-popup-menu">
                   <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                   <li><a href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Votre contenu principal ici -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const toggleSidebarBtn = document.getElementById('toggle-sidebar');

            if (toggleSidebarBtn) {
                toggleSidebarBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-indent');
                    } else {
                        icon.classList.remove('fa-indent');
                        icon.classList.add('fa-bars');
                    }
                });
            }

            // Notification functionality
            const notificationIcon = document.getElementById('notification-icon');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const notificationBadge = document.getElementById('notification-badge');

            if (notificationIcon && notificationDropdown) {
                notificationIcon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationDropdown.classList.toggle('show');
                    // Recharger les notifications quand on ouvre le dropdown
                    if (notificationDropdown.classList.contains('show')) {
                        loadNotifications();
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notificationDropdown.contains(e.target) && e.target !== notificationIcon && !notificationIcon.contains(e.target)) {
                        notificationDropdown.classList.remove('show');
                    }
                });
            }

            // User popup toggle
            const userInfoTrigger = document.getElementById('user-info-trigger');
            const userPopup = document.getElementById('user-popup');

            if (userInfoTrigger && userPopup) {
                userInfoTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userPopup.classList.toggle('show');
                    // Fermer les autres dropdowns
                    notificationDropdown.classList.remove('show');
                });

                // Close popup when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userPopup.contains(e.target) && e.target !== userInfoTrigger && !userInfoTrigger.contains(e.target)) {
                        userPopup.classList.remove('show');
                    }
                });
            }

            // Mark all as read
            const markAllReadBtn = document.getElementById('mark-all-read');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    markAllAsRead();
                });
            }

            // Load notifications function
            function loadNotifications() {
                fetch('/api/notifications')
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    const list = document.getElementById('notification-list');
                    const countElement = document.getElementById('notification-count');
                    const notifications = data.notifications || [];

                    if (notifications.length === 0) {
                        list.innerHTML = '<div class="notification-empty">Aucune notification</div>';
                        countElement.textContent = '0 nouvelles';
                    } else {
                        list.innerHTML = notifications.map(n => {
                            const message = n.data?.message || n.message || 'Nouvelle notification';
                            const time = formatDate(n.created_at);
                            const unreadClass = !n.read_at ? 'unread' : '';
                            return `
                                <div class="notification-item ${unreadClass}" data-id="${n.id}">
                                    <div class="notification-message">${message}</div>
                                    <div class="notification-time">${time}</div>
                                </div>
                            `;
                        }).join('');

                        const unreadCount = notifications.filter(n => !n.read_at).length;
                        countElement.textContent = `${unreadCount} nouvelle${unreadCount > 1 ? 's' : ''}`;
                    }

                    // Update badge
                    const unreadCount = data.unread_count || 0;
                    notificationBadge.textContent = unreadCount;
                    notificationBadge.style.display = unreadCount > 0 ? 'flex' : 'none';

                    // Add click events to mark as read
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const id = this.dataset.id;
                            markAsRead(id);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    const list = document.getElementById('notification-list');
                    list.innerHTML = '<div class="notification-empty">Erreur de chargement</div>';
                });
            }

            function markAsRead(id) {
                fetch(`/api/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (res.ok) {
                        loadNotifications();
                    }
                })
                .catch(error => console.error('Error marking as read:', error));
            }

            function markAllAsRead() {
                fetch('/api/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (res.ok) {
                        loadNotifications();
                    }
                })
                .catch(error => console.error('Error marking all as read:', error));
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diff = Math.floor((now - date)/1000);

                if (diff < 60) return "À l'instant";
                if (diff < 3600) return `Il y a ${Math.floor(diff/60)} min`;
                if (diff < 86400) return `Il y a ${Math.floor(diff/3600)} h`;
                if (diff < 604800) return `Il y a ${Math.floor(diff/86400)} j`;
                return date.toLocaleDateString('fr-FR');
            }

            // Pusher for real-time notifications
            try {
                const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
                    cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
                    forceTLS: true
                });

                const channel = pusher.subscribe('notifications.global');
                channel.bind('notification.sent', function(data) {
                    // Show toast notification
                    Toastify({
                        text: data.data?.message || data.message || "Nouvelle notification",
                        duration: 5000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #4361ee, #3f37c9)",
                        onClick: function() {
                            notificationDropdown.classList.add('show');
                            loadNotifications();
                        }
                    }).showToast();

                    // Reload notifications
                    loadNotifications();
                });
            } catch (error) {
                console.error('Pusher initialization error:', error);
            }

            // Initial load
            loadNotifications();

            // Auto-refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);

            // Active menu item
            const menuLinks = document.querySelectorAll(".menu-link");
            const currentURL = window.location.pathname;

            menuLinks.forEach(link => {
                if (link.getAttribute("href") === currentURL ||
                    (link.getAttribute("href") && currentURL.includes(link.getAttribute("href").replace(window.location.origin, '')))) {
                    link.classList.add("active");
                }

                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                    }

                    menuLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                    }
                });
            });

            // Logout button in sidebar
            const logoutButton = document.getElementById('logout-button');
            if (logoutButton) {
                logoutButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('logout-form').submit();
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992 && !sidebar.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
