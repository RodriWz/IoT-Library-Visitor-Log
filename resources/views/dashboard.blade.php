@extends('layout.app')

@section('title', 'Dashboard Perpustakaan')
@section('header-title', 'Dashboard')
@section('header-subtitle', 'Selamat datang di dashboard perpustakaan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=1.0">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Pengunjung harian</h3>
            <div class="number">5,000</div>
            <div class="description">pengunjung dalam seminggu</div>
        </div>
        
        <div class="stat-card">
            <h3>Pengunjung bulanan</h3>
            <div class="number">15,000</div>
            <div class="description">pengunjung</div>
        </div>
        
        <div class="stat-card">
            <h3>Pengunjung 5 tahun terakhir</h3>
            <div class="number">40,000</div>
            <div class="description">pengunjung</div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-section">
        <div class="chart-container">
            <div class="chart-header">
                <h2>Statistik Pengunjung</h2>
                <p>Grafik perkembangan pengunjung perpustakaan</p>
            </div>
            <canvas id="visitorChart"></canvas>
        </div>

        <div class="mini-stats">
            <h3>Ringkasan</h3>
            <div class="mini-stat-item">
                <div class="mini-stat-number">10,000</div>
                <div class="mini-stat-label">Target Tahunan</div>
            </div>
            <div class="mini-stat-item">
                <div class="mini-stat-number">85%</div>
                <div class="mini-stat-label">Pencapaian</div>
            </div>
            <div class="mini-stat-item">
                <div class="mini-stat-number">+12%</div>
                <div class="mini-stat-label">Pertumbuhan</div>
            </div>
        </div>
    </div>

    <!-- Weekly Chart -->
    <div class="weekly-chart">
        <h3>Pengunjung Minggu Ini</h3>
        <div class="days-grid">
            <div class="day-item">
                <div class="day-name">Sen</div>
                <div class="day-count">750</div>
            </div>
            <div class="day-item">
                <div class="day-name">Sel</div>
                <div class="day-count">820</div>
            </div>
            <div class="day-item">
                <div class="day-name">Rab</div>
                <div class="day-count">690</div>
            </div>
            <div class="day-item">
                <div class="day-name">Kam</div>
                <div class="day-count">910</div>
            </div>
            <div class="day-item">
                <div class="day-name">Jum</div>
                <div class="day-count">780</div>
            </div>
            <div class="day-item">
                <div class="day-name">Sab</div>
                <div class="day-count">650</div>
            </div>
            <div class="day-item">
                <div class="day-name">Min</div>
                <div class="day-count">580</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-container">
        <div class="table-header">
            <h2>Data Detail Pengunjung</h2>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Pengunjung</th>
                        <th>Kategori</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-01-15</td>
                        <td>850</td>
                        <td>Mahasiswa</td>
                        <td><span style="color: #10b981;">●</span> Aktif</td>
                    </tr>
                    <tr>
                        <td>2024-01-14</td>
                        <td>720</td>
                        <td>Umum</td>
                        <td><span style="color: #10b981;">●</span> Aktif</td>
                    </tr>
                    <tr>
                        <td>2024-01-13</td>
                        <td>690</td>
                        <td>Mahasiswa</td>
                        <td><span style="color: #10b981;">●</span> Aktif</td>
                    </tr>
                    <tr>
                        <td>2024-01-12</td>
                        <td>910</td>
                        <td>Dosen</td>
                        <td><span style="color: #10b981;">●</span> Aktif</td>
                    </tr>
                    <tr>
                        <td>2024-01-11</td>
                        <td>780</td>
                        <td>Mahasiswa</td>
                        <td><span style="color: #10b981;">●</span> Aktif</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection