<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pengunjung - Library</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>

  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>Library Medical Faculty of Hasanuddin University</h2>
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li><a href="#"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a></li>
        <li><a href="#" class="active"><i class="fas fa-edit fa-fw"></i> Form Pengunjung</a></li>
        <li><a href="#"><i class="fas fa-users fa-fw"></i> Daftar Pengunjung</a></li>
        <li><a href="#"><i class="fas fa-chart-bar fa-fw"></i> Laporan Pengunjung</a></li>
      </ul>
    </nav>
    <div class="sidebar-footer">
      <ul>
        <li><a href="#"><i class="fas fa-cog fa-fw"></i> Pengaturan</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt fa-fw"></i> Keluar</a></li>
      </ul>
    </div>
  </aside>

  <main class="main-content">
    <header class="header">
      <h1>Form Pengunjung</h1>
      <p>menu pendaftaran</p>
    </header>

    <section class="form-container">
      <div class="form-header">
        <i class="fas fa-plus-circle"></i>
        <h3>Tambah data baru</h3>
      </div>

      <form action="#" method="POST">
        <div class="form-group">
          <label for="nama">Nama</label>
          <input type="text" id="nama" name="nama" placeholder="Masukan Nama Pengunjung">
        </div>
        <div class="form-group">
          <label for="nim">NIM</label>
          <input type="text" id="nim" name="nim" placeholder="Masukan NIM Pengunjung">
        </div>
        <div class="form-group">
          <label for="prodi">Prodi</label>
          <input type="text" id="prodi" name="prodi" placeholder="Masukan Prodi Pengunjung">
        </div>
        <div class="form-group">
          <label for="tujuan">Tujuan</label>
          <input type="text" id="tujuan" name="tujuan" placeholder="Masukan Tujuan Pengunjung">
        </div>

        <div class="form-group">
          <button type="submit">Daftar</button>
        </div>
      </form>
    </section>
  </main>

</body>

</html>