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

    {{-- ========================= --}}
    {{-- MODAL PENGATURAN DITARUH DI SINI --}}
    {{-- ========================= --}}
    <div id="pengaturanContainer">
        @include('pengaturan.modals.settings')
    </div>

    {{-- ========================= --}}
    {{-- LIBRARY EXTERNAL --}}
    {{-- ========================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ========================= --}}
    {{-- JAVASCRIPT UTAMA --}}
    {{-- ========================= --}}
    <script src="{{ asset('js/modal-pengaturan.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

    @stack('scripts')

</body>

</html>
