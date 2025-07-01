<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Type de Demande | GaragePro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-warning: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        body {
            background: white;
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated background elements */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape-2 {
            top: 20%;
            right: 20%;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #a8edea, #fed6e3);
            transform: rotate(45deg);
            animation-delay: 2s;
        }

        .shape-3 {
            bottom: 20%;
            left: 15%;
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, #d299c2, #fef9d7);
            border-radius: 30%;
            animation-delay: 4s;
        }

        .shape-4 {
            bottom: 30%;
            right: 10%;
            width: 90px;
            height: 90px;
            background: linear-gradient(45deg, #89f7fe, #66a6ff);
            border-radius: 50%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(90deg); }
            50% { transform: translateY(-40px) rotate(180deg); }
            75% { transform: translateY(-20px) rotate(270deg); }
        }

        /* Main container */
        .main-container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            margin-top: 70px;
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 4rem 3rem;
            box-shadow:
                0 32px 64px rgba(0, 0, 0, 0.1),
                0 16px 32px rgba(0, 0, 0, 0.05);
            max-width: 1400px;
            width: 100%;
            animation: slideUp 1s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

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

        /* Header section */
        .header-section {
            text-align: center;
            margin-bottom: 20PX;
            position: relative;
        }

        .header-badge {
            display: inline-block;
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .main-title {
            font-size:40px;
            font-weight: bold;
            background: linear-gradient(135deg, var(--dark), var(--gray-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;

            line-height: 1.1;
        }

        .main-subtitle {
            color: var(--gray-600);
            font-size: 1.25rem;
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Cards section */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 3rem;
            margin-top: 1rem;
        }

        .service-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .known-fault {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.02), rgba(52, 211, 153, 0.02));
        }

        .known-fault::before {
            background: var(--gradient-success);
        }

        .unknown-fault {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.02), rgba(251, 191, 36, 0.02));
        }

        .unknown-fault::before {
            background: var(--gradient-warning);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .card-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            transition: all 0.3s ease;
        }

        .known-fault .card-icon-wrapper {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.1));
        }

        .unknown-fault .card-icon-wrapper {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(251, 191, 36, 0.1));
        }

        .service-card:hover .card-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .card-icon {
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .known-fault .card-icon {
            color: var(--success);
        }

        .unknown-fault .card-icon {
            color: var(--warning);
        }

        .card-content {
            flex: 1;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .card-label {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
        }

        .known-fault .card-label {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .unknown-fault .card-label {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .card-description {
            color: var(--gray-600);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .card-features {
            margin-bottom: 2.5rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .feature-icon {
            width: 16px;
            height: 16px;
            margin-right: 0.75rem;
            color: var(--success);
        }

        .cta-button {
            width: 100%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .known-fault .cta-button {
            background: var(--gradient-success);
        }

        .unknown-fault .cta-button {
            background: var(--gradient-warning);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.4);
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        /* Stats section */
        .stats-section {
            margin-top: 4rem;
            padding-top: 3rem;
            border-top: 1px solid var(--gray-200);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
            border-radius: 16px;
            background: var(--gray-50);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .main-title {
                font-size: 2.5rem;
            }

            .content-wrapper {
                padding: 2rem;
                margin: 1rem;
            }

            .service-card {
                padding: 2rem;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .card-icon-wrapper {
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .loading-content {
            text-align: center;
            color: white;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
@include('Sidebar.sidebarExpert')

    <!-- Animated background shapes -->
    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner"></div>
            <p>Redirection en cours...</p>
        </div>
    </div>

    <div class="main-container" >
        <div class="content-wrapper">
            <!-- Header Section -->
            <div class="header-section">
                <div class="header-badge">
                    <i class="fas fa-tools"></i>
                    Service Maintenance
                </div>
                <h3 class="main-title">Choisissez votre Service</h3>

            </div>

            <!-- Cards Section -->
            <div class="cards-container">
                <!-- Known Fault Card -->
                <div class="service-card known-fault" onclick="window.location.href='{{ route('reponsable_piece.demandes') }}'">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-check-circle card-icon"></i>
                        </div>
                        <div class="card-content">
                            <h2 class="card-title">Panne Connu</h2>
                            <span class="card-label">Intervention Directe</span>
                        </div>
                    </div>

                    <p class="card-description">
                        Vous connaissez déjà la nature exacte du problème ? Accédez directement à notre service de maintenance ciblé pour une résolution rapide et efficace.
                    </p>

                    <div class="card-features">
                        <div class="feature-item">
                            <i class="fas fa-bolt feature-icon"></i>
                            <span>Intervention immédiate</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock feature-icon"></i>
                            <span>Gain de temps considérable</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-target feature-icon"></i>
                            <span>Solution précise et adaptée</span>
                        </div>
                    </div>

                    <button class="cta-button">
                        <span>Continuer</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Unknown Fault Card -->
                <div class="service-card unknown-fault" onclick="window.location.href='{{ route('expert.demande_maintenanceInconnu') }}'">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-search-plus card-icon"></i>
                        </div>
                        <div class="card-content">
                            <h2 class="card-title">Panne Inconnu</h2>
                            <span class="card-label">Analyse Complète</span>
                        </div>
                    </div>

                    <p class="card-description">
                        Problème non identifié ? Notre système de diagnostic avancé vous accompagne étape par étape pour identifier précisément la panne et proposer la solution optimale.
                    </p>

                    <div class="card-features">
                        <div class="feature-item">
                            <i class="fas fa-brain feature-icon"></i>
                            <span>Diagnostic intelligent</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-route feature-icon"></i>
                            <span>Guidance étape par étape</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-lightbulb feature-icon"></i>
                            <span>Solution personnalisée</span>
                        </div>
                    </div>

                    <button class="cta-button">
                        <span>Lancer le diagnostic</span>
                        <i class="fas fa-microscope"></i>
                    </button>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Taux de satisfaction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24h</div>
                        <div class="stat-label">Délai moyen d'intervention</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1500+</div>
                        <div class="stat-label">Interventions réalisées</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5★</div>
                        <div class="stat-label">Note moyenne clients</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle card clicks with loading animation
        function handleCardClick(type) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'flex';

            // Simulate navigation delay
            setTimeout(() => {
                if (type === 'known') {
                    window.location.href = '{{ route("expert.demande_maintenance") }}';
                } else {
                    window.location.href = '{{ route("expert.demande_maintenanceInconnu") }}';
                }
            }, 1500);
        }

        // Add ripple effect to buttons
        document.querySelectorAll('.cta-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number');
                    const finalValue = statNumber.textContent;
                    animateCounter(statNumber, finalValue);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-item').forEach(item => {
            observer.observe(item);
        });

        function animateCounter(element, finalValue) {
            const isPercentage = finalValue.includes('%');
            const isStar = finalValue.includes('★');
            const isTime = finalValue.includes('h');
            const isPlus = finalValue.includes('+');

            let numValue = parseInt(finalValue.replace(/[^\d]/g, ''));
            let currentValue = 0;
            const increment = numValue / 50;

            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= numValue) {
                    currentValue = numValue;
                    clearInterval(timer);
                }

                let displayValue = Math.floor(currentValue);
                if (isPercentage) displayValue += '%';
                else if (isStar) displayValue += '★';
                else if (isTime) displayValue += 'h';
                else if (isPlus) displayValue += '+';

                element.textContent = displayValue;
            }, 20);
        }

        // Add smooth scrolling for better UX
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

        // Add loading animation to page
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.5s ease';
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
