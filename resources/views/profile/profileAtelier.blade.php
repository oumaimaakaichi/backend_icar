<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Atelier - {{ $atelier->nom_commercial }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: rgb(218, 216, 216);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .profile-info h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .profile-info p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 15px;
        }

        .status-active {
            background: linear-gradient(135deg, #4ade80, #22c55e);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #f87171, #ef4444);
            color: white;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 50px;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 55px;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-bottom: 10px
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            padding: 12px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }

        .info-item i {
            color: #667eea;
            width: 20px;
            text-align: center;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            min-width: 120px;
        }

        .info-value {
            color: #666;
            flex: 1;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .photo-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .photo-item:hover {
            transform: scale(1.05);
        }

        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .availability-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .day-item {
            background: rgba(102, 126, 234, 0.05);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .day-available {
            border-color: #22c55e;
            background: rgba(34, 197, 94, 0.1);
        }

        .day-unavailable {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .day-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
            text-transform: capitalize;
        }

        .day-time {
            color: #666;
            font-size: 0.9rem;
        }

        .edit-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .edit-button:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .profile-info h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
       @include('Sidebar.sidebarAtelier')
    <div class="container" style="margin-top: 60px">
        <!-- Header Profile -->
        <div class="profile-header">
            <div class="header-content">
                <div class="profile-avatar">
                    {{ strtoupper(substr($atelier->nom_commercial, 0, 2)) }}
                </div>
                <div class="profile-info">
                    <h1>{{ $atelier->nom_commercial }}</h1>
                    <p><i class="fas fa-user-tie"></i> Dirigé par {{ $atelier->nom_directeur }}</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ $atelier->ville }}</p>
                    <p><i class="fas fa-envelope"></i> {{ $atelier->email }}</p>
                    <div class="status-badge {{ $atelier->is_active ? 'status-active' : 'status-inactive' }}">
                        <i class="fas fa-circle"></i>
                        {{ $atelier->is_active ? 'Actif' : 'Inactif' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Grid -->
        <div class="profile-grid">
            <!-- Informations Générales -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h2 class="card-title">Informations Générales</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-building"></i>
                    <span class="info-label">Nom Commercial:</span>
                    <span class="info-value">{{ $atelier->nom_commercial }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-file-alt"></i>
                    <span class="info-label">N° Registre:</span>
                    <span class="info-value">{{ $atelier->num_registre_commerce ?? 'Non renseigné' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-receipt"></i>
                    <span class="info-label">N° Fiscal:</span>
                    <span class="info-value">{{ $atelier->num_fiscal ?? 'Non renseigné' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-industry"></i>
                    <span class="info-label">Type Entreprise:</span>
                    <span class="info-value">{{ $atelier->type_entreprise ?? 'Non renseigné' }}</span>
                </div>

                @if($atelier->site_web)
                <div class="info-item">
                    <i class="fas fa-globe"></i>
                    <span class="info-label">Site Web:</span>
                    <span class="info-value">
                        <a href="{{ $atelier->site_web }}" target="_blank" style="color: #667eea; text-decoration: none;">
                            {{ $atelier->site_web }}
                        </a>
                    </span>
                </div>
                @endif
            </div>

            <!-- Informations Contact -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h2 class="card-title">Contact</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-user-tie"></i>
                    <span class="info-label">Directeur:</span>
                    <span class="info-value">{{ $atelier->nom_directeur }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <span class="info-label">Téléphone:</span>
                    <span class="info-value">{{ $atelier->num_contact }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $atelier->email }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="info-label">Ville:</span>
                    <span class="info-value">{{ $atelier->ville }}</span>
                </div>
            </div>

            <!-- Informations Bancaires -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h2 class="card-title">Informations Bancaires</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-bank"></i>
                    <span class="info-label">Banque:</span>
                    <span class="info-value">{{ $atelier->nom_banque ?? 'Non renseigné' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-credit-card"></i>
                    <span class="info-label">IBAN:</span>
                    <span class="info-value">{{ $atelier->num_IBAN ?? 'Non renseigné' }}</span>
                </div>
            </div>

            <!-- Spécialisation -->
            <div class="profile-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h2 class="card-title">Spécialisation</h2>
                </div>

                <div class="info-item">
                    <i class="fas fa-wrench"></i>
                    <span class="info-label">Spécialisation:</span>
                    <span class="info-value">{{ $atelier->specialisation_centre ?? 'Non renseigné' }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-users"></i>
                    <span class="info-label">Nb. Techniciens:</span>
                    <span class="info-value">{{ $atelier->nbr_techniciens ?? '0' }}</span>
                </div>

                @if($atelier->techniciens)
                <div class="info-item">
                    <i class="fas fa-user-cog"></i>
                    <span class="info-label">Techniciens:</span>
                    <span class="info-value">{{ $atelier->techniciens }}</span>
                </div>
                @endif
            </div>



            <!-- Disponibilités -->

        </div>
    </div>

    <!-- Edit Button -->
    <button class="edit-button" onclick="window.location.href='{{ route('atelier.profile.edit') }}'">
        <i class="fas fa-edit"></i>
    </button>

    <script>
        // Animation d'entrée pour les cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.profile-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Lightbox pour les images
        document.querySelectorAll('.photo-item img').forEach(img => {
            img.addEventListener('click', function() {
                const lightbox = document.createElement('div');
                lightbox.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1000;
                    cursor: pointer;
                `;

                const enlargedImg = img.cloneNode();
                enlargedImg.style.cssText = `
                    max-width: 90%;
                    max-height: 90%;
                    object-fit: contain;
                    border-radius: 10px;
                `;

                lightbox.appendChild(enlargedImg);
                document.body.appendChild(lightbox);

                lightbox.addEventListener('click', () => {
                    document.body.removeChild(lightbox);
                });
            });
        });
    </script>
</body>
</html>
