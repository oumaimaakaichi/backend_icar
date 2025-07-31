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
            background: linear-gradient(135deg, white, white);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: var(--transition);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-header {
            padding: 25px 10px;
        }

        .sidebar.collapsed .sidebar-logo {
            width: 40px;
            height: 40px;
            margin: 5px auto;
        }

        .sidebar.collapsed .sidebar-title,
        .sidebar.collapsed .menu-section-title,
        .sidebar.collapsed .menu-link span {
            display: none;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .menu-link i {
            margin-right: 0;
            font-size: 18px;
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 20px 10px;
        }

        .sidebar.collapsed #logout-button {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed #logout-button i {
            margin-right: 0;
        }

        .sidebar.collapsed #logout-button span {
            display: none;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
        }

        .toggle-sidebar {
            position: absolute;
            right: -12px;
            top: 10%;
            transform: translateY(-50%);
            background: white;
            border: 2px solid #eee;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1001;
        }

        .toggle-sidebar i {
            font-size: 12px;
            transition: var(--transition);
        }

        .sidebar.collapsed .toggle-sidebar i {
            transform: rotate(180deg);
        }

        .sidebar-logo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin: 5px auto 15px;
            display: block;
            border: 3px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
        }

        .sidebar-title {
            color: black;
            font-weight: 600;
            font-size: 1.2rem;
            margin: 0;
            transition: var(--transition);
        }

        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px 10px;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(63, 100, 232, 0.5);
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
            color: rgba(0, 0, 0, 0.8);
            text-decoration: none;
            margin-bottom: 5px;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            overflow: hidden;
        }

        .menu-link i {
            width: 25px;
            text-align: center;
            margin-right: 12px;
            font-size: 16px;
            transition: var(--transition);
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: black;
            transform: translateX(5px);
        }

        .menu-link:hover i {
            color: var(--primary-color);
        }

        .menu-link.active {
            background: linear-gradient(90deg, rgba(67, 97, 238, 0.2), transparent);
            color: black;
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
        }

        .menu-link.active i {
            color: var(--primary-color);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        #logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            background: rgba(140, 138, 138, 0.1);
            color: #090909;
            border-radius: var(--border-radius);
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
        }

        #logout-button:hover {
            background: rgba(231, 76, 60, 0.2);
            color: #c0392b;
        }

        #logout-button i {
            margin-right: 10px;
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

        body.sidebar-collapsed .main-header {
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
        }

        .notification-icon:hover {
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e74c3c;
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
            gap: 15px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            font-size: 18px;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-color);
        }

        /* User Popup Styles */
        .user-popup {
            position: absolute;
            top: 60px;
            right: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            width: 250px;
            left:1250px;
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
            margin-top: 70px;
            padding: 0px;
            flex: 1;
            transition: var(--transition);
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Animation for menu items */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .menu-link {
            animation: fadeIn 0.4s ease forwards;
        }

        .menu-link:nth-child(1) { animation-delay: 0.1s; }
        .menu-link:nth-child(2) { animation-delay: 0.2s; }
        .menu-link:nth-child(3) { animation-delay: 0.3s; }
        .menu-link:nth-child(4) { animation-delay: 0.4s; }
        .menu-link:nth-child(5) { animation-delay: 0.5s; }
        .menu-link:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
                        <div class="toggle-sidebar" id="toggle-sidebar">
                <i class="fas fa-chevron-left"></i>
            </div>
            <img src="{{ asset('images/5.jpg') }}" alt="Logo" class="sidebar-logo">
            <h3 class="sidebar-title">Maintenance System</h3>

        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="{{ route('atelierss.statistiques') }}" class="menu-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span>
                </a>


                 <a href="{{ route('ateliers.choice') }}" class="menu-link">
                    <i class="fas fa-tools"></i>
                    <span>Current Requests</span>
                </a>
                <a href="ticket_maintenance" class="menu-link">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Maintenance Tickets</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="{{ route('atelierss.availability') }}" class="menu-link">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Availability</span>
                </a>
                <a href="technicienAtelier" class="menu-link">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Technicians</span>
                </a>
                <a href="employeeAtelier" class="menu-link">
                    <i class="fa-solid fa-user"></i>
                    <span>Users Management</span>
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
        <div></div> <!-- Empty div for spacing -->

        <div class="header-right">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>

            <div class="user-info" id="user-info-trigger">
                <div class="user-avatar">
                    <i class="fas fa-user" style="font-size: 20px; color: rgb(150, 148, 148); margin-top:0px;"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- User Popup -->
    <div class="user-popup" id="user-popup">
        <div class="user-popup-info">
            @auth('atelier')
            <div class="popup-user-name">
                {{ Auth::guard('atelier')->user()->nom_commercial }}
            </div>
            <div class="popup-user-email">
                {{ Auth::guard('atelier')->user()->email }}
            </div>
            <div class="popup-user-email">
                {{ Auth::guard('atelier')->user()->ville }}
            </div>
            @else
            <div class="popup-user-name">Invité</div>
            @endauth
        </div>
        <ul class="user-popup-menu">
            <li><a href="{{ route('atelier.profile.show') }}"><i class="fas fa-user-cog"></i> Profile</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="#" id="popup-logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

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
