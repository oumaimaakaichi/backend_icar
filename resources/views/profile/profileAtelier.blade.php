<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Profile - {{ $atelier->nom_commercial }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        /* Animated background elements */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: rgba(102, 126, 234, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            left: 80%;
            animation-delay: -2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 30%;
            right: 10%;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Header with glassmorphism effect */
        .profile-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 15px;
            margin-bottom: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.6), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #3a5977, #3a5977);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 46px;
            font-weight: bold;

            position: relative;
            overflow: hidden;
        }

        .profile-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #3a5977, #3a5977);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(148, 203, 208, 0.5);
        }

        .profile-info p {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-info p i {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 8px;
            border-radius: 10px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .status-active {
            background: linear-gradient(135deg, #4ade80, #22c55e);
            color: white;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.4);
        }

        .status-inactive {
            background: linear-gradient(135deg, #3a5977, #3a5977);
            color: white;
            box-shadow: 0 10px 25px rgba(136, 171, 210, 0.4);
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { left: -100%; }
            50% { left: 100%; }
        }

        /* Grid layout with staggered animation */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.8s forwards;
        }

        .profile-card:nth-child(1) { animation-delay: 0.1s; }
        .profile-card:nth-child(2) { animation-delay: 0.2s; }
        .profile-card:nth-child(3) { animation-delay: 0.3s; }
        .profile-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideInUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .profile-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.2);
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3a5977, #4ecdc4, #45b7d1);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .profile-card:hover::before {
            transform: scaleX(1);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3a5977, #3a5977);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;

            position: relative;
        }

        .card-icon::after {
            content: '';
            position: absolute;
            inset: 2px;
            background: linear-gradient(135deg, #3a5977, #3a5977);
            border-radius: 16px;
            z-index: -1;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 18px;
            padding: 16px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border-left: 4px solid #4ecdc4;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .info-item:hover::before {
            transform: translateX(100%);
        }

        .info-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(5px);
        }

        .info-item i {
            color: #4ecdc4;
            width: 24px;
            text-align: center;
            font-size: 18px;
        }

        .info-label {
            font-weight: 700;
            color: #333;
            min-width: 140px;
        }

        .info-value {
            color: #666;
            flex: 1;
            font-weight: 500;
        }

        .info-value a {
            color: #4ecdc4;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .info-value a:hover {
            color: #3a5977;
            text-shadow: 0 0 10px rgba(148, 202, 225, 0.5);
        }

        /* Floating action button with magnetic effect */
        .edit-button {
            position: fixed;
            bottom: 40px;
            right: 40px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #3a5977, #3a5977);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 28px;
            cursor: pointer;
            box-shadow: 0 15px 35px rgba(143, 176, 244, 0.4);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1000;
        }

        .edit-button:hover {
            transform: scale(1.15) rotate(15deg);
            box-shadow: 0 25px 50px rgba(99, 164, 174, 0.6);
        }

        .edit-button:active {
            transform: scale(1.05) rotate(5deg);
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 30px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border: 2px dashed rgba(102, 126, 234, 0.2);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .profile-info h1 {
                font-size: 2.5rem;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                font-size: 48px;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .info-item {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .info-label {
                min-width: auto;
            }
        }

        /* Loading animation */
        .loading-shimmer {
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer-loading 1.5s infinite;
        }

        @keyframes shimmer-loading {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body>
    @include('Sidebar.sidebarAtelier')

    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="container" style="margin-top: 60px ; margin-right:50px">
        <!-- Header Profile -->
        <div class="profile-header">
            <div class="header-content">
                <div class="profile-avatar">
                    {{ strtoupper(substr($atelier->nom_commercial, 0, 2)) }}
                </div>
                <div class="profile-info">
                    <h2>{{ $atelier->nom_commercial }}</h2>
                    <p><i class="fas fa-user-tie"></i> Managed by {{ $atelier->nom_directeur }}</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $atelier->ville }}</p>
                    <p><i class="fas fa-envelope"></i> {{ $atelier->email }}</p>
                    <div class="status-badge {{ $atelier->is_active ? 'status-active' : 'status-inactive' }}">
                        <i class="fas fa-circle"></i>
                        {{ $atelier->is_active ? 'Active' : 'Inactive' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Grid -->
        <div class="profile-grid">
            <!-- General Information -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h2 class="card-title">General Information</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-building"></i>
                    <span class="info-label">Business Name:</span>
                    <span class="info-value">{{ $atelier->nom_commercial }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-file-alt"></i>
                    <span class="info-label">Registry No.:</span>
                    <span class="info-value">{{ $atelier->num_registre_commerce ?? 'Not specified' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-receipt"></i>
                    <span class="info-label">Tax ID:</span>
                    <span class="info-value">{{ $atelier->num_fiscal ?? 'Not specified' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-industry"></i>
                    <span class="info-label">Business Type:</span>
                    <span class="info-value">{{ $atelier->type_entreprise ?? 'Not specified' }}</span>
                </div>

                @if($atelier->site_web)
                <div class="info-item">
                    <i class="fas fa-globe"></i>
                    <span class="info-label">Website:</span>
                    <span class="info-value">
                        <a href="{{ $atelier->site_web }}" target="_blank">{{ $atelier->site_web }}</a>
                    </span>
                </div>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h2 class="card-title">Contact Details</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-user-tie"></i>
                    <span class="info-label">Manager:</span>
                    <span class="info-value">{{ $atelier->nom_directeur }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $atelier->num_contact }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $atelier->email }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="info-label">City:</span>
                    <span class="info-value">{{ $atelier->ville }}</span>
                </div>
            </div>

            <!-- Banking Information -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h2 class="card-title">Banking Information</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-bank"></i>
                    <span class="info-label">Bank:</span>
                    <span class="info-value">{{ $atelier->nom_banque ?? 'Not specified' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-credit-card"></i>
                    <span class="info-label">IBAN:</span>
                    <span class="info-value">{{ $atelier->num_IBAN ?? 'Not specified' }}</span>
                </div>
            </div>

            <!-- Specialization -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h2 class="card-title">Workshop Specialization</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-wrench"></i>
                    <span class="info-label">Specialization:</span>
                    <span class="info-value">{{ $atelier->specialisation_centre ?? 'Not specified' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-users"></i>
                    <span class="info-label">Technicians:</span>
                    <span class="info-value">{{ $atelier->nbr_techniciens ?? '0' }} Technicians</span>
                </div>

                @if($atelier->techniciens)
                <div class="info-item">
                    <i class="fas fa-user-cog"></i>
                    <span class="info-label">Technicians List:</span>
                    <span class="info-value">{{ $atelier->techniciens }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Button -->
    <button class="edit-button" onclick="window.location.href='{{ route('atelier.profile.edit') }}'">
        <i class="fas fa-edit"></i>
    </button>

    <script>
        // Enhanced animations
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.opacity = '1';
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.profile-card').forEach(card => {
                observer.observe(card);
            });

            // Add hover effects to info items
            document.querySelectorAll('.info-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(10px) scale(1.02)';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) scale(1)';
                });
            });

            // Magnetic effect for edit button
            const editButton = document.querySelector('.edit-button');
            document.addEventListener('mousemove', (e) => {
                const buttonRect = editButton.getBoundingClientRect();
                const buttonCenterX = buttonRect.left + buttonRect.width / 2;
                const buttonCenterY = buttonRect.top + buttonRect.height / 2;

                const distance = Math.sqrt(
                    Math.pow(e.clientX - buttonCenterX, 2) +
                    Math.pow(e.clientY - buttonCenterY, 2)
                );

                if (distance < 100) {
                    const angle = Math.atan2(e.clientY - buttonCenterY, e.clientX - buttonCenterX);
                    const moveX = Math.cos(angle) * (100 - distance) * 0.1;
                    const moveY = Math.sin(angle) * (100 - distance) * 0.1;

                    editButton.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.1)`;
                } else {
                    editButton.style.transform = 'translate(0, 0) scale(1)';
                }
            });
        });

        // Add some interactive particles
        function createParticle() {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: fixed;
                width: 4px;
                height: 4px;
                background: rgba(102, 126, 234, 0.3);
                border-radius: 50%;
                pointer-events: none;
                z-index: -1;
                animation: particle 4s linear forwards;
            `;

            particle.style.left = Math.random() * 100 + 'vw';
            particle.style.top = '100vh';

            document.body.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 4000);
        }

        // Add particle animation
        const particleStyle = document.createElement('style');
        particleStyle.textContent = `
            @keyframes particle {
                to {
                    transform: translateY(-100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(particleStyle);

        setInterval(createParticle, 500);
    </script>
</body>
</html>
