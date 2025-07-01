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
            padding: 25px 20px;
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

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            color: var(--text-light);
            font-size: 1.2rem;
            transition: var(--transition);
            margin-left: 1120px;
        }

        .notification-icon:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            margin-left: 10px;
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
            right: 30px;
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
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="sidebar-toggle" id="sidebar-toggle">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="sidebar-header">
            <div class="sidebar-logo">ES</div>
            <h3 class="sidebar-title">Expert Space</h3>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="{{ route('demandes.statistics') }}" class="menu-link">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
               <!--<a href="{{ route('expert.demande_maintenance') }}" class="menu-link">
                    <i class="fas fa-tools"></i>
                    <span>Requests</span>
                </a>-->
                <a href="{{ route('expert.request_choice') }}" class="menu-link">
                    <i class="fas fa-tools"></i>
                    <span>Requests</span>
                </a>
                <a href="{{ route('expert.demande_autorisation') }}" class="menu-link">
                    <i class="fas fa-key"></i>
                    <span>Authorization</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="#" class="menu-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="#" class="menu-link">
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Header Section -->
    <header class="main-header">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" id="mobile-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="header-right">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>

            <div class="user-info" id="user-info-trigger">
           <div class="user-avatar">
  <i class="fas fa-user" style="font-size: 20px;color:gray"></i>
</div>


            </div>
        </div>
    </header>

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
            <li><a href="#" id="popup-logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileToggle = document.getElementById('mobile-toggle');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                    } else {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-left');
                    }
                });
            }

            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
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

                    // Close sidebar on mobile after clicking a link
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                    }
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
                if (window.innerWidth < 992 && !sidebar.contains(e.target) && e.target !== mobileToggle) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
