<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Plateforme</title>
    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .select-custom {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        .login-container {
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .login-card {
            transition: all 0.5s ease;
            transform: rotateY(0deg);
            width: 400px;
        }

        .login-card:hover {
            transform: rotateY(5deg) scale(1.01);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .btn-login {
            background-size: 200% auto;
            transition: all 0.5s ease;
        }

        .btn-login:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-indigo-100 flex items-center justify-center min-h-screen p-4">
    <!-- Particules de fond -->
    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-3 h-3 bg-blue-200 rounded-full animate-float"></div>
            <div class="absolute top-1/3 right-1/4 w-4 h-4 bg-indigo-200 rounded-full animate-float animation-delay-1000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-purple-200 rounded-full animate-float animation-delay-1500"></div>
            <div class="absolute bottom-1/3 right-1/3 w-3 h-3 bg-blue-200 rounded-full animate-float animation-delay-2000"></div>
        </div>
    </div>

    <div class="login-container z-10">
        <div class="login-card bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md border border-gray-100 backdrop-blur-sm bg-opacity-90 animate__animated animate__fadeInUp">
            <!-- Logo animé -->
            <div class="flex justify-center mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-full floating pulse">
                    <i class="fas fa-lock-open text-3xl"></i>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-center mb-2 text-gray-800 animate__animated animate__fadeIn">Log In</h1>
            <p class="text-center text-gray-500 mb-6 animate__animated animate__fadeIn animate__delay-1s">Access your personal space</p>

            <!-- Messages d'erreur -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded animate__animated animate__shakeX">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Formulaire -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Sélecteur de profil -->
                <div class="animate__animated animate__fadeIn animate__delay-1s">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profil</label>
                    <div class="relative">
                        <select
                            name="user_type"
                            required
                            class="select-custom input-field w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition-all duration-300"
                        >
                            <option value="" disabled selected>-- Selected  your profile --</option>
                            <option value="admin">Administrateur</option>
                            <option value="expert">Expert</option>
                            <option value="atelier">Atelier</option>
                            <option value="entreprise">Entreprise</option>

                            <option value="Responsable_piece">Responsable Pieces</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down transition-transform duration-200 transform group-hover:rotate-180"></i>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="animate__animated animate__fadeIn animate__delay-1s">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 transition-all duration-300 group-hover:text-blue-500"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="input-field w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                            placeholder="your@email.com"
                            required
                        >
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="animate__animated animate__fadeIn animate__delay-2s">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="input-field w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                            placeholder="••••••••"
                            required
                        >
                        <button
                            type="button"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none transition-colors duration-300"
                        >
                            <i id="togglePasswordIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="mt-1 text-right">
                        <a href="#" class="text-sm text-blue-600 hover:underline transition-colors duration-300">Forgot your password?</a>
                    </div>
                </div>

                <!-- Bouton de connexion -->
                <button
                    type="submit"
                    class="btn-login w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 shadow-md animate__animated animate__fadeIn animate__delay-3s"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Log In
                </button>
            </form>

            <!-- Séparateur -->
            <div class="flex items-center my-6 animate__animated animate__fadeIn animate__delay-3s">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-4 text-gray-500">Or</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <!-- Lien d'inscription -->
            <div class="text-center animate__animated animate__fadeIn animate__delay-4s">
                <p class="text-gray-600">
                    Sign up now
                    <a href="{{ route('registreOption') }}" class="font-semibold text-blue-600 hover:underline transition-colors duration-300">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordIcon.classList.replace('fa-eye', 'fa-eye-slash');
                togglePasswordIcon.classList.add('text-blue-600');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.replace('fa-eye-slash', 'fa-eye');
                togglePasswordIcon.classList.remove('text-blue-600');
            }
        }

        // Animation des particules de fond
        document.querySelectorAll('.animate-float').forEach((el, index) => {
            el.style.animation = `floating ${3 + Math.random() * 4}s ease-in-out ${index * 0.5}s infinite`;
        });
    </script>
</body>
</html>
