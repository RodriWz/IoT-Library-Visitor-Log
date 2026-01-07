@extends('layout.app')

@section('title', 'Dashboard Perpustakaan')
@section('header-title', 'Dashboard')
@section('header-subtitle', 'Statistik pengunjung perpustakaan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=3.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Stats Grid - HANYA 3 CARD INI -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Pengunjung Hari Ini</h3>
            <div class="number">{{ number_format($todayVisitors) }}</div>
            <div class="description">
                <span class="change {{ $todayChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $todayChange >= 0 ? 'up' : 'down' }}"></i> 
                    {{ abs($todayChange) }}% dari kemarin
                </span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <h3>Pengunjung Bulan Ini</h3>
            <div class="number">{{ number_format($monthVisitors) }}</div>
            <div class="description">
                <span class="change {{ $monthChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $monthChange >= 0 ? 'up' : 'down' }}"></i> 
                    {{ abs($monthChange) }}% dari bulan lalu
                </span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Total Pengunjung</h3>
            <div class="number">{{ number_format($totalVisitors) }}</div>
            <div class="description">Sejak awal pencatatan</div>
        </div>
    </div>

    <!-- Main Charts -->
    <div class="chart-section">
        <div class="chart-container">
            <div class="chart-header">
                <h2><i class="fas fa-chart-line"></i> Tren Pengunjung 7 Hari Terakhir</h2>
                <div class="chart-period">
                    <button class="period-btn active" data-period="week">Hari</button>
                    <button class="period-btn" data-period="month">Minggu</button>
                    <button class="period-btn" data-period="year">Bulan</button>
                </div>
            </div>
            <canvas id="dailyChart"></canvas>
        </div>

        <div class="mini-stats">
            <h3><i class="fas fa-chart-pie"></i> Distribusi Program Studi</h3>
            <div class="distribution-chart">
                <canvas id="prodiChart"></canvas>
            </div>
            <div class="category-list">
                @foreach($prodiDistribution->take(6) as $prodi)
                <div class="category-item">
                    <div class="category-info">
                        <span class="category-dot" style="background: {{ $colors[$loop->index] ?? '#8B0000' }}"></span>
                        <span class="category-name">{{ $prodi->prodi }}</span>
                    </div>
                    <span class="category-count">{{ $prodi->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pass data from PHP to JavaScript
    window.dailyData = @json($dailyVisitors);
    window.prodiData = @json($prodiDistribution);
    window.colors = @json($colors);
</script>
<script src="{{ asset('js/dashboard.js') }}?v=3.0"></script>
@endpush