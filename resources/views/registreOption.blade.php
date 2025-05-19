<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - AutoCare Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --dark: #1b263b;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
        }

        .hero-section {
            background: url('https://images.unsplash.com/photo-1549317661-bd32bbc8e486?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center;
            background-size: cover;
            height: 170px;
            position: relative;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .hero-overlay {
            background: rgba(27, 38, 59, 0.7);
            border-radius: 0 0 20px 20px;
        }

        .card-registration {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
        }

        .card-registration:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: none;
        }

        .atelier .card-header {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }

        .entreprise .card-header {
            background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
        }

        .user .card-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .card-body {
            padding: 2rem;
        }

        .btn-register {
            background: var(--dark);
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            letter-spacing: 1px;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .atelier .btn-register {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }

        .entreprise .btn-register {
            background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
        }

        .user .btn-register {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .atelier .icon-container {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            box-shadow: 0 5px 15px rgba(58, 123, 213, 0.4);
        }

        .entreprise .icon-container {
            background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
            box-shadow: 0 5px 15px rgba(142, 45, 226, 0.4);
        }

        .user .icon-container {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }

        .feature-list {
            list-style: none;
            padding-left: 0;
        }

        .feature-list li {
            padding: 8px 0;
            position: relative;
            padding-left: 30px;
        }

        .feature-list li:before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            color: var(--accent);
        }

        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            bottom: -10px;
            left: 0;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->


    <!-- Registration Options -->
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold">Choisissez votre profil</h2>
            <p class="text-muted">Sélectionnez le type de compte qui correspond à votre activité</p>
        </div>

        <div class="row g-4">
            <!-- Atelier Card -->
            <div class="col-lg-4">
                <div class="card-registration atelier h-100">
                    <div class="card-header">
                        <div class="icon-container">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3>Atelier</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Pour les garages et ateliers de réparation automobile souhaitant gérer leurs activités et techniciens.</p>

                        <ul class="feature-list mb-4">
                            <li>Gestion des employés</li>
                            <li>Suivi des interventions</li>
                            <li>Rapports détaillés</li>
                            <li>Gestion du parc automobile</li>
                        </ul>

                        <div class="text-center mt-4">
                            <a href="" class="btn btn-register text-white">
                                S'inscrire comme atelier <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Entreprise Contractante Card -->
            <div class="col-lg-4">
                <div class="card-registration entreprise h-100">
                    <div class="card-header">
                        <div class="icon-container">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3>Entreprise Contractante</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Pour les entreprises ayant un parc automobile et souhaitant externaliser leur maintenance.</p>

                        <ul class="feature-list mb-4">
                            <li>Suivi des véhicules</li>
                            <li>Historique des interventions</li>
                            <li>Alertes maintenance</li>
                            <li>Analyse des coûts</li>
                        </ul>

                        <div class="text-center mt-4">
                            <a href="registreContactante" class="btn btn-register text-white">
                                S'inscrire comme entreprise <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Utilisateur Card -->
            <div class="col-lg-4">
                <div class="card-registration user h-100">
                    <div class="card-header">
                        <div class="icon-container">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3>Particulier</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Pour les particuliers souhaitant trouver des professionnels pour l'entretien de leur véhicule.</p>

                        <ul class="feature-list mb-4">
                            <li>Trouver des ateliers proches</li>
                            <li>Prendre rendez-vous en ligne</li>
                            <li>Historique des réparations</li>
                            <li>Alertes d'entretien</li>
                        </ul>

                        <div class="text-center mt-4">
                            <a href="{{ route('register') }}" class="btn btn-register text-white">
                                S'inscrire comme particulier <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="text-muted">Vous avez déjà un compte? <a href="{{ route('login') }}" class="text-primary">Connectez-vous</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
