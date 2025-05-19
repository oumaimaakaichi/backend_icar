<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account | Professional Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #38b000;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f5 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .registration-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background: white;
        }

        .registration-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            text-align: center;
            color: white;
        }

        .card-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .card-header h2 {
            font-weight: 700;
            position: relative;
            margin-bottom: 0;
        }

        .form-section {
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            z-index: 2;
        }

        .input-with-icon input,
        .input-with-icon select {
            padding-left: 40px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            height: 45px;
            transition: all 0.3s;
        }

        .input-with-icon input:focus,
        .input-with-icon select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }

        .btn-register {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            color: white;
            width: 100%;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .login-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        #photo-preview, #carte-identite-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            margin-top: 10px;
            display: none;
        }

        .preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .role-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
            background-color: var(--accent-color);
            color: white;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="container" style="max-width: 800px;">
        <div class="registration-card">
            <div class="card-header">
                <h2><i class="fas fa-user-plus me-2"></i>Create Professional Account</h2>
            </div>

            <div class="card-body p-0">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-id-card"></i> Personal Information</h5>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">First Name</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="nom" class="form-control" required placeholder="Enter your first name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Last Name</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="prenom" class="form-control" required placeholder="Enter your last name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Email</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Phone</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text" name="phone" class="form-control" required placeholder="Enter your phone number">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Address</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" name="adresse" class="form-control" required placeholder="Enter your address">
                            </div>
                        </div>
                    </div>

                    <!-- Account Security Section -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-lock"></i> Account Security</h5>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Password</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-key input-icon"></i>
                                <input type="password" name="password" class="form-control" required placeholder="Create a password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Confirm Password</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-key input-icon"></i>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm your password">
                            </div>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-user-tag"></i> Professional Role</h5>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Select Role</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-briefcase input-icon"></i>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="">Select your professional role</option>
                                    <option value="technicien">Technician <span class="role-badge">Field Expert</span></option>
                                    <option value="employe">Employee <span class="role-badge">Corporate</span></option>
                                    <option value="expert">Expert <span class="role-badge">Consultant</span></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Fields Section -->
                    <div id="extra-fields" class="form-section"></div>

                    <!-- Submit Button -->
                    <div class="p-4">
                        <button type="submit" class="btn btn-register">
                            <i class="fas fa-user-plus me-2"></i>Complete Registration
                        </button>

                        <p class="text-center mt-3">
                            Already have an account? <a href="/" class="login-link"><i class="fas fa-sign-in-alt me-1"></i>Log In</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            let role = this.value;
            let extraFields = document.getElementById('extra-fields');
            extraFields.innerHTML = '';

            if (role === 'technicien' || role === 'expert') {
                extraFields.innerHTML = `
                    <h5 class="section-title"><i class="fas fa-user-cog"></i> Professional Details</h5>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Profile Photo</label>
                        <div class="col-sm-9">
                            <div class="input-with-icon">
                                <i class="fas fa-camera input-icon"></i>
                                <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                            </div>
                            <div class="preview-container mt-2">
                                <img id="photo-preview" src="#" alt="Photo preview">
                                <small class="text-muted">Upload a professional headshot (100x100px)</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Speciality</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-tools input-icon"></i>
                            <input type="text" name="specialite" class="form-control" placeholder="Your area of expertise">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Qualifications</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-graduation-cap input-icon"></i>
                            <input type="text" name="qualifications" class="form-control" placeholder="Your certifications or degrees">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Years of Experience</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="number" name="annee_experience" class="form-control" placeholder="Number of years in field">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Vehicle Brand</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-car input-icon"></i>
                            <input type="text" name="marque_voiture" class="form-control" placeholder="Brand of your work vehicle">
                        </div>
                    </div>
                `;

                if (role === 'technicien') {
                    extraFields.innerHTML += `
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label form-label">Direct Supervisor</label>
                            <div class="col-sm-9 input-with-icon">
                                <i class="fas fa-user-shield input-icon"></i>
                                <input type="text" name="responsable_direct" class="form-control" placeholder="Your supervisor's name">
                            </div>
                        </div>
                    `;
                }

                // Photo preview functionality
                document.getElementById('photo').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const reader = new FileReader();
                    const photoPreview = document.getElementById('photo-preview');

                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = 'block';
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                });
            } else if (role === 'employe') {
                extraFields.innerHTML = `
                    <h5 class="section-title"><i class="fas fa-building"></i> Employment Details</h5>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Company Name</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-building input-icon"></i>
                            <input type="text" name="nom_entreprise" class="form-control" placeholder="Your employer's name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">ID Card Photo</label>
                        <div class="col-sm-9">
                            <div class="input-with-icon">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="file" name="photo_carte_identite" id="photo_carte_identite" class="form-control" accept="image/*">
                            </div>
                            <div class="preview-container mt-2">
                                <img id="carte-identite-preview" src="#" alt="ID Card preview">
                                <small class="text-muted">Upload a clear photo of your ID card</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Work Email</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email_employe" class="form-control" placeholder="Your company email">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label form-label">Professional Card Expiry</label>
                        <div class="col-sm-9 input-with-icon">
                            <i class="fas fa-id-badge input-icon"></i>
                            <input type="date" name="carte_professionnel" class="form-control">
                        </div>
                    </div>
                `;

                // ID card preview functionality
                document.getElementById('photo_carte_identite').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const reader = new FileReader();
                    const carteIdentitePreview = document.getElementById('carte-identite-preview');

                    reader.onload = function(e) {
                        carteIdentitePreview.src = e.target.result;
                        carteIdentitePreview.style.display = 'block';
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
