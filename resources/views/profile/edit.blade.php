<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil Expert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #1d91b1;
            --secondary-color: #1d91b1;
            --accent-color: #1d91b1;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --text-color: #2b2d42;
            --border-radius: 10px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            min-height: 100vh;
        }

        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
        }

        .profile-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            background-color: white;
            transition: transform 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
        }

        .profile-header {
            background-color:#1d91b1;
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .avatar-container {
            width: 120px;
            height: 120px;
            margin: -70px auto 20px;
            position: relative;
        }

        .avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            background: linear-gradient(45deg, #6bb9f1, #6bb9f1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            margin-top: 30px
        }

        .profile-title {
            font-weight: 700;

        }

        .profile-subtitle {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .form-section {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .form-control {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            border: 1px solid #e9ecef;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: var(--border-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-color);
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .password-toggle:hover {
            opacity: 1;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }

        .alert {
            border-radius: var(--border-radius);
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 0 15px;
            }

            .avatar-container {
                width: 100px;
                height: 100px;
                margin-top: -50px;
            }

            .profile-header {
                padding: 1.5rem;
            }

            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
@include('Sidebar.sidebarExpert')

   <div class="container py-5" style="margin-top: 50px ; margin-right:50px">
    <div class="card shadow p-4">
        <div class="profile-card">
            <div class="profile-header">
                <h1 class="profile-title">Expert Profile</h1>
                <p class="profile-subtitle">Update your personal and professional information</p>
            </div>

            <div class="avatar-container">
                <div class="avatar">
                    @auth('web')
                        <b>
                            {{ strtoupper(substr(Auth::guard('web')->user()->nom, 0, 1)) }}
                            {{ strtoupper(substr(Auth::guard('web')->user()->prenom, 0, 1)) }}
                        </b>
                    @else
                        ES
                    @endauth
                </div>
            </div>

            <div class="form-section">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <h3 class="section-title">Personal Information</h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="prenom" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                    </div>

                    <h3 class="section-title mt-5">Professional Information</h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="specialite" class="form-label">Specialty</label>
                            <input type="text" class="form-control" id="specialite" name="specialite"
                                   value="{{ old('specialite', $user->extra_data['specialite'] ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="annee_experience" class="form-label">Years of Experience</label>
                            <input type="number" class="form-control" id="annee_experience" name="annee_experience"
                                   value="{{ old('annee_experience', $user->extra_data['annee_experience'] ?? '') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="qualifications" class="form-label">Qualifications</label>
                        <textarea class="form-control" id="qualifications" name="qualifications" rows="4">{{ old('qualifications', $user->extra_data['qualifications'] ?? '') }}</textarea>
                    </div>

                    <h3 class="section-title mt-5">Security</h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6 position-relative">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" style="margin-top: 35px"></i>
                            </span>
                        </div>

                        <div class="col-md-6 position-relative">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" style="margin-top: 35px"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        field.type = field.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>
</body>
</html>
