<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Library</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Library Medical Faculty of Hasanuddin University</h2>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="pengunjung"><i class="fas fa-edit"></i> Form Pengunjung</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Daftar Pengunjung</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Laporan Pengunjung</a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
             <ul>
                <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
        </div>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Dashboard</h1>
            <p>welcome back, student</p>
        </header>

        <section class="charts-grid">
            <div class="chart-card" id="daily-chart-card">
                <div class="chart-card-header">
                    <div>
                        <h4>Pengunjung harian</h4>
                        <p>5.000 pengunjung dalam seminggu</p>
                    </div>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                </div>
                <canvas id="dailyVisitorsChart"></canvas>
            </div>

            <div class="chart-card" id="monthly-chart-card">
                 <div class="chart-card-header">
                    <div>
                        <h4>Pengunjung bulanan</h4>
                        <p>15.000 pengunjung</p>
                    </div>
                     <div class="icon"><i class="fas fa-chart-line"></i></div>
                </div>
                <canvas id="monthlyVisitorsChart"></canvas>
            </div>

            <div class="chart-card" id="yearly-chart-card">
                 <div class="chart-card-header">
                    <div>
                        <h4>Pengunjung 5 tahun terakhir</h4>
                        <p>40.000 pengunjung</p>
                    </div>
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                </div>
                <canvas id="yearlyVisitorsChart"></canvas>
            </div>
        </section>
    </main>
    
    <div id="dashboard-data" 
         data-daily='{{ json_encode($dailyVisitors) }}' 
         data-monthly='{{ json_encode($monthlyVisitors) }}'
         data-yearly='{{ json_encode($yearlyVisitors) }}'
         style="display: none;">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>