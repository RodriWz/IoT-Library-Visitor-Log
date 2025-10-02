<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .btn {
            padding: 10px 20px;
            background: crimson;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }
        .btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat datang di Dashboard 🎉</h1>
        <p>Anda sudah berhasil login ke sistem.</p>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Logout</button>
        </form>
    </div>
</body>
</html>
