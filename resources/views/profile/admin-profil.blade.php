<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Super Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3f5a6e;
            --primary-dark: #3f5a6e;
            --secondary: #3f5a6e;
            --accent: #4f909b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
            font-weight: 400;
        }

        .profile-wrapper {
            padding: 2rem 1rem;
            min-height: 100vh;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Modern Card Design */
        .profile-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
            overflow: hidden;
            position: relative;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        /* Header with Glassmorphism Effect */
        .profile-header {
            background-color: white;
            padding: 1rem 1rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="0" cy="0" r="1"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="180" fill="url(%23a)"/><circle cx="800" cy="300" r="120" fill="url(%23a)"/><circle cx="600" cy="700" r="150" fill="url(%23a)"/></svg>');
            opacity: 0.3;
        }

        .profile-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .profile-title {
            font-size: 2rem;
            font-weight: 800;
            color: rgb(2, 2, 2);
            letter-spacing: -0.025em;
        }

        .profile-subtitle {
            font-size: 1rem;
            color: rgba(116, 108, 108, 0.8);
            font-weight: 400;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Modern Avatar */
        .avatar-container {
            width: 110px;
            height: 110px;
            margin: -70px auto 2rem;
            position: relative;
            z-index: 3;
        }

        .avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            border: 6px solid white;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .avatar:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }

        .avatar::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: xor;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .avatar:hover::after {
            opacity: 1;
        }

        /* Form Sections */
        .form-section {
            padding: 0rem 2.5rem 0rem;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-title i {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        /* Modern Form Inputs */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--gray-50);
            color: var(--gray-800);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgb(99 102 241 / 0.1);
            background: white;
            outline: none;
        }

        .form-control:hover {
            border-color: var(--gray-300);
        }

        /* Password Toggle */
        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray-400);
            transition: color 0.2s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Modern Buttons */
        .btn {
            border-radius: 12px;
            padding: 0.875rem 1.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgb(99 102 241 / 0.4);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }

        .btn-outline-secondary {
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
            background: white;
        }

        .btn-outline-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Alert Styles */
        .alert {
            border-radius: 16px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, rgb(16 185 129 / 0.1) 0%, rgb(34 197 94 / 0.1) 100%);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        /* Grid Layout */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Action Bar */
        .action-bar {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            padding: 2rem 2.5rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: between;
            align-items: center;
            gap: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-wrapper {
                padding: 1rem;
            }

            .profile-header {
                padding: 2rem 1.5rem 6rem;
            }

            .profile-title {
                font-size: 2rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .action-bar {
                padding: 1.5rem;
                flex-direction: column-reverse;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .avatar-container {
                width: 120px;
                height: 120px;
                margin-top: -60px;
            }

            .avatar {
                font-size: 2.5rem;
            }
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section {
            animation: slideInUp 0.6s ease-out;
        }

        /* Focus States for Accessibility */
        .btn:focus,
        .form-control:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        /* Loading State */
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Hover Effects */
        .profile-card {
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-4px);
        }
    </style>
</head>
<body>
@include('Sidebar.sidebar')

<div class="container py-4" style="margin-top: 80px; margin-right: 50px;">
    <div class="profile-container">
        <div class="profile-card">
            <!-- Modern Header -->
            <div class="profile-header">
                <div class="profile-header-content">
                    <h1 class="profile-title">Super Admin Profile</h1>
                    <p class="profile-subtitle" style="margin-bottom: 40px">Update your personal information and manage your security settings</p>
                </div>
            </div>

            <!-- Modern Avatar -->
            <div class="avatar-container">
                <div class="avatar">
                    <b>ES</b>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Section -->
                    <div class="section-title">
                        <i class="fas fa-user"></i>
                        <span>Personal Information</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nom" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="prenom" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="section-title">
                        <i class="fas fa-shield-alt"></i>
                        <span>Security Settings</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                                <span class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your new password">
                                <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back
                </a>
                <button type="submit" form="profile-form" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.parentElement.querySelector('.password-toggle i');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Add form ID to enable submit button
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            form.id = 'profile-form';
        }
    });

    // Add loading state to submit button
    document.getElementById('profile-form')?.addEventListener('submit', function() {
        const submitBtn = document.querySelector('.btn-primary');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';
    });
</script>
</body>
</html>
