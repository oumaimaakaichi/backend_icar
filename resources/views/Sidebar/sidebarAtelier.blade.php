<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --primary: #4f46e5;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            color: var(--gray-800);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Modern Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(145deg, var(--gray-50), var(--gray-50));
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            transition: var(--transition);
            border-right: 1px solid var(--gray-200);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(180deg, transparent, var(--primary), transparent);
            opacity: 0.3;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            position: relative;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1.5rem 0.5rem;
        }

        .toggle-sidebar {
            position: absolute;
            right: -15px;
            top: 20%;
            transform: translateY(-50%);
            background: white;
            border: 2px solid var(--gray-200);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow);
            z-index: 1001;
            transition: var(--transition);
            color: blue
        }

        .toggle-sidebar:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        .toggle-sidebar i {
            font-size: 14px;
            transition: var(--transition);
        }

        .sidebar.collapsed .toggle-sidebar i {
            transform: rotate(180deg);
        }

        .sidebar-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 20px;
            margin: 0 auto 1rem;
            display: block;
            border: 3px solid var(--gray-200);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .sidebar.collapsed .sidebar-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
        }

        .sidebar-title {
            color: var(--gray-900);
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0;
            text-align: center;
            transition: var(--transition);
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            transform: scale(0.8);
        }

        /* Menu Styles */
        .sidebar-menu {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem 0.75rem;
        }

        .menu-section {
            margin-bottom: 2rem;
        }

        .menu-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--gray-500);
            margin-bottom: 1rem;
            padding-left: 1rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .sidebar.collapsed .menu-section-title {
            opacity: 0;
            height: 0;
            margin: 0;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: var(--radius);
            color: var(--gray-700);
            text-decoration: none;
            margin-bottom: 0.5rem;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .menu-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .menu-link:hover::before {
            left: 100%;
        }

        .menu-link i {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.125rem;
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 1rem 0.5rem;
        }

        .sidebar.collapsed .menu-link i {
            margin-right: 0;
            font-size: 1.25rem;
        }

        .sidebar.collapsed .menu-link span {
            display: none;
        }

        .menu-link:hover {
            background: linear-gradient(135deg, var(--gray-100), white);
            color: var(--primary);
            transform: translateX(4px);
            border-color: var(--gray-200);
            box-shadow: var(--shadow);
        }

        .menu-link:hover i {
            color: var(--primary);
            transform: scale(1.1);
        }

        .menu-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transform: translateX(4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .menu-link.active i {
            color: white;
            transform: scale(1.1);
        }

        /* Tooltip for collapsed sidebar */
        .menu-link .tooltip-text {
            position: absolute;
            left: calc(100% + 1rem);
            top: 50%;
            transform: translateY(-50%);
            background: var(--gray-900);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: var(--transition);
            z-index: 1000;
        }

        .menu-link .tooltip-text::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: var(--gray-900);
        }

        .sidebar.collapsed .menu-link:hover .tooltip-text {
            opacity: 1;
        }

        /* Footer */
        .sidebar-footer {
            padding: 1.5rem 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 1rem 0.5rem;
        }

        #logout-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(135deg, transparent, transparent);
            color: black;
            border-radius: var(--radius);
            transition: var(--transition);
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .sidebar.collapsed #logout-button {
            padding: 1rem 0.5rem;
        }

        #logout-button:hover {
            background: linear-gradient(135deg, #efeaea, #efeaea);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        #logout-button i {
            margin-right: 0.75rem;
            transition: var(--transition);
        }

        .sidebar.collapsed #logout-button i {
            margin-right: 0;
        }

        .sidebar.collapsed #logout-button span {
            display: none;
        }

        /* Modern Header */
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
            padding: 0 2rem;
            box-shadow: var(--shadow);
            z-index: 100;
            transition: var(--transition);
            border-bottom: 1px solid var(--gray-200);
        }

        body.sidebar-collapsed .main-header {
            left: var(--sidebar-collapsed-width);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .breadcrumb {
            font-size: 0.875rem;
            color: var(--gray-500);
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: var(--gray-400);
        }

        .breadcrumb-item.active {
            color: var(--primary);
            font-weight: 600;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            color: var(--gray-500);
            font-size: 1.25rem;
            transition: var(--transition);
            padding: 0.75rem;
            border-radius: 50%;
            background: var(--gray-100);
        }

        .notification-icon:hover {
            color: var(--primary);
            background: var(--gray-200);
            transform: scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: linear-gradient(135deg, var(--danger), #dc2626);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .user-info:hover {
            background: var(--gray-100);
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
            font-weight: 600;
            border: 3px solid white;
            box-shadow: var(--shadow);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* User Popup */
        .user-popup {
            position: absolute;
            top: 70px;
            right: 2rem;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 1.5rem;
            width: 280px;
            z-index: 1000;
            display: none;
            border: 1px solid var(--gray-200);
        }

        .user-popup.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-popup::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 2rem;
            width: 16px;
            height: 16px;
            background: white;
            transform: rotate(45deg);
            border-left: 1px solid var(--gray-200);
            border-top: 1px solid var(--gray-200);
        }

        .user-popup-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 1rem;
        }

        .popup-user-name {
            font-weight: 700;
            color: var(--gray-900);
            margin-top: 0.75rem;
            font-size: 1.125rem;
        }

        .popup-user-email {
            font-size: 0.875rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .user-popup-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user-popup-menu li {
            margin-bottom: 0.5rem;
        }

        .user-popup-menu li a {
            color: var(--gray-700);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: var(--transition);
            font-weight: 500;
        }

        .user-popup-menu li a:hover {
            background: var(--gray-100);
            color: var(--primary);
        }

        .user-popup-menu li a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 80px;
          margin-right: 50px;
            flex: 1;
            transition: var(--transition);
        }

        body.sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-header {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .header-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* Animations */
        .menu-link {
            animation: fadeInLeft 0.6s ease forwards;
        }

        .menu-link:nth-child(1) { animation-delay: 0.1s; }
        .menu-link:nth-child(2) { animation-delay: 0.2s; }
        .menu-link:nth-child(3) { animation-delay: 0.3s; }
        .menu-link:nth-child(4) { animation-delay: 0.4s; }
        .menu-link:nth-child(5) { animation-delay: 0.5s; }
        .menu-link:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
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
                <div class="menu-section-title">Main Navigation</div>
                <a href="{{ route('atelierss.statistiques') }}" class="menu-link" data-title="Dashboard" data-breadcrumb="Home › Dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                    <div class="tooltip-text">Dashboard</div>
                </a>

                <a href="{{ route('ateliers.choice') }}" class="menu-link" data-title="Current Requests" data-breadcrumb="Home › Requests">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Current Requests</span>
                    <div class="tooltip-text">Current Requests</div>
                </a>

                <a href="{{ route('assistance.index') }}" class="menu-link" data-title="Maintenance Tickets" data-breadcrumb="Home › Tickets">
    <i class="fas fa-ticket-alt me-2"></i>
    <span>Maintenance Tickets</span>
    <div class="tooltip-text">Maintenance Tickets</div>
</a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Management</div>
                <a href="{{ route('atelierss.availability') }}" class="menu-link" data-title="Availability Management" data-breadcrumb="Home › Management › Availability">
                    <i class="fas fa-calendar-check"></i>
                    <span>Availability</span>
                    <div class="tooltip-text">Availability</div>
                </a>

                <a href="technicienAtelier" class="menu-link" data-title="Technicians Management" data-breadcrumb="Home › Management › Technicians">
                    <i class="fas fa-users-cog"></i>
                    <span>Technicians</span>
                    <div class="tooltip-text">Technicians</div>
                </a>

                <a href="employeeAtelier" class="menu-link" data-title="Users Management" data-breadcrumb="Home › Management › Users">
                    <i class="fas fa-users"></i>
                    <span>Users Management</span>
                    <div class="tooltip-text">Users Management</div>
                </a>
                  <a href="{{ route('atelier.profile.show') }}" class="menu-link" data-title="Profile Management" data-breadcrumb="Home › Management › Profile">
                  <i class="fas fa-cog"></i>

                    <span>Setting</span>
                    <div class="tooltip-text">Setting</div>
                </a>
            </div>
        </div>


    </div>

    <!-- Modern Header -->
    <header class="main-header">
        <div class="header-left">
            <div>
                <h1 class="page-title" id="page-title">Dashboard</h1>
                <nav class="breadcrumb" id="breadcrumb">
                    <span class="breadcrumb-item">Home</span>
                    <span class="breadcrumb-item active">Dashboard</span>
                </nav>
            </div>
        </div>

        <div class="header-right">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>

            <div class="user-info" id="user-info-trigger">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <div class="user-name">Workshop Account</div>

                </div>
            </div>
        </div>
    </header>

    <!-- User Popup -->
    <div class="user-popup" id="user-popup">
        <div class="user-popup-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
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
            <div class="popup-user-name">Guest User</div>
            <div class="popup-user-email">guest@example.com</div>
            @endauth
        </div>
        <ul class="user-popup-menu">
            <li><a href="{{ route('atelier.profile.show') }}"><i class="fas fa-user-cog"></i> Profile Settings</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Preferences</a></li>
            <li><a href="#"><i class="fas fa-question-circle"></i> Help & Support</a></li>
                           <li><a href="{{ route('login') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content">

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get DOM elements
            const toggleSidebar = document.getElementById('toggle-sidebar');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            const pageTitle = document.getElementById('page-title');
            const breadcrumb = document.getElementById('breadcrumb');
            const menuLinks = document.querySelectorAll(".menu-link");
            const userInfoTrigger = document.getElementById('user-info-trigger');
            const userPopup = document.getElementById('user-popup');
            const logoutButton = document.getElementById('logout-button');
            const popupLogoutButton = document.getElementById('popup-logout-button');
            const logoutForm = document.getElementById('logout-form');

            // Toggle sidebar
            toggleSidebar?.addEventListener('click', function() {
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

            // Handle menu links and dynamic header
            const currentURL = window.location.pathname;

            menuLinks.forEach(link => {
                // Set active state based on current URL
                if (link.getAttribute("href") === currentURL) {
                    link.classList.add("active");

                    // Update header with current page info
                    const title = link.getAttribute('data-title') || link.textContent.trim();
                    const breadcrumbText = link.getAttribute('data-breadcrumb') || `Home › ${title}`;

                    updateHeader(title, breadcrumbText);
                }

                // Add click handler for navigation
                link.addEventListener('click', function(e) {
                    // Remove active class from all links
                    menuLinks.forEach(l => l.classList.remove('active'));

                    // Add active class to clicked link
                    this.classList.add('active');

                    // Update header
                    const title = this.getAttribute('data-title') || this.textContent.trim();
                    const breadcrumbText = this.getAttribute('data-breadcrumb') || `Home › ${title}`;

                    updateHeader(title, breadcrumbText);

                    // Store current page info
                    localStorage.setItem('currentPageTitle', title);
                    localStorage.setItem('currentBreadcrumb', breadcrumbText);
                });
            });

            // Function to update header
            function updateHeader(title, breadcrumbText) {
                if (pageTitle) {
                    pageTitle.textContent = title;
                    pageTitle.style.animation = 'none';
                    pageTitle.offsetHeight; // Trigger reflow
                    pageTitle.style.animation = 'fadeInLeft 0.5s ease';
                }

                if (breadcrumb) {
                    const breadcrumbParts = breadcrumbText.split(' › ');
                    breadcrumb.innerHTML = '';

                    breadcrumbParts.forEach((part, index) => {
                        const span = document.createElement('span');
                        span.className = 'breadcrumb-item';
                        if (index === breadcrumbParts.length - 1) {
                            span.classList.add('active');
                        }
                        span.textContent = part;
                        breadcrumb.appendChild(span);
                    });
                }
            }

            // Restore header state from localStorage
            const savedTitle = localStorage.getItem('currentPageTitle');
            const savedBreadcrumb = localStorage.getItem('currentBreadcrumb');

            if (savedTitle && savedBreadcrumb && !document.querySelector('.menu-link.active')) {
                updateHeader(savedTitle, savedBreadcrumb);
            }

            // User popup toggle
            userInfoTrigger?.addEventListener('click', function(e) {
                e.stopPropagation();
                userPopup?.classList.toggle('show');
            });

            // Close popup when clicking outside
            document.addEventListener('click', function(e) {
                if (userPopup && !userPopup.contains(e.target) && !userInfoTrigger.contains(e.target)) {
                    userPopup.classList.remove('show');
                }
            });

            // Logout handlers
            logoutButton?.addEventListener('click', function(e) {
                e.preventDefault();
                if (logoutForm) {
                    logoutForm.submit();
                }
            });

            popupLogoutButton?.addEventListener('click', function(e) {
                e.preventDefault();
                if (logoutForm) {
                    logoutForm.submit();
                }
            });

            // Smooth scrolling for better UX
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading animation to buttons
            document.querySelectorAll('.menu-link').forEach(link => {
                link.addEventListener('click', function() {
                    // Add subtle loading effect
                    this.style.opacity = '0.7';
                    setTimeout(() => {
                        this.style.opacity = '1';
                    }, 300);
                });
            });

            // Keyboard navigation support
            document.addEventListener('keydown', function(e) {
                // ESC to close popup
                if (e.key === 'Escape' && userPopup?.classList.contains('show')) {
                    userPopup.classList.remove('show');
                }

                // Ctrl+B to toggle sidebar
                if (e.ctrlKey && e.key === 'b') {
                    e.preventDefault();
                    toggleSidebar?.click();
                }
            });

            // Add resize handler for responsive behavior
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                } else {
                    // Restore saved state on larger screens
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        body.classList.add('sidebar-collapsed');
                    } else {
                        sidebar.classList.remove('collapsed');
                        body.classList.remove('sidebar-collapsed');
                    }
                }
            });

            // Initialize tooltips for collapsed sidebar
            function initializeTooltips() {
                const tooltips = document.querySelectorAll('.tooltip-text');
                tooltips.forEach(tooltip => {
                    const parent = tooltip.parentElement;
                    parent.addEventListener('mouseenter', function() {
                        if (sidebar.classList.contains('collapsed')) {
                            tooltip.style.opacity = '1';
                        }
                    });
                    parent.addEventListener('mouseleave', function() {
                        tooltip.style.opacity = '0';
                    });
                });
            }

            initializeTooltips();

            // Add notification click handler
            const notificationIcon = document.querySelector('.notification-icon');
            notificationIcon?.addEventListener('click', function() {
                // Here you can add notification panel logic
                console.log('Notifications clicked');
                // Example: show notification dropdown
            });

            // Add search functionality (if needed)
            function addSearchFunctionality() {
                const searchInput = document.getElementById('search-input');
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase();
                        menuLinks.forEach(link => {
                            const text = link.textContent.toLowerCase();
                            const parent = link.closest('.menu-section');
                            if (text.includes(query) || query === '') {
                                link.style.display = 'flex';
                                if (parent) parent.style.display = 'block';
                            } else {
                                link.style.display = 'none';
                            }
                        });

                        // Hide sections with no visible links
                        document.querySelectorAll('.menu-section').forEach(section => {
                            const visibleLinks = section.querySelectorAll('.menu-link[style*="flex"]').length;
                            const allLinks = section.querySelectorAll('.menu-link').length;
                            if (visibleLinks === 0 && allLinks > 0) {
                                section.style.display = 'none';
                            } else {
                                section.style.display = 'block';
                            }
                        });
                    });
                }
            }

            // Initialize search if search input exists
            addSearchFunctionality();

            // Add theme toggle functionality (if needed)
            function initializeThemeToggle() {
                const themeToggle = document.getElementById('theme-toggle');
                if (themeToggle) {
                    themeToggle.addEventListener('click', function() {
                        document.body.classList.toggle('dark-theme');
                        const isDark = document.body.classList.contains('dark-theme');
                        localStorage.setItem('darkTheme', isDark);

                        // Update icon
                        const icon = this.querySelector('i');
                        if (isDark) {
                            icon.className = 'fas fa-sun';
                        } else {
                            icon.className = 'fas fa-moon';
                        }
                    });

                    // Load saved theme
                    const savedTheme = localStorage.getItem('darkTheme') === 'true';
                    if (savedTheme) {
                        document.body.classList.add('dark-theme');
                        const icon = themeToggle.querySelector('i');
                        if (icon) {
                            icon.className = 'fas fa-sun';
                        }
                    }
                }
            }

            initializeThemeToggle();

            // Performance optimization: Debounce resize events
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Replace the resize event listener with debounced version
            window.removeEventListener('resize', window.resizeHandler);
            window.resizeHandler = debounce(function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                } else {
                    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('collapsed');
                        body.classList.add('sidebar-collapsed');
                    } else {
                        sidebar.classList.remove('collapsed');
                        body.classList.remove('sidebar-collapsed');
                    }
                }
            }, 250);

            window.addEventListener('resize', window.resizeHandler);

            // Add animation observer for better performance
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const animationObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            // Observe menu links for animations
            menuLinks.forEach(link => {
                link.style.animationPlayState = 'paused';
                animationObserver.observe(link);
            });

            console.log('Modern sidebar initialized successfully');
        });
    </script>
</body>
</html>
