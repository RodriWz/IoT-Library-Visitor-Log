<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="single-form">
    <div class="center-form">

        <div class="form-header">
            <img src="{{ asset('icon/logo.png') }}" class="logo">
            <h2>Lupa Password</h2>
        </div>

        <p class="form-desc">
            Masukkan email untuk menerima kode OTP
        </p>

        <form method="POST" action="{{ route('otp.send') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button class="login-button">Kirim OTP</button>
        </form>

        <p class="footer-text">© 2025 Library Medical Faculty</p>
    </div>
</div>

</body>
</html>
