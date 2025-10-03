<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - CarCare Pro</title>
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

        .card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-15px) scale(1.02);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 24px;
            padding: 3px;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.5), rgba(139, 92, 246, 0.5));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s;
        }

        .card:hover::before {
            opacity: 1;
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

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .card:hover .feature-icon {
            transform: rotate(360deg) scale(1.1);
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
            <div class="space-x-4">
                <a href="#services" class="text-white hover:text-blue-300 transition-colors">Home</a>
                <a href="about" class="text-white hover:text-blue-300 transition-colors">About</a>
                <a href="login" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-2xl transition-all transform hover:scale-105">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-6 pt-10">
        <div class="max-w-7xl mx-auto text-center">
            <div class="animate-fadeInUp" style="animation-delay: 0.2s; opacity: 0;">
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6">
                    Professional <span class="gradient-text">Car Maintenance</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Keep your vehicle running smoothly with expert maintenance services, advanced diagnostics, and professional care
                </p>
            </div>

            <div class="animate-fadeInUp" style="animation-delay: 0.4s; opacity: 0;">
                <div class="inline-block glass-card rounded-2xl px-6 py-3 mb-16 shimmer">
                    <span class="text-white text-sm font-semibold">✨ Trusted by thousands of drivers</span>
                </div>
            </div>

            <!-- Service Cards Container -->
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto animate-fadeInUp" style="animation-delay: 0.6s; opacity: 0;">

                <!-- Regular Maintenance Card -->
                <div class="card relative glass-card rounded-3xl p-8 overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-400 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                    <div class="relative z-10">
                        <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-3">Regular Maintenance</h3>
                        <p class="text-gray-200 text-sm mb-4 leading-relaxed">
                            Oil changes, filter replacements, fluid checks, and routine inspections
                        </p>

                        <div class="text-center pt-4 border-t border-white border-opacity-20">
                            <div class="text-2xl font-bold text-white">From $49</div>
                            <div class="text-sm text-gray-300">Starting price</div>
                        </div>
                    </div>
                </div>

                <!-- Diagnostics Card -->
                <div class="card relative glass-card rounded-3xl p-8 overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-purple-400 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                    <div class="relative z-10">
                        <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-3">Advanced Diagnostics</h3>
                        <p class="text-gray-200 text-sm mb-4 leading-relaxed">
                            Computer diagnostics, error code scanning, and system analysis
                        </p>

                        <div class="text-center pt-4 border-t border-white border-opacity-20">
                            <div class="text-2xl font-bold text-white">From $89</div>
                            <div class="text-sm text-gray-300">Starting price</div>
                        </div>
                    </div>
                </div>

                <!-- Repairs Card -->
                <div class="card relative glass-card rounded-3xl p-8 overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-emerald-400 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                    <div class="relative z-10">
                        <div class="feature-icon w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V5a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-3">Expert Repairs</h3>
                        <p class="text-gray-200 text-sm mb-4 leading-relaxed">
                            Engine repairs, brake service, transmission work, and electrical fixes
                        </p>

                        <div class="text-center pt-4 border-t border-white border-opacity-20">
                            <div class="text-2xl font-bold text-white">Quote</div>
                            <div class="text-sm text-gray-300">Free estimate</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Why Choose Us Section -->
            <div class="mt-20 animate-fadeInUp" style="animation-delay: 0.8s; opacity: 0;">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-12">Why Choose Our Service?</h2>
                <div class="grid md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                    <div class="glass-card rounded-xl p-6 hover:bg-white hover:bg-opacity-10 transition-all">
                        <div class="text-4xl mb-3">⚡</div>
                        <h3 class="text-white font-bold text-lg mb-2">Fast Service</h3>
                        <p class="text-gray-300 text-sm">Quick turnaround without compromising quality</p>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:bg-white hover:bg-opacity-10 transition-all">
                        <div class="text-4xl mb-3">🔧</div>
                        <h3 class="text-white font-bold text-lg mb-2">Expert Technicians</h3>
                        <p class="text-gray-300 text-sm">Certified professionals with years of experience</p>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:bg-white hover:bg-opacity-10 transition-all">
                        <div class="text-4xl mb-3">💎</div>
                        <h3 class="text-white font-bold text-lg mb-2">Quality Parts</h3>
                        <p class="text-gray-300 text-sm">Only genuine and high-quality replacement parts</p>
                    </div>
                    <div class="glass-card rounded-xl p-6 hover:bg-white hover:bg-opacity-10 transition-all">
                        <div class="text-4xl mb-3">🛡️</div>
                        <h3 class="text-white font-bold text-lg mb-2">Warranty</h3>
                        <p class="text-gray-300 text-sm">All work backed by comprehensive warranty</p>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-16 animate-fadeInUp" style="animation-delay: 1s; opacity: 0;">
                <div class="glass-card rounded-3xl p-12 max-w-3xl mx-auto">
                    <h3 class="text-3xl font-bold text-white mb-4">Ready to Schedule Service?</h3>
                    <p class="text-gray-300 mb-8">Book your appointment today and keep your car running at its best</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-2xl transition-all transform hover:scale-105">
                            Book Appointment
                        </button>
                        <button class="glass-card text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:bg-opacity-10 transition-all">
                            Call Now: (555) 123-4567
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Chat Button -->
    <div class="fixed bottom-10 right-10 z-20 animate-float">
        <div class="glass-card rounded-full p-4 shadow-2xl cursor-pointer hover:scale-110 transition-transform">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
            </svg>
        </div>
    </div>
    <br/> <br/> <br/>

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
