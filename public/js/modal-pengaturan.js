// State untuk melacak status modal
const ModalState = { isOpen: false };

function openPengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (!modal || !backdrop) return;

    backdrop.classList.add('show');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    ModalState.isOpen = true;
}

function closePengaturan() {
    const modal = document.getElementById('pengaturanModal');
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (!modal || !backdrop) return;

    modal.classList.remove('show');
    backdrop.classList.remove('show');
    document.body.style.overflow = '';
    ModalState.isOpen = false;
}

/**
 * FUNGSI SWITCH TAB (Perbaikan Utama)
 * Mengontrol perpindahan antar tab Profil, Password, dan Info
 */
function switchTab(tabName) {
    // 1. Sembunyikan semua konten tab
    document.querySelectorAll('#pengaturanModal .tab-content').forEach(content => {
        content.classList.remove('active');
    });

    // 2. Nonaktifkan semua tombol navigasi tab
    document.querySelectorAll('#pengaturanModal .modal-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // 3. Tampilkan konten yang dipilih (ID: tab-profile, tab-password, dsb)
    const targetContent = document.getElementById('tab-' + tabName);
    if (targetContent) {
        targetContent.classList.add('active');
    }

    // 4. Tambahkan class active pada tombol yang diklik
    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Preview Foto Profil
    const fotoInput = document.querySelector('input[name="foto"]');
    const previewImg = document.getElementById('modalPreviewImg');

    if (fotoInput && previewImg) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => previewImg.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    }

    // Tutup modal saat klik backdrop
    const backdrop = document.getElementById('pengaturanBackdrop');
    if (backdrop) {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) closePengaturan();
        });
    }
});

// Ekspos fungsi ke global agar onclick di HTML berjalan
window.openPengaturan = openPengaturan;
window.closePengaturan = closePengaturan;
window.switchTab = switchTab;