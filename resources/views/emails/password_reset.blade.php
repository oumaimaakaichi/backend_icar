<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                 color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 10px 10px; }
        .password-box { background: #fff; border: 2px dashed #667eea; padding: 15px; 
                       text-align: center; margin: 20px 0; font-size: 18px; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->prenom }} {{ $user->nom }},</p>
            
            <p>You requested a password reset for your account.</p>
            
            <p>Here is your new temporary password:</p>
            
            <div class="password-box">
                {{ $newPassword }}
            </div>
            
            <p><strong>Security tip:</strong> After logging in, we recommend changing this password in your profile settings.</p>
            
            <p>Best regards,<br>Support Team</p>
        </div>
        <div class="footer">
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>