<!DOCTYPE html>
<html>
<head>
    <style>
        /* styling serupa dengan email sebelumnya */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin:0; padding:0; color:#333; }
        .email-container { max-width:600px; margin:20px auto; background:#fff; border:1px solid #ddd; border-radius:5px; padding:20px; }
        .email-header { background:#4CAF50; color:#fff; padding:20px; text-align:center; }
        .email-header h1 { margin:0; font-size:24px; }
        .email-body { padding:20px; line-height:1.6; }
        .code { font-size: 32px; font-weight: bold; color: #4CAF50; text-align:center; letter-spacing: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset Verification Code</h1>
        </div>
        <div class="email-body">
            <p>Hello,</p>
            <p>You requested a password reset. Use the verification code below to reset your password. This code will expire in <strong>10 minutes</strong>.</p>
            <div class="code">{{ $code }}</div>
            <p>If you did not request this, please ignore this email.</p>
            <p>Thank you,</p>
            <p>Party Bakar Rumah</p>
        </div>
    </div>
</body>
</html>
