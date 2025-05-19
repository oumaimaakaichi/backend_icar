<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix</title>
    <!-- Intégration de Tailwind CSS pour le design -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .split-screen {
            display: flex;
            height: 100vh;
        }
        .split-screen > div {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .split-screen > div:hover {
            opacity: 0.9;
        }
        .atelier {
            background-color: #4F46E5; /* Couleur bleue */
            color: white;
        }
        .employe {
            background-color: #10B981; /* Couleur verte */
            color: white;
        }
    </style>
</head>
<body>
    <div class="split-screen">
        <!-- Partie Atelier -->
      <!--  <div class="atelier" onclick="window.location.href='{{ route('atelier.inscription') }}'">-->
        <div class="atelier" onclick="window.location.href='registreContactante'">
            <h1 class="text-4xl font-bold">Êtes-vous un atelier ?</h1>
        </div>
        <!-- Partie Employé -->
        <div class="employe" onclick="window.location.href='{{ route('login') }}'">
            <h1 class="text-4xl font-bold">Êtes-vous un employé ?</h1>
        </div>
    </div>
</body>
</html>
