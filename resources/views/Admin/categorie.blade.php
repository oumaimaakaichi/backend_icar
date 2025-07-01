<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --secondary-gradient:  linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --success-gradient:linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --warning-gradient:linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --info-gradient:linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --dark-gradient:linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --purple-gradient: linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --orange-gradient: linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);
            --green-gradient:linear-gradient(135deg, #6bb5ce 0%, #6bb5ce 100%);

            --bg-primary: #f7f7f7;
            --bg-secondary: #6bb5ce;
            --bg-card: #ffffff;
            --text-primary: #6e9bcf;
            --text-secondary: #000000;
            --text-muted: #0c0101;
            --accent-glow: #000000;
            --border-color: rgba(0, 0, 0, 0.2);

            --shadow-glow: 0 8px 32px rgba(233, 69, 96, 0.3);
            --shadow-subtle: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-secondary);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(233, 69, 96, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .sidebar-container {
            flex-shrink: 0;
        }

        .main-content {
margin-right: 500px,

        }

        .container {
            padding: 2rem;
            max-width: 1800px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 1rem;
            padding: 2rem 0;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #113656, #113656);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 0 30px rgba(204, 220, 246, 0.5);
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;

        }

        .category-card {
            position: relative;
            background: var(--bg-card);
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-color);
            height: 200px;
            width: 200px,
            display: flex;
            flex-direction: column;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .category-card:hover::before {
            opacity: 0.03;
        }

        .category-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-glow);
            border-color: var(--accent-glow);
        }

        .card-header {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            gap: 1rem;
            height: 80px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .category-card:hover .card-icon {
            transform: rotate(10deg) scale(1.1);
            background: rgba(255, 255, 255, 0.3);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card-body {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .category-items {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .category-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding-left: 10px;
        }

        .category-item i {
            color: var(--text-primary);
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .category-card:hover .category-item {
            color: var(--text-secondary);
            transform: translateX(5px);
        }

        .category-card:hover .category-item i {
            color: var(--accent-glow);
            transform: scale(1.2);
        }

        /* Différents gradients pour chaque carte */
        .category-card:nth-child(1) .card-header { background: var(--primary-gradient); }
        .category-card:nth-child(2) .card-header { background: var(--secondary-gradient); }
        .category-card:nth-child(3) .card-header { background: var(--success-gradient); }
        .category-card:nth-child(4) .card-header { background: var(--warning-gradient); }
        .category-card:nth-child(5) .card-header { background: var(--info-gradient); }
        .category-card:nth-child(6) .card-header { background: var(--primary-gradient); }
        .category-card:nth-child(7) .card-header { background: var(--purple-gradient); }
        .category-card:nth-child(8) .card-header { background: var(--orange-gradient); }
        .category-card:nth-child(9) .card-header { background: var(--green-gradient); }

        /* Animations d'entrée */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(233, 69, 96, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(233, 69, 96, 0.6);
            }
        }

        .category-card {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .category-card:nth-child(1) { animation-delay: 0.1s; }
        .category-card:nth-child(2) { animation-delay: 0.2s; }
        .category-card:nth-child(3) { animation-delay: 0.3s; }
        .category-card:nth-child(4) { animation-delay: 0.4s; }
        .category-card:nth-child(5) { animation-delay: 0.5s; }
        .category-card:nth-child(6) { animation-delay: 0.6s; }
        .category-card:nth-child(7) { animation-delay: 0.7s; }
        .category-card:nth-child(8) { animation-delay: 0.8s; }
        .category-card:nth-child(9) { animation-delay: 0.9s; }

        /* Effet de particules */
        .floating-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--accent-glow);
            border-radius: 50%;
            animation: float 6s infinite linear;
            opacity: 0.6;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .categories-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .category-card {
                height: auto;
                min-height: 180px;
            }
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-glow);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ff6b7a;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->

        @include('Sidebar.sidebar')


    <!-- Particules flottantes -->


    <!-- Main Content -->
        <div class="container py-5" style="margin-top: 50px">
        <div class="card shadow p-4">
            <!-- En-tête de la page -->
            <div class="page-header">
                <h1 class="page-title">Management Categories</h1>
                <p class="page-subtitle">Organize and manage your system components efficiently</p>
            </div>

            <!-- Grille des catégories -->
            <div class="categories-grid">
                <!-- Cities Card -->
                <div class="category-card" onclick="window.location.href='{{ route('ville.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-city"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Cities</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>List of available cities</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new city</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Card -->
                <div class="category-card" onclick="window.location.href='{{ route('servicee.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Services</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-tools"></i>
                                <span>Maintenance services</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new service</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tickets Card -->
                <div class="category-card" onclick="window.location.href='{{ route('ticket.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Support Tickets</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-tags"></i>
                                <span>Category types</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Create a new ticket</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Automobile Companies Card -->
                <div class="category-card" onclick="window.location.href='{{ route('entrepriseAutomobile.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Automobile Companies</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-industry"></i>
                                <span>List of companies</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-car-side"></i>
                                <span>Car types</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Packages Card -->
                <div class="category-card" onclick="window.location.href='{{ route('forfait.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Packages</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-list-ol"></i>
                                <span>List of packages</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new package</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specializations Card -->
                <div class="category-card" onclick="window.location.href='{{ route('specialisation.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Specializations</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-list-ul"></i>
                                <span>List of specializations</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new specialization</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banks Card -->
                <div class="category-card" onclick="window.location.href='{{ route('banque.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Banks</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-list"></i>
                                <span>List of banks</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new bank</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colors Card -->
                <div class="category-card" onclick="window.location.href='{{ route('couleur.index') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Colors</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-list"></i>
                                <span>List of colors</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new color</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spare Parts Card -->
                <div class="category-card" onclick="window.location.href='{{ route('category.indexx') }}'">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="card-title"><b style="color: white">Category of Failures</b></div>
                    </div>
                    <div class="card-body">
                        <div class="category-items">
                            <div class="category-item">
                                <i class="fas fa-tag"></i>
                                <span>Failures categories</span>
                            </div>
                            <div class="category-item">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add a new part</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animation d'apparition progressive des cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.category-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                }, index * 100);
            });
        });

        // Effet de parallax léger sur les particules
        document.addEventListener('mousemove', function(e) {
            const particles = document.querySelectorAll('.particle');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            particles.forEach((particle, index) => {
                const speed = (index + 1) * 0.5;
                particle.style.transform += ` translate(${x * speed}px, ${y * speed}px)`;
            });
        });
    </script>
</body>
</html>
