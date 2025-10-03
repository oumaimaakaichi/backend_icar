<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Client Registration - Action Required</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #1e293b;
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
            background: #f1f5f9;
        }
        .email-wrapper {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 35px 40px;
            text-align: center;
            position: relative;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #60a5fa, #3b82f6, #2563eb);
        }
        .logo-section {
            margin-bottom: 20px;
            align-items: center;

        }
        .logo-placeholder {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            backdrop-filter: blur(10px);
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 8px 0 0 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 16px;
            color: #334155;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        .alert-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 18px 22px;
            margin: 25px 0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .alert-icon {
            font-size: 22px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .alert-content {
            flex: 1;
        }
        .alert-title {
            font-weight: 700;
            color: #92400e;
            margin: 0 0 5px 0;
            font-size: 15px;
        }
        .alert-text {
            margin: 0;
            color: #78350f;
            font-size: 14px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        .details-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 28px;
            margin: 20px 0;
        }
        .client-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .avatar {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .client-name-section h3 {
            margin: 0;
            color: #0f172a;
            font-size: 20px;
            font-weight: 700;
        }
        .client-id {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .info-table tr {
            border-bottom: 1px solid #e2e8f0;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-table td {
            padding: 14px 0;
            vertical-align: top;
        }
        .info-label {
            font-weight: 600;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 35%;
        }
        .info-value {
            color: #0f172a;
            font-size: 15px;
            font-weight: 500;
        }
        .action-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 2px solid #93c5fd;
            border-radius: 10px;
            padding: 28px;
            margin: 30px 0;
            text-align: center;
        }
        .action-box h3 {
            margin: 0 0 12px 0;
            color: #1e40af;
            font-size: 18px;
            font-weight: 700;
        }
        .action-box p {
            margin: 0 0 20px 0;
            color: #1e40af;
            font-size: 14px;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transition: transform 0.2s;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        .footer-note {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        .footer-note p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 30px 40px;
            text-align: center;
            font-size: 13px;
        }
        .footer-brand {
            color: #e2e8f0;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .footer p {
            margin: 8px 0;
        }
        .footer-links {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #1e293b;
        }
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            margin: 0 10px;
        }
        @media (max-width: 600px) {
            .content {
                padding: 25px 20px;
            }
            .details-card {
                padding: 20px;
            }
            .client-header {
                flex-direction: column;
                text-align: center;
            }
            .info-label {
                width: 100%;
                display: block;
                padding-bottom: 5px;
            }
            .info-table td {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo-placeholder">🚗</div>
            </div>
            <h1>New Client Registration</h1>
            <p>Administrative Notification - Action Required</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                <strong>Dear Administrator,</strong><br>
                This notification is to inform you that a new client has successfully completed the registration process on your platform. The account requires administrative review and activation before the client can access full services.
            </div>

            <!-- Alert Box -->
            <div class="alert-box">
                <div class="alert-icon">⚠️</div>
                <div class="alert-content">
                    <p class="alert-title">Immediate Action Required</p>
                    <p class="alert-text">This client account is currently in pending status and awaiting your approval to become active.</p>
                </div>
            </div>

            <!-- Section Title -->
            <h2 class="section-title">Client Details</h2>

            <!-- Client Details Card -->
            <div class="details-card">
                <div class="client-header">

                    <div class="client-name-section">
                        <h3>{{ $client->prenom }} {{ $client->nom }}</h3>

                        <span class="status-badge">⏳ Pending Activation</span>
                    </div>
                </div>

                <table class="info-table">
                    <tr>
                        <td class="info-label">Full Name</td>
                        <td class="info-value">{{ $client->prenom }} {{ $client->nom }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Email Address</td>
                        <td class="info-value">{{ $client->email }}</td>
                    </tr>

                    <tr>
                        <td class="info-label">Registration Date</td>
                        <td class="info-value">{{ $registrationDate }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Account Status</td>
                        <td class="info-value" style="color: #f59e0b; font-weight: 600;">Pending Administrative Approval</td>
                    </tr>
                </table>
            </div>

            <!-- Action Box -->
            <div class="action-box">
                <h3>📋 Required Action</h3>
                <p>
                    Please log in to your administrative dashboard to review this registration request. After verification, you can activate the account to grant the client full access to platform services.
                </p>
                <a href="{{route('login')}}" class="cta-button" style="color: white">Access Admin Dashboard →</a>
            </div>

            <div class="divider"></div>

            <!-- Footer Note -->
            <div class="footer-note">
                <p>
                    <strong>Note:</strong> This is an automated system notification sent to designated administrators.
                    Please do not reply directly to this email. For technical support or questions, please contact your system administrator.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">Maintenance Service Platform</div>
            <p>&copy; {{ date('Y') }} All Rights Reserved</p>
            <p style="opacity: 0.7;">Administrative Notification System v2.0</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <span>|</span>
                <a href="#">Terms of Service</a>
                <span>|</span>
                <a href="#">Support</a>
            </div>
        </div>
    </div>
</body>
</html>
