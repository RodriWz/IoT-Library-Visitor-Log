document.addEventListener('DOMContentLoaded', function() {
    // Initialize Visitor Chart
    const visitorChart = document.getElementById('visitorChart');
    
    if (visitorChart) {
        const ctx = visitorChart.getContext('2d');
        
        // Sample data for the chart
        const data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Pengunjung Perpustakaan',
                data: [8500, 9200, 7800, 9500, 8600, 11000, 9800, 10500, 9200, 10800, 11500, 12500],
                backgroundColor: 'rgba(139, 0, 0, 0.1)',
                borderColor: '#8B0000',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#8B0000',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#2d3748',
                            font: {
                                size: 12,
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(45, 55, 72, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#8B0000',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(226, 232, 240, 0.5)'
                        },
                        ticks: {
                            color: '#718096',
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#718096',
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear'
                    }
                }
            }
        };

        new Chart(ctx, config);
    }

    // Add hover effects to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add click effects to day items
    const dayItems = document.querySelectorAll('.day-item');
    dayItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            dayItems.forEach(i => i.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // You can add additional functionality here
            const dayName = this.querySelector('.day-name').textContent;
            const dayCount = this.querySelector('.day-count').textContent;
            
            console.log(`Selected: ${dayName} - ${dayCount} visitors`);
        });
    });

    // Add loading state simulation
    function simulateLoading() {
        const table = document.querySelector('table tbody');
        if (table) {
            table.classList.add('loading');
            
            // Simulate API call delay
            setTimeout(() => {
                table.classList.remove('loading');
            }, 2000);
        }
    }

    // Simulate loading on page load
    setTimeout(simulateLoading, 1000);

    // Responsive table handling
    function handleTableResponsive() {
        const tableWrapper = document.querySelector('.table-wrapper');
        const table = document.querySelector('table');
        
        if (window.innerWidth < 768) {
            tableWrapper.style.overflowX = 'auto';
        } else {
            tableWrapper.style.overflowX = 'visible';
        }
    }

    // Initial call and event listener for resize
    handleTableResponsive();
    window.addEventListener('resize', handleTableResponsive);

    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Update stats with animation
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Animate stat numbers on scroll into view
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const numberElement = entry.target.querySelector('.number');
                if (numberElement && !numberElement.classList.contains('animated')) {
                    const currentValue = parseInt(numberElement.textContent.replace(/,/g, ''));
                    animateValue(numberElement, 0, currentValue, 2000);
                    numberElement.classList.add('animated');
                }
            }
        });
    }, observerOptions);

    // Observe all stat cards
    statCards.forEach(card => {
        observer.observe(card);
    });
});