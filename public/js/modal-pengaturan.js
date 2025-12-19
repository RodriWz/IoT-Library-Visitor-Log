/**
 * ==========================================
 * MODAL PENGATURAN AKUN - JAVASCRIPT
 * ==========================================
 */

// State management untuk modal
const ModalState = {
    isOpen: false,
    activeTab: 'profile'
};

/**
 * Switch antara tab yang berbeda dengan animasi smooth
 * @param {string} tabName - Nama tab yang akan ditampilkan
 */
function switchTab(tabName) {
    // Validasi tab name
    if (!tabName) {
        console.warn('Tab name is required');
        return;
    }
    
    // Cari tab yang akan ditampilkan
    const selectedTab = document.getElementById('tab-' + tabName);
    if (!selectedTab) {
        console.warn(`Tab with id "tab-${tabName}" not found`);
        return;
    }
    
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
    
    // Tampilkan tab yang dipilih dengan delay untuk animasi
    setTimeout(() => {
        selectedTab.classList.add('active');
    }, 50);
    
    // Tandai tab button yang aktif
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
    
    // Update state
    ModalState.activeTab = tabName;
}

/**
 * Buka modal pengaturan dengan animasi
 */
function openPengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    
    if (!modal || !backdrop) {
        console.error('Modal or backdrop element not found');
        return;
    }
    
    // Cek jika modal sudah terbuka
    if (ModalState.isOpen) {
        return;
    }
    
    // Tambahkan class show untuk animasi
    backdrop.classList.add('show');
    modal.classList.add('show');
    
    // Prevent body scroll saat modal terbuka
    document.body.style.overflow = 'hidden';
    
    // Update state
    ModalState.isOpen = true;
    
    // Focus ke elemen pertama dalam modal (accessibility)
    setTimeout(() => {
        const firstInput = modal.querySelector('input, button');
        if (firstInput) {
            firstInput.focus();
        }
    }, 100);
}

/**
 * Tutup modal pengaturan dengan animasi
 */
function closePengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    
    if (!modal || !backdrop) {
        console.error('Modal or backdrop element not found');
        return;
    }
    
    // Cek jika modal sudah tertutup
    if (!ModalState.isOpen) {
        return;
    }
    
    // Hapus class show untuk animasi
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    // Kembalikan scroll body setelah animasi selesai
    setTimeout(() => {
        document.body.style.overflow = '';
    }, 300);
    
    // Update state
    ModalState.isOpen = false;
}

/**
 * Toggle modal (buka/tutup)
 */
function togglePengaturan() {
    if (ModalState.isOpen) {
        closePengaturan();
    } else {
        openPengaturan();
    }
}

/**
 * Reset form dalam tab tertentu
 * @param {string} tabName - Nama tab yang akan di-reset
 */
function resetTabForm(tabName) {
    const tab = document.getElementById('tab-' + tabName);
    if (tab) {
        const form = tab.querySelector('form');
        if (form) {
            form.reset();
            console.log(`Form in tab "${tabName}" has been reset`);
        }
    }
}

/**
 * Konfirmasi reset dengan pesan custom
 * @param {string} message - Pesan konfirmasi
 * @param {function} callback - Fungsi yang dijalankan jika user konfirmasi
 */
function confirmReset(message, callback) {
    if (confirm(message || 'Apakah Anda yakin ingin mereset? Tindakan ini tidak dapat dibatalkan.')) {
        if (typeof callback === 'function') {
            callback();
        }
    }
}

/**
 * Initialize modal setelah DOM loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    
    console.log('Initializing Modal Pengaturan...');
    
    // Event listener untuk tutup modal saat klik backdrop
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (backdrop) {
        backdrop.addEventListener('click', function(e) {
            // Pastikan klik pada backdrop, bukan elemen di dalamnya
            if (e.target === backdrop) {
                closePengaturan();
            }
        });
    }
    
    // Event listener untuk tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            const modal = document.getElementById('pengaturanModal');
            if (modal && modal.classList.contains('show')) {
                closePengaturan();
            }
        }
    });
    
    // Prevent modal close saat klik di dalam modal content
    const modal = document.getElementById('pengaturanModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Set tab pertama sebagai active saat load
    const firstTab = document.querySelector('.modal-tab');
    const firstContent = document.querySelector('.tab-content');
    
    if (firstTab && !firstTab.classList.contains('active')) {
        firstTab.classList.add('active');
    }
    
    if (firstContent && !firstContent.classList.contains('active')) {
        firstContent.classList.add('active');
    }
    
    // Handle foto profil preview
    const fotoInput = document.querySelector('input[type="file"]#foto-input, input[type="file"][name="foto"]');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi tipe file
                if (!file.type.startsWith('image/')) {
                    alert('Mohon pilih file gambar');
                    return;
                }
                
                // Validasi ukuran file (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB');
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.foto-preview img');
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Jika img tidak ada, buat baru
                        const previewContainer = document.querySelector('.foto-preview');
                        if (previewContainer) {
                            previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        }
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    console.log('Modal Pengaturan initialized successfully');
});

/**
 * Utility: Get current active tab
 * @returns {string} - Nama tab yang sedang aktif
 */
function getActiveTab() {
    return ModalState.activeTab;
}

/**
 * Utility: Check if modal is open
 * @returns {boolean}
 */
function isModalOpen() {
    return ModalState.isOpen;
}

/**
 * Export functions untuk global scope
 */
window.ModalPengaturan = {
    open: openPengaturan,
    close: closePengaturan,
    toggle: togglePengaturan,
    switchTab: switchTab,
    resetForm: resetTabForm,
    confirmReset: confirmReset,
    getActiveTab: getActiveTab,
    isOpen: isModalOpen
};

// Export untuk module system (jika diperlukan)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        openPengaturan,
        closePengaturan,
        togglePengaturan,
        switchTab,
        resetTabForm,
        confirmReset,
        getActiveTab,
        isModalOpen
    };
}