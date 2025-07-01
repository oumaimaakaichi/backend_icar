<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Expert Créé - ICAR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #fefeff 0%, #ffffff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .email-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            position: relative;
            z-index: 2;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .success-message {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.3);
        }

        .credentials-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .credentials-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .credentials-title::before {
            content: '🔐';
            margin-right: 10px;
            font-size: 20px;
        }

        .credential-item {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .credential-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .credential-value {
            background: #ffffff;
            padding: 12px 15px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            color: #2c3e50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .credential-value:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            margin: 20px 0;
            font-size: 16px;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .security-notice {
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
            padding: 20px;
            border-radius: 15px;
            margin: 25px 0;
            border-left: 4px solid #e17055;
        }

        .security-title {
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .security-title::before {
            content: '⚠️';
            margin-right: 10px;
        }

        .security-text {
            color: #2d3436;
            line-height: 1.6;
        }

        .footer {
            background: #2c3e50;
            padding: 30px;
            text-align: center;
            color: #bdc3c7;
        }

        .footer-title {
            color: #ecf0f1;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            margin: 25px 0;
            border-radius: 1px;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 15px;
            }

            .content, .header {
                padding: 25px 20px;
            }

            .greeting {
                font-size: 20px;
            }

            .login-button {
                padding: 12px 30px;
                font-size: 14px;
            }
        }

        .highlight {
            background: linear-gradient(120deg, #a8edea 0%, #fed6e3 100%);
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo" style="margin-left: 43%">ICAR</div>
            <div class="header-subtitle">Plateforme Expert</div>
        </div>

        <div class="content">
            <div class="greeting" style="margin-top: 60px">
                Bonjour <span class="highlight">{{ $expert->prenom }} {{ $expert->nom }}</span>,
            </div>

            <div class="success-message" >
                🎉 Votre compte expert a été créé avec succès sur notre plateforme !
            </div>

            <div class="credentials-section" style="margin-left: 50px">
                <div class="credentials-title">
                    Vos informations de connexion
                </div>

                <div class="credential-item">
                    <div class="credential-label" style="margin-top: 10px">Email &nbsp; </div>
                    <div class="credential-value">{{ $expert->email }}</div>
                </div>

                <div class="credential-item">
                    <div class="credential-label" style="margin-top: 10px">Mot de passe temporaire &nbsp; </div>
                    <div class="credential-value">{{ $password }}</div>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="login-button">
                    🚀 Se connecter maintenant
                </a>
            </div>

            <div class="divider"></div>

            <div class="security-notice">
                <div class="security-title">
                    Sécurité importante
                </div>
                <div class="security-text">
                    Nous vous recommandons fortement de <strong>changer votre mot de passe</strong> dès votre première connexion pour assurer la sécurité de votre compte.
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-title">Merci de votre confiance</div>
            <div>L'équipe ICAR</div>
        </div>
    </div>
</body>
</html>
