/**
 * ==========================================
 * MODAL PENGATURAN AKUN - JAVASCRIPT LENGKAP
 * ==========================================
 */

const ModalState = {
    isOpen: false,
    activeTab: 'profile'
};

function switchTab(tabName) {
    if (!tabName) return;
    const selectedTab = document.getElementById('tab-' + tabName);
    if (!selectedTab) return;
    
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
    
    setTimeout(() => { selectedTab.classList.add('active'); }, 50);
    if (event && event.currentTarget) event.currentTarget.classList.add('active');
    ModalState.activeTab = tabName;
}

function openPengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (!modal || !backdrop || ModalState.isOpen) return;
    
    backdrop.classList.add('show');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    ModalState.isOpen = true;
}

function closePengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (!modal || !backdrop || !ModalState.isOpen) return;
    
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    setTimeout(() => { document.body.style.overflow = ''; }, 300);
    ModalState.isOpen = false;
}

/**
 * Initialize modal & Real-time Sync
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. SYNC NAMA KE SIDEBAR
    // Pastikan input di modal memiliki atribut name="name"
    const inputNama = document.querySelector('input[name="name"]'); 
    const namaSidebar = document.getElementById('sidebarUserName'); 

    if (inputNama && namaSidebar) {
        inputNama.addEventListener('input', function() {
            namaSidebar.textContent = this.value || 'Admin Library';
        });
    }

    // 2. SYNC FOTO KE SIDEBAR
    const fotoInput = document.querySelector('input[type="file"]#foto-input, input[type="file"][name="foto"]');
    const fotoSidebar = document.getElementById('sidebarProfileImg');

    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update preview di modal
                    const previewModal = document.querySelector('.foto-preview img');
                    if (previewModal) previewModal.src = e.target.result;

                    // Update foto di sidebar
                    if (fotoSidebar) {
                        fotoSidebar.src = e.target.result;
                    } else {
                        // Jika sebelumnya default avatar (icon), refresh halaman mungkin diperlukan 
                        // atau buat elemen img baru secara dinamis di sini.
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // 3. Modal Listeners (Backdrop & Esc)
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (backdrop) {
        backdrop.addEventListener('click', (e) => { if (e.target === backdrop) closePengaturan(); });
    }
    document.addEventListener('keydown', (e) => {
        if ((e.key === 'Escape' || e.key === 'Esc') && ModalState.isOpen) closePengaturan();
    });
});

window.ModalPengaturan = {
    open: openPengaturan,
    close: closePengaturan,
    switchTab: switchTab
};