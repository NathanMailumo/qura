<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; background-color: #f8fafc; padding: 20px; }
        .card { background: #ffffff; padding: 30px; border-radius: 12px; max-width: 480px; margin: 0 auto; border: 1px solid #e2e8f0; }
        .code { font-size: 32px; font-weight: bold; letter-spacing: 6px; color: #2563eb; margin: 20px 0; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Password Reset Verification</h2>
        <p>Use the following 6-digit code to complete your password reset for Qura:</p>
        <div class="code">{{ $otp }}</div>
        <p style="font-size: 12px; color: #64748b;">This code will expire in 15 minutes. If you did not request this, please ignore this email.</p>
    </div>
</body>
</html>