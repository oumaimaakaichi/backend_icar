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

        .menu-link {
            font-size: 14px;
            padding: 10px 15px;
            margin-bottom: 5px;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #e8ebf0, #e9ebee);
            color: rgb(7, 7, 7);
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 101;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .sidebar a#logout-button {
            color: rgb(6, 6, 6);
            margin-top: auto;
            background: rgba(120, 124, 140, 0.3);
            border-radius: 8px;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            padding: 12px;
            font-size: 14px;
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
            transition: all 0.3s ease;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .sidebar-logo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 30px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            border: 3px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar a i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
            font-size: 16px;
        }

        .sidebar a:hover {
            background: rgba(60, 58, 71, 0.2);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            font-weight: bold;
            border-left: 4px solid #4a6baf;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            margin-left: 200px;
            margin-top: 70px;
            background-color: #f5f7fa;
            min-height: calc(100vh - 70px);
        }
/* Modal Styles */
.modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid #eee;
    background-color: #f8f9fa;
    border-radius: 10px 10px 0 0;
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
    font-size: 20px;
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
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar-menu">
        <img src="{{ asset('images/1.png') }}" alt="Logo"  style="margin-bottom: 50px ; margin-top:20px">
        <h3>Maintenance System</h3>
        <a href="demande_maintenance" class="menu-link"><i class="fas fa-chart-bar"></i> Home</a>

         <a href="logoutA" id="logout-button" ><i class="fas fa-sign-out-alt"></i> Logout</a>
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

    <div class="content" >
        <!-- Your main content goes here -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sélectionne tous les liens du menu
            let menuLinks = document.querySelectorAll(".menu-link");

            // Vérifie l'URL actuelle pour ajouter la classe active
            let currentURL = window.location.pathname;

            menuLinks.forEach(link => {
                // Vérifie si l'URL du lien correspond à l'URL actuelle
                if (link.getAttribute("href") === currentURL) {
                    link.classList.add("active");
                }

                // Ajoute un événement au clic pour changer la classe active
                link.addEventListener("click", function () {
                    // Supprime la classe active des autres liens
                    menuLinks.forEach(l => l.classList.remove("active"));
                    // Ajoute la classe active au lien cliqué
                    this.classList.add("active");
                });
            });
        });
    </script>
    <script>
        document.getElementById("logout-button").addEventListener("click", function(event) {
            event.preventDefault(); // Empêcher la navigation normale
            document.getElementById("logout-form").submit(); // Soumettre le formulaire
        });
    </script>
</body>
</html>
