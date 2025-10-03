<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            color: #333;
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .form-section {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .form-section:nth-child(1) { animation-delay: 0.1s; }
        .form-section:nth-child(2) { animation-delay: 0.2s; }
        .form-section:nth-child(3) { animation-delay: 0.3s; }
        .form-section:nth-child(4) { animation-delay: 0.4s; }

        .label-text {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-divider {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            height: 1px;
            margin: 2rem 0;
        }

        .floating-icon {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .error-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            backdrop-filter: blur(10px);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .progress-indicator {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Progress Indicator -->
    <div class="progress-indicator" style="width: 0%" id="progressBar"></div>

    <!-- Floating Icons -->
    <div class="floating-icon text-white text-4xl" style="top: 10%; left: 10%; animation-delay: 0s;">🔧</div>
    <div class="floating-icon text-white text-3xl" style="top: 20%; right: 15%; animation-delay: 2s;">⚙️</div>
    <div class="floating-icon text-white text-3xl" style="bottom: 20%; left: 20%; animation-delay: 4s;">🚗</div>
    <div class="floating-icon text-white text-4xl" style="bottom: 15%; right: 10%; animation-delay: 1s;">🏭</div>

    <div class="min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8 form-section">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-6 shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-white mb-4 text-shadow">Workshop Registration</h1>
                <p class="text-xl text-white opacity-90">Join our network of professional automotive workshops</p>
            </div>

            <!-- Main Form -->
            <div class="glass-card rounded-3xl p-8 md:p-12 form-section">
                <!-- Error Display -->
                @if ($errors->any())
                    <div class="error-alert text-red-100 px-6 py-4 rounded-xl mb-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="errorContainer" class="error-alert text-red-100 px-6 py-4 rounded-xl mb-6 hidden">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Please fix the following errors:</span>
                    </div>
                    <ul id="errorList" class="list-disc list-inside space-y-1"></ul>
                </div>

                <form id="registrationForm" action="{{ route('atelier.inscription.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Business Information Section -->
                    <div class="form-section mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                            </svg>
                            Business Information
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text block mb-2">Business Name *</label>
                                <input type="text" name="nom_commercial" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Enter your business name" value="{{ old('nom_commercial') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Business Type *</label>
                                <select name="type_entreprise" required class="input-field w-full py-3 px-4 rounded-xl">
                                    <option value="">Select business type</option>
                                    <option value="1" {{ old('type_entreprise') == '1' ? 'selected' : '' }}>SARL (Limited Liability Company)</option>
                                    <option value="2" {{ old('type_entreprise') == '2' ? 'selected' : '' }}>EURL (Single Member LLC)</option>
                                    <option value="3" {{ old('type_entreprise') == '3' ? 'selected' : '' }}>SA (Public Limited Company)</option>
                                </select>
                            </div>

                            <div>
                                <label class="label-text block mb-2">Commerce Registry Number *</label>
                                <input type="number" name="num_registre_commerce" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Registry number" value="{{ old('num_registre_commerce') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Tax Number *</label>
                                <input type="number" name="num_fiscal" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Tax identification number" value="{{ old('num_fiscal') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">City *</label>
                                <input type="text" name="ville" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Workshop location" value="{{ old('ville') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Website</label>
                                <input type="url" name="site_web" class="input-field w-full py-3 px-4 rounded-xl" placeholder="https://yourwebsite.com" value="{{ old('site_web') }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Contact & Management Section -->
                    <div class="form-section mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Contact & Management
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text block mb-2">Email Address *</label>
                                <input type="email" name="email" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="business@email.com" value="{{ old('email') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Contact Number *</label>
                                <input type="text" name="num_contact" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="+1 234 567 8900" value="{{ old('num_contact') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Director/Manager Name *</label>
                                <input type="text" name="nom_directeur" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Full name" value="{{ old('nom_directeur') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Workshop Specialization *</label>
                                <input type="text" name="specialisation_centre" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="e.g., Engine repair, Body work, Electrical" value="{{ old('specialisation_centre') }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Security Section -->
                    <div class="form-section mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Account Security
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text block mb-2">Password *</label>
                                <input type="password" name="password" required minlength="8" class="input-field w-full py-3 px-4 rounded-xl" placeholder="Minimum 8 characters">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Confirm Password *</label>
                                <input type="password" name="password_confirmation" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Repeat password">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Financial Information Section -->
                    <div class="form-section mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Financial Information
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text block mb-2">Bank Name *</label>
                                <input type="text" name="nom_banque" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="Your bank name" value="{{ old('nom_banque') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">IBAN Number *</label>
                                <input type="text" name="num_IBAN" required class="input-field w-full py-3 px-4 rounded-xl" placeholder="International bank account number" value="{{ old('num_IBAN') }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Technical Details Section -->
                    <div class="form-section mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Technical Team
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text block mb-2">Number of Technicians *</label>
                                <input type="number" name="nbr_techniciens" required min="0" class="input-field w-full py-3 px-4 rounded-xl" placeholder="0" value="{{ old('nbr_techniciens') }}">
                            </div>

                            <div>
                                <label class="label-text block mb-2">Technician Names/Details</label>
                                <input type="text" name="techniciens" class="input-field w-full py-3 px-4 rounded-xl" placeholder="Names or brief details" value="{{ old('techniciens') }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Documents Section -->
                    <div class="form-section mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Documents & Photos
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-text block mb-2">Business Documents</label>
                                <div class="file-input-wrapper rounded-xl p-6 text-center">
                                    <input type="file" name="document" accept=".pdf,.doc,.docx" class="file-input">
                                    <svg class="w-12 h-12 mx-auto text-white opacity-70 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-white opacity-90 text-sm">PDF, Word documents</p>
                                </div>
                            </div>

                            <div>
                                <label class="label-text block mb-2">Workshop Photos</label>
                                <div class="file-input-wrapper rounded-xl p-6 text-center">
                                    <input type="file" name="photos_centre" accept="image/*" class="file-input">
                                    <svg class="w-12 h-12 mx-auto text-white opacity-70 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-white opacity-90 text-sm">JPG, PNG images</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activation Checkbox -->
                    <div class="form-section mb-8">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-2 border-white border-opacity-50 text-blue-600 focus:ring-blue-500 focus:ring-2">
                            <span class="label-text">Activate workshop account immediately</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-section">
                        <button type="submit" class="btn-primary w-full py-4 px-8 rounded-xl font-bold text-white text-lg shadow-2xl relative overflow-hidden">
                            <span class="relative z-10">Complete Registration</span>
                        </button>

                        <div class="text-center mt-6">
                            <p class="text-white opacity-90">
                                Already have an account?
                                <a href="login" class="text-yellow-300 hover:text-yellow-200 font-semibold hover:underline transition-colors">Sign in here</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form progress tracking
        const form = document.getElementById('registrationForm');
        const progressBar = document.getElementById('progressBar');
        const inputs = form.querySelectorAll('input[required], select[required]');

        function updateProgress() {
            let filledInputs = 0;
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filledInputs++;
                }
            });
            const progress = (filledInputs / inputs.length) * 100;
            progressBar.style.width = progress + '%';
        }

        // Add event listeners to all required inputs
        inputs.forEach(input => {
            input.addEventListener('input', updateProgress);
            input.addEventListener('change', updateProgress);
        });

        // File input feedback
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const wrapper = this.parentElement;
                const fileName = this.files[0] ? this.files[0].name : '';
                if (fileName) {
                    wrapper.style.backgroundColor = 'rgba(34, 197, 94, 0.2)';
                    wrapper.style.borderColor = 'rgba(34, 197, 94, 0.5)';
                }
            });
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            // Don't prevent default - let Laravel handle the submission
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;

            const errors = [];

            if (password !== confirmPassword) {
                errors.push('Passwords do not match');
            }

            if (password.length < 8) {
                errors.push('Password must be at least 8 characters long');
            }

            const errorContainer = document.getElementById('errorContainer');
            const errorList = document.getElementById('errorList');

            if (errors.length > 0) {
                e.preventDefault(); // Only prevent if there are client-side errors
                errorList.innerHTML = errors.map(error => `<li>${error}</li>`).join('');
                errorContainer.classList.remove('hidden');
                errorContainer.scrollIntoView({ behavior: 'smooth' });
                return;
            }

            errorContainer.classList.add('hidden');
            // Form will submit normally to Laravel backend
        });

        // Smooth animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.form-section').forEach(el => {
            observer.observe(el);
        });

        // Initial progress update
        updateProgress();
    </script>
</body>
</html>
