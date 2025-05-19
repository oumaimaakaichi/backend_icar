<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Contracting Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
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

        .card-header h4 {
            font-weight: 700;
            position: relative;
        }

        .card-header i {
            margin-right: 10px;
            font-size: 1.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }

        .btn-success {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
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

        .input-group-text {
            background-color: var(--light-color);
            border-radius: 8px 0 0 8px;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-white text-center">
                        <h4><i class="fas fa-building"></i> Register Your Contracting Company</h4>
                        <p class="mb-0">Join our platform and manage your workshops efficiently</p>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('entreprises.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-id-card"></i> Company Information</h5>

                                        <div class="mb-3">
                                            <label class="form-label">Company Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                <input type="text" name="nom_entreprise" class="form-control" required placeholder="Enter company name">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Unique Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                <input type="text" name="num_unique" class="form-control" required placeholder="Enter unique identifier">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Company Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                <input type="text" name="adresse_entreprise" class="form-control" required placeholder="Enter full address">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                <input type="text" name="ville" class="form-control" required placeholder="Enter city">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-user-tie"></i> Representative Information</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Mandataire Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" name="nom_mandataire" class="form-control" required placeholder="Enter representative name">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Contact Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" name="num_contact" class="form-control" required placeholder="Enter phone number">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" class="form-control" required placeholder="Enter email address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-lock"></i> Account Security</h5>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                <input type="password" name="password" class="form-control" required placeholder="Create password">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-warehouse"></i> Facility Details</h5>

                                        <div class="mb-3">
                                            <label class="form-label">Number of Employees</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                <input type="number" name="nbr_employee" class="form-control" required placeholder="Enter employee count">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Number of Required Workshops</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-tools"></i></span>
                                                <input type="number" name="nbr_ateliers_requis" class="form-control" required placeholder="Enter workshop count">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-parking"></i> Parking Information</h5>

                                        <div class="mb-3">
                                            <label class="form-label">Parking Type</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-car"></i></span>
                                                <input type="text" name="type_parking" class="form-control" required placeholder="Enter parking type">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Ceiling Height of Parking (m)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                                                <input type="number" step="0.1" name="hauteur_plafond_parking" class="form-control" required placeholder="Enter height in meters">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-ruler-combined"></i> Dimensions</h5>

                                        <div class="mb-3">
                                            <label class="form-label">Authorized Height (m)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-arrows-alt-v"></i></span>
                                                <input type="number" step="0.1" name="hauteur_autorise" class="form-control" required placeholder="Enter authorized height">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="text-muted">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="login-link">
                                            <i class="fas fa-sign-in-alt"></i> Login here
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-user-plus"></i> Register Company
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
