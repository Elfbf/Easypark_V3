<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kode OTP EasyPark</title>
</head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #2d3748;">Reset Password EasyPark</h2>
    <p>Gunakan kode OTP berikut untuk reset password kamu:</p>
    <div style="background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0;">
        <h1 style="color: #3182ce; font-size: 48px; letter-spacing: 8px; margin: 0;">{{ $otp }}</h1>
    </div>
    <p style="color: #718096;">Kode ini berlaku selama <strong>10 menit</strong>.</p>
    <p style="color: #718096;">Jika kamu tidak meminta reset password, abaikan email ini.</p>
    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;">
    <p style="color: #a0aec0; font-size: 12px;">EasyPark — Sistem Parkir Pintar Polije</p>
</body>
</html>