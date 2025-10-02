<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page - Library Medical Faculty</title>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        .slide1 { background-image: url("{{ asset('img/library1.jpg') }}"); }
        .slide2 { background-image: url("{{ asset('img/library2.jpg') }}"); }
        .slide3 { background-image: url("{{ asset('img/library3.jpg') }}"); }
        .slide4 { background-image: url("{{ asset('img/library4.jpg') }}"); }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Slideshow -->
        <div class="login-image">
            <div class="slideshow-container">
                <div class="slide slide1"></div>
                <div class="slide slide2"></div>
                <div class="slide slide3"></div>
                <div class="slide slide4"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="login-form">
            <div class="form-header">
                <img src="{{ asset('logo/logo.png') }}" alt="Logo Unhas" class="logo">
                <div class="header-text">
                    <h2>Library Medical Faculty of</h2>
                    <h2>Hasanuddin University</h2>
                </div>
            </div>

            {{-- Error Message --}}
            @if ($errors->any())
                <div style="color:red; margin-bottom:15px;">
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="input-group">
                    <label for="name">Account Name</label>
                    <input type="text" id="name" name="name" placeholder="Masukan Nama Akun" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukan Email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                </div>
                <div class="input-group">
                    <label for="password_confirmation">Ulangi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" required>
                </div>
                
                <button type="submit" class="login-button">Create</button>
            </form>

            <p class="footer-text">© 2025 Library Medical Faculty of Hasanuddin University</p>
        </div>
    </div>
</body>
</html>
