<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Library System')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('icon/logo.png') }}">
    
    @stack('styles')
</head>
<body>
    {{-- Toast Notifications --}}
    <div class="toast-container">
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

        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="toast-notification error">
                    <div class="toast-content">
                        <div class="toast-icon">⚠️</div>
                        <div class="toast-body">
                            <span class="toast-title">Kesalahan!</span>
                            <span class="toast-msg">{{ $error }}</span>
                        </div>
                        <button type="button" class="toast-close" onclick="closeThisAlert(this)">&times;</button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @yield('content')

    <script>
        function closeThisAlert(btn) {
            const alert = btn.closest('.toast-notification');
            if (alert) {
                alert.classList.add('hiding');
                setTimeout(() => alert.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.toast-notification');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('hiding');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>