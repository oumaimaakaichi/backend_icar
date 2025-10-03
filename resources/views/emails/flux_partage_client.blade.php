<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Maintenance Session</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #3a5977, #3a5977);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .button {
            display: inline-block;
            background: #468cd2;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .info-box {
            background: white;
            border-left: 4px solid #3a5977;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔧 Live Maintenance Session</h1>
        <p>Your technician is ready to start the live stream</p>
    </div>

    <div class="content">
        <h2>Hello {{ $clientName }},</h2>

        <p>Great news! Your technician has started the live maintenance session and is ready to share the real-time video stream with you.</p>

        <div class="info-box">

            <strong>Session Status:</strong> Live streaming available
        </div>

        <p>You can now join the live session to watch the maintenance process in real-time and communicate directly with your technician.</p>

        <div style="text-align: center;">
            <a href="{{ $lienMeet }}" class="button" target="_blank" style="color: white">
                Join Live Session
            </a>
        </div>

        <p><strong>Important Notes:</strong></p>
        <ul>
            <li>Make sure you have a stable internet connection</li>
            <li>The session allows real-time communication with your technician</li>
            <li>You can ask questions and provide feedback during the maintenance</li>
            <li>Keep this link secure - it's unique to your maintenance session</li>
        </ul>

        <p>If you have any issues joining the session, please contact our support team immediately.</p>

        <p>Best regards,<br>
        <strong>The Maintenance Team</strong></p>
    </div>
</body>
</html>
