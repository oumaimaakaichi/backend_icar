<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - AutoCare Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
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

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
        }

        .card-registration {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .card-registration::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .card-registration:hover::before {
            left: 100%;
        }

        .card-registration:hover {
            transform: translateY(-20px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .icon-container {
            transition: transform 0.5s ease;
        }

        .card-registration:hover .icon-container {
            transform: rotateY(360deg) scale(1.1);
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

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .check-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            border-radius: 50%;
            margin-right: 12px;
            position: relative;
        }

        .check-icon::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .btn-register {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-register:hover::before {
            width: 300px;
            height: 300px;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .feature-badge {
            background: rgba(96, 165, 250, 0.1);
            border: 1px solid rgba(96, 165, 250, 0.3);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <!-- Background Blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="blob bg-blue-500" style="width: 400px; height: 400px; top: -100px; left: -100px;"></div>
        <div class="blob bg-purple-500" style="width: 500px; height: 500px; top: 40%; right: -150px; animation-delay: 2s;"></div>
        <div class="blob bg-pink-500" style="width: 350px; height: 350px; bottom: -100px; left: 30%; animation-delay: 4s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-2xl">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <span class="text-white text-2xl font-bold">AutoPro</span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 pt-12 px-6">
        <div class="max-w-7xl mx-auto text-center mb-16">
            <div class="animate-fadeInUp" style="animation-delay: 0.1s; opacity: 0;">
                <div class="inline-block bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-full px-6 py-2 mb-6">
                    <span class="text-white text-sm font-semibold">✨ Join our platform</span>
                </div>
            </div>

            <div class="animate-fadeInUp" style="animation-delay: 0.2s; opacity: 0;">
                <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6">
                    Choose your <span class="gradient-text">account type</span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Select the account type that matches your business needs and start your digital transformation
                </p>
            </div>
        </div>

        <!-- Registration Cards -->
        <div class="max-w-6xl mx-auto pb-20">
            <div class="grid md:grid-cols-2 gap-8">

                <!-- Workshop Card -->
                <div class="animate-fadeInUp" style="animation-delay: 0.3s; opacity: 0;">
                    <div class="card-registration rounded-3xl p-8 h-full">
                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="icon-container w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-2xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                </svg>
                            </div>

                            <!-- Title -->
                            <h2 class="text-4xl font-bold text-white text-center mb-4">Workshop</h2>

                            <!-- Description -->
                            <p class="text-gray-300 text-center mb-6 leading-relaxed text-lg">
                                For auto repair garages and workshops looking to manage their operations and technicians
                            </p>

                            <!-- Features -->
                            <div class="space-y-4 mb-8">
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0"></div>
                                    <span class="text-white font-medium">Employee and technician management</span>
                                </div>
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0"></div>
                                    <span class="text-white font-medium">Real-time service tracking</span>
                                </div>
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0"></div>
                                    <span class="text-white font-medium">Detailed reports and analytics</span>
                                </div>
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0"></div>
                                    <span class="text-white font-medium">Fleet management tools</span>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-8 pt-6 border-t border-white border-opacity-20">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white mb-1">500+</div>
                                    <div class="text-sm text-gray-400">Workshops</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white mb-1">2K+</div>
                                    <div class="text-sm text-gray-400">Users</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white mb-1">4.9★</div>
                                    <div class="text-sm text-gray-400">Rating</div>
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="{{route('atelier.inscription')}}" class="btn-register block w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-4 rounded-xl font-bold text-center hover:shadow-2xl transition-all relative z-10">
                                <span class="relative z-10">Register as Workshop</span>
                                <svg class="relative z-10 inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corporate Fleet Card -->
                <div class="animate-fadeInUp" style="animation-delay: 0.4s; opacity: 0;">
                    <div class="card-registration rounded-3xl p-8 h-full">
                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="icon-container w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-2xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>

                            <!-- Title -->
                            <h2 class="text-4xl font-bold text-white text-center mb-4">Corporate Fleet</h2>

                            <!-- Description -->
                            <p class="text-gray-300 text-center mb-6 leading-relaxed text-lg">
                                For companies with vehicle fleets looking to outsource their maintenance operations
                            </p>

                            <!-- Features -->
                            <div class="space-y-4 mb-8">
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0" style="background: linear-gradient(135deg, #a78bfa, #ec4899);"></div>
                                    <span class="text-white font-medium">Fleet vehicle tracking</span>
                                </div>
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0" style="background: linear-gradient(135deg, #a78bfa, #ec4899);"></div>
                                    <span class="text-white font-medium">Complete service history</span>
                                </div>
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0" style="background: linear-gradient(135deg, #a78bfa, #ec4899);"></div>
                                    <span class="text-white font-medium">Maintenance alerts & reminders</span>
                                </div>
                                <div class="feature-badge rounded-xl p-4 flex items-center">
                                    <div class="check-icon flex-shrink-0" style="background: linear-gradient(135deg, #a78bfa, #ec4899);"></div>
                                    <span class="text-white font-medium">Cost analysis & budget tracking</span>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-8 pt-6 border-t border-white border-opacity-20">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white mb-1">300+</div>
                                    <div class="text-sm text-gray-400">Companies</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white mb-1">5K+</div>
                                    <div class="text-sm text-gray-400">Vehicles</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-white mb-1">4.8★</div>
                                    <div class="text-sm text-gray-400">Rating</div>
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="registreContactante" class="btn-register block w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-4 rounded-xl font-bold text-center hover:shadow-2xl transition-all relative z-10">
                                <span class="relative z-10">Register as Company</span>
                                <svg class="relative z-10 inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Section -->
            <div class="text-center mt-16 animate-fadeInUp" style="animation-delay: 0.6s; opacity: 0;">
                <div class="bg-white bg-opacity-5 backdrop-filter backdrop-blur-lg rounded-2xl p-8 border border-white border-opacity-10 max-w-2xl mx-auto">
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-white text-lg font-semibold">Already have an account?</span>
                    </div>
                    <a href="login" class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white px-10 py-3 rounded-xl font-semibold hover:shadow-2xl transition-all transform hover:scale-105">
                        Sign in now
                        <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="fixed bottom-10 right-10 z-20 animate-float">
        <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-full p-4 shadow-2xl border border-white border-opacity-20 cursor-pointer hover:scale-110 transition-transform">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
            </svg>
        </div>
    </div>

    <script>
        // Animate elements on scroll
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

        // Observe all animated elements
        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
