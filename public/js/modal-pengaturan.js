/**
 * Switch antara tab yang berbeda
 * @param {string} tabName - Nama tab yang akan ditampilkan
 */
function switchTab(tabName) {
    // Sembunyikan semua tab content
    const allContents = document.querySelectorAll('.tab-content');
    allContents.forEach(content => {
        content.classList.remove('active');
    });
    
    // Hapus active dari semua tab button
    const allTabs = document.querySelectorAll('.modal-tab');
    allTabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Tampilkan tab yang dipilih
    const selectedTab = document.getElementById('tab-' + tabName);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    
    // Tandai tab button yang aktif
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
}

/**
 * Buka modal pengaturan
 */
function openPengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    
    if (modal && backdrop) {
        // Tambahkan class active untuk animasi
        backdrop.classList.add('active');
        modal.classList.add('active');
        
        // Prevent body scroll saat modal terbuka
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Tutup modal pengaturan
 */
function closePengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    
    if (modal && backdrop) {
        // Hapus class active untuk animasi
        modal.classList.remove('active');
        backdrop.classList.remove('active');
        
        // Kembalikan scroll body
        document.body.style.overflow = '';
    }
}

/**
 * Initialize modal setelah DOM loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Event listener untuk tutup modal saat klik backdrop
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (backdrop) {
        backdrop.addEventListener('click', closePengaturan);
    }
    
    // Event listener untuk tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('pengaturanModal');
            if (modal && modal.classList.contains('active')) {
                closePengaturan();
            }
        }
    });
    
    // Prevent modal close saat klik di dalam modal
    const modal = document.getElementById('pengaturanModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
});

/**
 * Export functions (jika menggunakan module)
 */
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        openPengaturan,
        closePengaturan,
        switchTab
    };
}