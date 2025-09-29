<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - Library Medical Faculty</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <div class="slideshow-container">
                <div class="slide" style="background-image: url('/icon/Library1.jpg');"></div>
                <div class="slide" style="background-image: url('/icon/Library2.jpg');"></div>
                <div class="slide" style="background-image: url('/icon/Library3.jpg');"></div>
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=1974&auto=format&fit=crop');"></div>
            </div>
        </div>

        <div class="login-form">
            <div class="form-header">
                <img src="icon/book.png" alt="Logo Unhas" class="logo">
                <div class="header-text">
                    <h2>Library Medical Faculty of</h2>
                    <h2>Hasanuddin University</h2>
                </div>
            </div>

            <form>
                <div class="input-group">
                    <label for="account">Account</label>
                    <input type="text" id="account" placeholder="Masukan Account">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Masukan Password">
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="form-links">
                <a href="#" class="forgot-password">Lupa Password?</a>
                <a href="#" class="signup-link">Belum Punya akun?</a>
            </div>

            <p class="footer-text">"© 2025 Library Medical Faculty of Hasanuddin University"</p>
        </div>
    </div>
</body>
</html>