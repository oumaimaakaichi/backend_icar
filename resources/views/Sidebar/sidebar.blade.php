<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sidebar Gauche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Header Styles */
        .main-header {
            position: fixed;
            top: 0;
            left: 250px; /* Same as sidebar width */
            right: 0;
            height: 60px;
            background: linear-gradient(135deg, #e9ebee, #e9ebee);
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 0px 2px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .app-name {
            font-size: 24px;
            font-weight: bold;
            margin-left: 10px;
        }

        .app-logo {
            width: 40px;
            height: 40px;
        }

        .header-content {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c3e50;
            font-weight: bold;
        }

        .menu-link {
            font-size: 12px;
            padding: 8px 12px;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #e9ebee, #e9ebee);
            color: rgb(7, 7, 7);
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .user-name {
            font-weight: 600;
            color: #485670;
        }
        .sidebar h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        .main-header {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 30px;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ebee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 18px;
        }

        .user-name {
            font-weight: 600;
            color: #485670;
        }

        .sidebar a#logout-button {
            color: rgb(6, 6, 6);
            margin-top: auto;
            background: rgba(120, 124, 140, 0.3);
            border-radius: 8px;
            transition: background 0.3s;
        }

        .sidebar a#logout-button:hover {
            background: rgba(107, 118, 164, 0.3);
        }

        .sidebar a {
            color: rgb(0, 0, 0);
            text-decoration: none;
            padding: 12px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: background 0.3s ease;
            font-size: 16px;
        }

        .sidebar-logo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 40px;
            margin-left: 35px;
            border: 2px solid rgb(247, 245, 245);
        }

        .sidebar a i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        .sidebar a:hover {
            background: rgba(60, 58, 71, 0.2);
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            font-weight: bold;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            margin-left: 220px;
            margin-top: 80px; /* Added to account for header height */
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar-menu">
        <img src="{{ asset('images/1.png') }}" alt="Logo" style="margin-bottom: 40px " >
        <a href="technicien" class="menu-link"><i class="fa-solid fa-screwdriver-wrench"></i>Technician </a>
        <a href="employee" class="menu-link"><i class="fa-solid fa-user"></i>Customers </a>
        <a href="experts"><i class="fa-solid fa-user-tie"></i> Expert Management</a>
        <a href="catalogues"><i class="fa-solid fa-book-open"></i>Catalogue </a>
        <a href="atelier"><i class="fa-solid fa-tools"></i> Workshop  </a>
        <a href="camions"><i class="fa-solid fa-car"></i> Vehicle Management</a>
        <a href="statistiques"><i class="fa-solid fa-chart-line"></i> Statistics</a>
        <a href="points"><i class="fa-solid fa-gem"></i> Loyalty Points</a>
        <a href="entrepriseContractante">
            <i class="fa-solid fa-building"></i> Contracting Companies
        </a>
        <a href="categorie">
            <i class="fa-solid fa-tags"></i> Category
        </a>


        <a href="#" id="logout-button"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Header Section -->
    <header class="main-header">
        <div class="user-info" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#userInfoModal">

            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            @auth('web') {{-- Spécifiez explicitement la guard --}}
            <span class="user-name">
                {{ Auth::guard('web')->user()->nom }} {{ Auth::guard('web')->user()->prenom }}
            </span>
        @else
            <span class="user-name">Invité</span>
        @endauth
        </div>
    </header>

    <div class="content">
        <!-- Your main content goes here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let menuLinks = document.querySelectorAll(".menu-link");
            let currentURL = window.location.pathname;

            menuLinks.forEach(link => {
                if (link.getAttribute("href") === currentURL) {
                    link.classList.add("active");
                }

                link.addEventListener("click", function () {
                    menuLinks.forEach(l => l.classList.remove("active"));
                    this.classList.add("active");
                });
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
