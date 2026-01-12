<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="single-form">
    <div class="center-form">

        <div class="form-header">
            <img src="{{ asset('icon/logo.png') }}" class="logo">
            <h2>Reset Password</h2>
        </div>

        <form method="POST" action="{{ route('otp.reset') }}">
            @csrf

            <input type="hidden" name="email" value="{{ session('email') }}">

            <div class="input-group">
                <label>OTP</label>
                <input type="text" name="otp" required>
                @error('otp')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label>Password Baru</label>
                <input type="password" name="password" required>
            </div>

            <div class="input-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button class="login-button">Reset Password</button>
        </form>

        <p class="footer-text">© 2025 Library Medical Faculty</p>
    </div>
</div>

</body>
</html>
