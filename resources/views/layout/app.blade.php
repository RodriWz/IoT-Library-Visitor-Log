<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Library')</title>

    {{-- Fonts dan Icon --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
    @stack('styles')
</head>

<body>

   <div class="toast-container">
        {{-- 1. Notifikasi Sukses --}}
        @if(session('success'))
            <div class="toast-notification success">
                <div class="toast-content">
                    <div class="toast-icon">✅</div>
                    <div class="toast-body">
                        <span class="toast-title">Berhasil!</span>
                        <span class="toast-msg">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="toast-close" onclick="closeThisAlert(this)">&times;</button>
                </div>
            </div>
        @endif

        {{-- 2. Notifikasi Error General --}}
        @if(session('error'))
            <div class="toast-notification error">
                <div class="toast-content">
                    <div class="toast-icon">❌</div>
                    <div class="toast-body">
                        <span class="toast-title">Gagal!</span>
                        <span class="toast-msg">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="toast-close" onclick="closeThisAlert(this)">&times;</button>
                </div>
            </div>
        @endif

        {{-- 3. Notifikasi Error Validasi (PENTING: Agar error foto masuk sini) --}}
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="toast-notification error">
                    <div class="toast-content">
                        <div class="toast-icon">⚠️</div>
                        <div class="toast-body">
                            <span class="toast-title">Kesalahan Input!</span>
                            <span class="toast-msg">{{ $error }}</span>
                        </div>
                        <button type="button" class="toast-close" onclick="closeThisAlert(this)">&times;</button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- SIDEBAR --}}
    @include('layout.sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="main-content">
        <header class="header">
            <h1>@yield('header-title', 'Dashboard')</h1>
            <p>@yield('header-subtitle', 'Welcome back, student')</p>
        </header>

        @yield('content')
    </main>

    {{-- MODAL PENGATURAN --}}
    <div id="pengaturanContainer">
        @include('pengaturan.modals.settings')
    </div>

    {{-- LIBRARY EXTERNAL --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- JAVASCRIPT UTAMA --}}
    <script src="{{ asset('js/modal-pengaturan.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

    <script>
        // Fungsi untuk menutup notifikasi secara manual
        function closeThisAlert(btn) {
            const alert = btn.closest('.toast-notification');
            if (alert) {
                alert.classList.add('hiding');
                setTimeout(() => alert.remove(), 300);
            }
        }

        // Otomatis tutup semua notifikasi setelah 5 detik
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.toast-notification');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('hiding');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
        // Jika ada error validasi, otomatis buka modal agar user tahu kesalahannya
        @if($errors->any())
            openPengaturan();
        @endif
    });
    </script>

    @stack('scripts')

</body>

</html>