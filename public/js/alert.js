@section('scripts')
<script>
function closeAlert() {
    const alert = document.getElementById('success-alert');
    if (alert) {
        // Tambahkan class hiding untuk trigger animation
        alert.classList.add('hiding');
        
        // Hapus element setelah animation selesai
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 300); // Match dengan duration transition CSS
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
</script>
@endsection