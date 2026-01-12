function closeAlert() {
    console.log("Tombol X ditekan!"); // Cek di F12 Console
    alert("Fungsi berjalan!");        // Munculkan popup browser biasa
    
    const alertBox = document.getElementById('success-alert');
    if (alertBox) {
        alertBox.remove();
    }
}

// Auto close setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(() => {
            closeAlert();
        }, 5000); // 5 detik
    }

    // Close ketika klik di mana saja di halaman (opsional)
    document.addEventListener('click', function(e) {
        const alert = document.getElementById('success-alert');
        if (alert && !alert.contains(e.target)) {
            closeAlert();
        }
    });

    // Close dengan Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAlert();
        }
    });
});
