// ===== DASHBOARD JAVASCRIPT - CLEAN VERSION =====
// Medical Library - Hasanuddin University
// Version: 3.0

document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    initializeEventListeners();
});

/**
 * Initialize all charts (Daily & Prodi)
 */
function initializeCharts() {
    // Get data from blade template
    const dailyData = window.dailyData || [];
    const prodiData = window.prodiData || [];
    const colors = window.colors || ['#8B0000', '#C0392B', '#E74C3C', '#EC7063', '#F1948A', '#F5B7B1'];

    // Initialize Daily Visitors Chart
    initDailyChart(dailyData, colors);
    
    // Initialize Prodi Distribution Chart
    initProdiChart(prodiData, colors);
}

/**
 * Daily Visitors Line Chart
 */
function initDailyChart(dailyData, colors) {
    const dailyCtx = document.getElementById('dailyChart');
    if (!dailyCtx) return;

    new Chart(dailyCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: dailyData.map(d => d.day_name),
            datasets: [{
                label: 'Pengunjung',
                data: dailyData.map(d => d.count),
                borderColor: colors[0],
                backgroundColor: 'rgba(139, 0, 0, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors[0],
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: colors[0],
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Pengunjung: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

/**
 * Prodi Distribution Doughnut Chart
 */
function initProdiChart(prodiData, colors) {
    const prodiCtx = document.getElementById('prodiChart');
    if (!prodiCtx) return;

    new Chart(prodiCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: prodiData.map(p => p.prodi),
            datasets: [{
                data: prodiData.map(p => p.count),
                backgroundColor: colors.slice(0, prodiData.length),
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

/**
 * Initialize all event listeners
 */
function initializeEventListeners() {
    // Period buttons for chart filtering
    const periodButtons = document.querySelectorAll('.period-btn');
    periodButtons.forEach(button => {
        button.addEventListener('click', handlePeriodChange);
    });

    // Stat cards hover effect (optional enhancement)
    enhanceCardHoverEffects();
}

/**
 * Handle period change (week/month/year)
 */
function handlePeriodChange(event) {
    const button = event.currentTarget;
    const period = button.dataset.period;
    
    // Update active state
    document.querySelectorAll('.period-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
    
    // Fetch data berdasarkan period
    fetchChartData(period);
}

/**
 * Fetch chart data from API
 * @param {string} period - 'week', 'month', or 'year'
 */
function fetchChartData(period) {
    // Show loading state
    const chart = Chart.getChart('dailyChart');
    if (!chart) return;

    // Disable buttons
    const buttons = document.querySelectorAll('.period-btn');
    buttons.forEach(btn => btn.disabled = true);

    // Fetch data dari server
    fetch(`/dashboard/chart-data?period=${period}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Update chart dengan data baru
            updateDailyChart(data.labels, data.counts);
            
            // Re-enable buttons
            buttons.forEach(btn => btn.disabled = false);
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
            
            // Re-enable buttons
            buttons.forEach(btn => btn.disabled = false);
            
            // Show error notification
            alert('Gagal memuat data. Silakan coba lagi.');
        });
}

/**
 * Update daily chart with new data
 * @param {Array} labels - Chart labels
 * @param {Array} data - Chart data
 */
function updateDailyChart(labels, data) {
    const chart = Chart.getChart('dailyChart');
    if (chart) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = data;
        chart.update('active');
    }
}

/**
 * Optional: Enhance card hover effects
 */
function enhanceCardHoverEffects() {
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
}
