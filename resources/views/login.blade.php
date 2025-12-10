<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - Library Medical Faculty</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Tambahkan style khusus untuk slideshow --}}
    <style>
        .slide1 {
            background-image: url("{{ asset('img/img1.jpg') }}");
        }

        .slide2 {
            background-image: url("{{ asset('img/img2.jpg') }}");
        }

        .slide3 {
            background-image: url("{{ asset('img/img3.jpg') }}");
        }

        .slide4 {
            background-image: url("{{ asset('img/img4.jpg') }}");
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Bagian Kiri Slideshow -->
        <div class="login-image">
            <div class="slideshow-container">
                <div class="slide slide1"></div>
                <div class="slide slide2"></div>
                <div class="slide slide3"></div>
                <div class="slide slide4"></div>
            </div>
        </div>

        <!-- Bagian Kanan Form -->
        <div class="login-form">
            <div class="form-header">
                <img src="{{ asset('icon/logo.png') }}" alt="Logo Unhas" class="logo">
                <div class="header-text">
                    <h2>Library Medical Faculty of</h2>
                    <h2>Hasanuddin University</h2>
                </div>
            </div>

            <form method="POST" action="{{ route('login.auth') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label> <input type="email" id="email" name="email" placeholder="Masukan Email" value="{{ old('email') }}" required autofocus>

                    @error('email')
                    <div style="color: red; font-size: 0.875rem; margin-top: 5px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                    @error('password')
                    <div style="color: red; font-size: 0.875rem; margin-top: 5px;">
                        Password wajib diisi.
                    </div>
                    @enderror
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="form-links">
                <a href="#" class="forgot-password">Lupa Password?</a>
                <a href="{{ route('register') }}" class="signup-link">Belum Punya akun?</a>
            </div>

            <p class="footer-text">© 2025 Library Medical Faculty of Hasanuddin University</p>
        </div>
    </div>
</body>

</html>