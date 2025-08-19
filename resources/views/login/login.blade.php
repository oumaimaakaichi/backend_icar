<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f472b6;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            perspective: 1000px;
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .gradient-bg {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
        }

        .input-field {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
            border-color: var(--primary);
        }

        .btn-login {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            background-size: 200% auto;
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            letter-spacing: 0.5px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-login:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.15;
            z-index: -1;
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .social-btn {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9ca3af;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background decoration elements -->
    <div class="decoration-circle bg-purple-500 w-64 h-64 top-1/4 left-1/4 animate-pulse"></div>
    <div class="decoration-circle bg-blue-400 w-80 h-80 bottom-1/4 right-1/4 animate-pulse delay-300"></div>
    <div class="decoration-circle bg-pink-400 w-40 h-40 top-1/3 right-1/3 animate-pulse delay-700"></div>

    <div class="login-container z-10 w-full max-w-md">
        <div class="login-card p-8 animate__animated animate__fadeInUp">
            <!-- Logo with gradient and floating effect -->
            <div class="flex justify-center mb-6">
                <div class="gradient-bg text-white p-5 rounded-full floating shadow-lg">
                    <i class="fas fa-user-shield text-4xl"></i>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-center mb-2 text-gray-800 animate__animated animate__fadeIn">Welcome</h1>
            <p class="text-center text-gray-500 mb-6 animate__animated animate__fadeIn animate__delay-1s">Sign in to access your account</p>

            <!-- Error messages -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg animate__animated animate__shakeX flex items-start">
                    <i class="fas fa-exclamation-circle mt-1 mr-3 flex-shrink-0"></i>
                    <div>
                        <span class="font-medium">Error:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Social login buttons -->
            <div class="flex justify-center space-x-4 mb-6 animate__animated animate__fadeIn animate__delay-1s">
                <button class="social-btn bg-white text-gray-700 p-3 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fab fa-google text-red-500"></i>
                </button>
                <button class="social-btn bg-white text-gray-700 p-3 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fab fa-facebook-f text-blue-600"></i>
                </button>
                <button class="social-btn bg-white text-gray-700 p-3 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fab fa-apple text-gray-800"></i>
                </button>
            </div>

            <div class="divider text-sm mb-6 animate__animated animate__fadeIn animate__delay-1s">OR</div>

            <!-- Login form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email field -->
                <div class="animate__animated animate__fadeIn animate__delay-1s">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="input-field w-full pl-10 pr-3 py-3 rounded-lg focus:outline-none placeholder-gray-400"
                            placeholder="Email address"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password field -->
                <div class="animate__animated animate__fadeIn animate__delay-2s">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="input-field w-full pl-10 pr-10 py-3 rounded-lg focus:outline-none placeholder-gray-400"
                            placeholder="Password"
                            required
                        >
                        <button
                            type="button"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 focus:outline-none transition-colors"
                        >
                            <i id="togglePasswordIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out rounded border-gray-300">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
                    </div>
                </div>

                <!-- Login button -->
                <button
                    type="submit"
                    class="btn-login w-full text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 animate__animated animate__fadeIn animate__delay-3s flex items-center justify-center"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>

            <!-- Registration link -->
            <div class="text-center mt-6 animate__animated animate__fadeIn animate__delay-4s">
                <p class="text-gray-600 text-sm">
                    New to our platform?
                    <a href="{{ route('registreOption') }}" class="font-semibold text-indigo-600 hover:underline ml-1">Create an account</a>
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
                togglePasswordIcon.classList.add('text-indigo-600');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.replace('fa-eye-slash', 'fa-eye');
                togglePasswordIcon.classList.remove('text-indigo-600');
            }
        }

        // Add ripple effect to buttons
        document.querySelectorAll('.btn-login, .social-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const ripple = document.createElement('span');
                ripple.className = 'ripple';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });
    </script>
</body>
</html>
