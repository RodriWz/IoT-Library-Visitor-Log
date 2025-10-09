// Tunggu hingga seluruh konten halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    // Ambil elemen yang menyimpan data dari Blade
    const dataContainer = document.getElementById('dashboard-data');
    if (!dataContainer) return;

    // Ambil dan parsing data JSON dari atribut data-*
    const dailyData = JSON.parse(dataContainer.dataset.daily);
    const monthlyData = JSON.parse(dataContainer.dataset.monthly);
    const yearlyData = JSON.parse(dataContainer.dataset.yearly);

    // Chart: Pengunjung Harian
    const dailyCtx = document.getElementById('dailyVisitorsChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: dailyData.labels,
            datasets: [{
                label: 'Pengunjung',
                data: dailyData.data,
                backgroundColor: (context) => {
                    if (context.dataIndex % 2 === 0) {
                        return '#E84545'; // Merah
                    } else {
                        return 'rgba(232, 69, 69, 0.5)'; // Merah lebih terang
                    }
                },
                borderRadius: 8,
                barPercentage: 0.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart: Pengunjung Bulanan
    const monthlyCtx = document.getElementById('monthlyVisitorsChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: monthlyData.labels,
            datasets: [{
                label: 'Pengunjung',
                data: monthlyData.data,
                backgroundColor: '#90CD93',
                borderRadius: 8,
                barPercentage: 0.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart: Pengunjung 5 Tahun Terakhir
    const yearlyCtx = document.getElementById('yearlyVisitorsChart').getContext('2d');
    new Chart(yearlyCtx, {
        type: 'line',
        data: {
            labels: yearlyData.labels,
            datasets: [{
                label: 'Pengunjung',
                data: yearlyData.data,
                borderColor: '#E84545',
                pointBackgroundColor: '#E84545',
                pointBorderColor: '#fff',
                pointHoverRadius: 8,
                pointHoverBorderWidth: 2,
                tension: 0.4, // Membuat garis melengkung
                fill: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value, index, values) {
                            return value / 1000 + 'K'; // Format label Y (50k, 70k)
                        }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
});