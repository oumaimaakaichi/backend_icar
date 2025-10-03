<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Icar Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slideIn {
            animation: slideIn 1s ease-out forwards;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
            animation: blob 7s infinite;
        }

        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .team-card {
            transition: all 0.4s ease;
        }

        .team-card:hover {
            transform: translateY(-15px) scale(1.02);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            box-shadow: 0 0 20px rgba(96, 165, 250, 0.5);
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <!-- Background Animated Blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="blob bg-blue-500" style="width: 400px; height: 400px; top: -100px; left: -100px;"></div>
        <div class="blob bg-purple-500" style="width: 500px; height: 500px; top: 40%; right: -150px; animation-delay: 2s;"></div>
        <div class="blob bg-pink-500" style="width: 350px; height: 350px; bottom: -100px; left: 30%; animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 px-6 py-4 animate-slideIn">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-2xl">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 01-3 0V9a1.5 1.5 0 013 0v7.5zM12 14.5a1.5 1.5 0 01-3 0V9a1.5 1.5 0 013 0v5.5zM16 12.5a1.5 1.5 0 01-3 0V9a1.5 1.5 0 013 0v3.5z"/>
                        <path d="M4 6a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                    </svg>
                </div>
                <span class="text-white text-2xl font-bold">Icar Pro</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="/" class="text-white hover:text-blue-300 transition-colors">Home</a>
                <a href="about" class="text-blue-300 font-semibold">About</a>
                <a href="login" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-2xl transition-all transform hover:scale-105">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 px-6 pt-20 pb-10">
        <div class="max-w-7xl mx-auto text-center">
            <div class="animate-fadeInUp" style="animation-delay: 0.2s; opacity: 0;">
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6">
                    About <span class="gradient-text">Icar Pro</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Your trusted partner for automotive maintenance and repair for over 10 years
                </p>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="relative z-10 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <div class="glass-card rounded-3xl p-12 animate-fadeInUp" style="animation-delay: 0.4s; opacity: 0;">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-bold text-white mb-6">Our Mission</h2>
                        <p class="text-gray-300 text-lg leading-relaxed mb-6">
                            At Icar Pro, we are committed to providing exceptional automotive services that exceed our customers' expectations. Our mission is to ensure that every vehicle receives the professional care it deserves.
                        </p>
                        <p class="text-gray-300 text-lg leading-relaxed">
                            We believe in transparency, honesty, and technical excellence. Every intervention is carried out with precision and attention to detail.
                        </p>
                    </div>
                    <div class="flex justify-center">
                        <div class="w-64 h-64 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-2xl animate-float">
                            <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="relative z-10 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-6 animate-fadeInUp" style="animation-delay: 0.6s; opacity: 0;">
                <div class="stat-card glass-card rounded-2xl p-8 text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">10+</div>
                    <div class="text-white text-lg font-semibold mb-1">Years</div>
                    <div class="text-gray-400 text-sm">of experience</div>
                </div>
                <div class="stat-card glass-card rounded-2xl p-8 text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">5000+</div>
                    <div class="text-white text-lg font-semibold mb-1">Clients</div>
                    <div class="text-gray-400 text-sm">satisfied</div>
                </div>
                <div class="stat-card glass-card rounded-2xl p-8 text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">15+</div>
                    <div class="text-white text-lg font-semibold mb-1">Technicians</div>
                    <div class="text-gray-400 text-sm">certified</div>
                </div>
                <div class="stat-card glass-card rounded-2xl p-8 text-center">
                    <div class="text-5xl font-bold gradient-text mb-2">98%</div>
                    <div class="text-white text-lg font-semibold mb-1">Satisfaction</div>
                    <div class="text-gray-400 text-sm">rate</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="relative z-10 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 animate-fadeInUp" style="animation-delay: 0.2s; opacity: 0;">
                <h2 class="text-4xl font-bold text-white mb-4">Our Values</h2>
                <p class="text-gray-300 text-lg">The principles that guide our daily work</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 animate-fadeInUp" style="animation-delay: 0.4s; opacity: 0;">
                <div class="glass-card rounded-2xl p-8 hover:bg-white hover:bg-opacity-10 transition-all">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Quality</h3>
                    <p class="text-gray-300 leading-relaxed">
                        We only use premium quality parts and our technicians follow strict standards to guarantee impeccable work.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-8 hover:bg-white hover:bg-opacity-10 transition-all">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Transparency</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Clear and honest communication about all services. You know exactly what you're paying for and why.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-8 hover:bg-white hover:bg-opacity-10 transition-all">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Innovation</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Modern diagnostic equipment and cutting-edge techniques for efficient and accurate services.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="relative z-10 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 animate-fadeInUp" style="animation-delay: 0.2s; opacity: 0;">
                <h2 class="text-4xl font-bold text-white mb-4">Our Team</h2>
                <p class="text-gray-300 text-lg">Passionate professionals at your service</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 animate-fadeInUp" style="animation-delay: 0.4s; opacity: 0;">
                <div class="team-card glass-card rounded-2xl p-8 text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-4xl font-bold shadow-2xl">
                        AK
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Ahmed Karim</h3>
                    <p class="text-blue-300 mb-4">Technical Director</p>
                    <p class="text-gray-300 text-sm">
                        15 years of experience in automotive mechanics. ASE Master Technician certified.
                    </p>
                </div>

                <div class="team-card glass-card rounded-2xl p-8 text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-4xl font-bold shadow-2xl">
                        SM
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Sarah Mansour</h3>
                    <p class="text-purple-300 mb-4">Workshop Manager</p>
                    <p class="text-gray-300 text-sm">
                        Electronic diagnostics specialist with 12 years of experience.
                    </p>
                </div>

                <div class="team-card glass-card rounded-2xl p-8 text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-4xl font-bold shadow-2xl">
                        MH
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Mohamed Hamdi</h3>
                    <p class="text-green-300 mb-4">Customer Service Manager</p>
                    <p class="text-gray-300 text-sm">
                        Ensures your satisfaction and coordinates all services with excellence.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative z-10 px-6 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="glass-card rounded-3xl p-12 text-center animate-fadeInUp" style="animation-delay: 0.6s; opacity: 0;">
                <h2 class="text-4xl font-bold text-white mb-4">Ready to Join Us?</h2>
                <p class="text-gray-300 text-lg mb-8">
                    Discover why thousands of drivers trust us for their vehicle maintenance
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="login.html" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transition-all transform hover:scale-105">
                        Book Appointment
                    </a>
                    <a href="tel:555123456" class="glass-card text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:bg-opacity-10 transition-all">
                        Call Us: (555) 123-4567
                    </a>
                </div>
            </div>
        </div>
    </div>

    <br/><br/>

    <script>
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
