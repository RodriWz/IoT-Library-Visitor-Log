<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengunjung</title>
    <link rel="stylesheet" href="{{ asset('css/formpengunjung.css') }}">
</head>
<body>

    <div class="sidebar">
        <h2>Library Medical Faculty of<br>Hasanuddin University</h2>
        <a href="#" class="menu-item">Dashboard</a>
        <a href="#" class="menu-item active">Form Pengunjung</a>
        <a href="#" class="menu-item">Daftar Pengunjung</a>
        <a href="#" class="menu-item">Laporan Pengunjung</a>

        <div class="bottom-menu">
            <a href="#" class="menu-item">Pengaturan</a>
            <a href="#" class="menu-item">Keluar</a>
        </div>
    </div>

    <div class="content">
        <h1>Form Pengunjung</h1>
        <small>menu pendaftaran</small>

        <div class="form-container">
            <div class="add-icon">👤 + Tambah data baru</div>

            <form action="/pengunjung/store" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" placeholder="Masukkan Nama Pengunjung" required>
                </div>

                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" placeholder="Masukkan NIM Pengunjung" required>
                </div>

                <div class="form-group">
                    <label>Prodi</label>
                    <input type="text" name="prodi" placeholder="Masukkan Prodi Pengunjung" required>
                </div>

                <div class="form-group">
                    <label>Tujuan</label>
                    <input type="text" name="tujuan" placeholder="Masukkan Tujuan Pengunjung" required>
                </div>

                <button type="submit" class="submit-btn">Daftar</button>
            </form>
        </div>
    </div>

</body>
</html>