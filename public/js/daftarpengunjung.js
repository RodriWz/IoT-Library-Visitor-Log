let selectedRow = null;
let selectedRowId = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    initializeSearch();
    initializeRowSelection();
    initializeEditButton();
    initializeDeleteButton();
    initializeFormSubmissions();
    disableButtons();
    
    console.log('App initialized successfully');
}

// 1. FITUR SEARCH
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const tableBody = document.querySelector('tbody');
    
    if (!searchInput || !tableBody) {
        console.error('Search elements not found!');
        return;
    }

    function searchTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const rows = tableBody.querySelectorAll('tr');
        
        console.log('Searching for:', searchTerm);
        
        let visibleRows = 0;
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let found = false;
            
            // Cek setiap cell dalam row
            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                    found = true;
                }
            });
            
            // Tampilkan atau sembunyikan row berdasarkan hasil pencarian
            if (found || searchTerm === '') {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });
        
        console.log('Visible rows after search:', visibleRows);
        
        // Reset seleksi jika row yang dipilih disembunyikan
        if (selectedRow && selectedRow.style.display === 'none') {
            resetSelection();
        }
    }

    // Debounce function untuk optimize performance
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Gunakan debounce untuk search (300ms delay)
    const debouncedSearch = debounce(searchTable, 300);
    
    searchInput.addEventListener('input', debouncedSearch);

    // Tambahkan event listener untuk menghapus pencarian dengan Escape key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            searchTable();
            this.blur();
        }
    });

    // Clear button functionality (jika ada)
    const searchClear = document.querySelector('.search-clear');
    if (searchClear) {
        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            searchTable();
            searchInput.focus();
        });
    }
}

// 2. SELEKSI BARIS
function initializeRowSelection() {
    const tableBody = document.querySelector('tbody');
    if (!tableBody) {
        console.error('Table body not found!');
        return;
    }

    function handleRowClick() {
        // Skip jika row sedang disembunyikan oleh search
        if (this.style.display === 'none') {
            return;
        }

        // Hapus seleksi sebelumnya
        if (selectedRow) {
            selectedRow.classList.remove("selected");
        }
        
        // Set seleksi baru
        selectedRow = this;
        selectedRowId = this.getAttribute('data-id');
        this.classList.add("selected");
        
        enableButtons();
        console.log('Selected row ID:', selectedRowId);
    }

    // Gunakan event delegation untuk handle row clicks
    tableBody.addEventListener('click', function(e) {
        const row = e.target.closest('tr');
        if (row && row.parentNode === tableBody) {
            handleRowClick.call(row);
        }
    });

    // Juga inisialisasi rows yang sudah ada
    const rows = tableBody.querySelectorAll("tr");
    console.log('Found rows:', rows.length);
}

// 3. TOMBOL EDIT
function initializeEditButton() {
    const editButton = document.getElementById("editButton");
    if (!editButton) {
        console.error('Edit button not found!');
        return;
    }
    
    editButton.addEventListener("click", function() {
        if (!selectedRow) {
            alert("Pilih salah satu data terlebih dahulu!");
            return;
        }

        const cells = selectedRow.querySelectorAll("td");
        
        // Isi form edit
        document.getElementById("editNama").value = cells[1].textContent.trim();
        document.getElementById("editNim").value = cells[2].textContent.trim();
        document.getElementById("editProdi").value = cells[3].textContent.trim();
        document.getElementById("editTujuan").value = cells[4].textContent.trim();

        showModal('editModal');
    });
}

// 4. TOMBOL HAPUS
function initializeDeleteButton() {
    const deleteButton = document.getElementById("deleteButton");
    if (!deleteButton) {
        console.error('Delete button not found!');
        return;
    }
    
    deleteButton.addEventListener("click", function() {
        if (!selectedRow || !selectedRowId) {
            alert("Pilih data yang akan dihapus!");
            return;
        }

        if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            return;
        }

        deleteData();
    });
}

// 5. HANDLE FORM SUBMISSIONS
function initializeFormSubmissions() {
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            updateData();
        });
    } else {
        console.error('Edit form not found!');
    }
}

// 6. FUNGSI UPDATE DATA
function updateData() {
    if (!selectedRowId) {
        alert('Tidak ada data yang dipilih!');
        return;
    }

    const submitButton = document.querySelector('#editForm .btn-save');
    const url = `/pengunjung/${selectedRowId}/update`;
    
    console.log('Updating data with URL:', url);
    
    // Loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Menyimpan...';

    // Prepare form data
    const formData = new FormData();
    formData.append('_token', getCsrfToken());
    formData.append('nama', document.getElementById('editNama').value);
    formData.append('nim', document.getElementById('editNim').value);
    formData.append('prodi', document.getElementById('editProdi').value);
    formData.append('tujuan', document.getElementById('editTujuan').value);

    console.log('Sending data:', {
        nama: document.getElementById('editNama').value,
        nim: document.getElementById('editNim').value,
        prodi: document.getElementById('editProdi').value,
        tujuan: document.getElementById('editTujuan').value
    });

    // Send AJAX request
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            alert('Data berhasil diupdate!');
            closeModal('editModal');
            updateRowInTable(data.data);
        } else {
            throw new Error(data.message || 'Unknown error from server');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error: ' + error.message);
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = 'Simpan Perubahan';
    });
}

// 7. FUNGSI DELETE DATA
function deleteData() {
    const deleteButton = document.getElementById("deleteButton");
    const url = `/pengunjung/${selectedRowId}/delete`;
    
    console.log('Deleting data with URL:', url);
    
    // Loading state
    deleteButton.disabled = true;
    deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    const formData = new FormData();
    formData.append('_token', getCsrfToken());

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Delete response:', data);
        if (data.success) {
            alert('Data berhasil dihapus!');
            selectedRow.remove();
            resetSelection();
        } else {
            throw new Error(data.message || 'Unknown error from server');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        alert('Error: ' + error.message);
    })
    .finally(() => {
        deleteButton.disabled = false;
        deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
    });
}

// 8. UPDATE TABEL SETELAH EDIT
function updateRowInTable(updatedData) {
    if (!selectedRow) return;
    
    const cells = selectedRow.querySelectorAll('td');
    cells[1].textContent = updatedData.nama;
    cells[2].textContent = updatedData.nim;
    cells[3].textContent = updatedData.prodi;
    cells[4].textContent = updatedData.tujuan;
    
    console.log('Table updated successfully');
}

// 9. HELPER FUNCTION UNTUK CSRF TOKEN
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// 10. FUNGSI MODAL
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = "flex";
        setTimeout(() => {
            modal.classList.add("show");
        }, 10);
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove("show");
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }
}

// 11. ENABLE/DISABLE BUTTONS
function enableButtons() {
    const editButton = document.getElementById("editButton");
    const deleteButton = document.getElementById("deleteButton");
    
    if (editButton && deleteButton) {
        editButton.disabled = false;
        deleteButton.disabled = false;
        editButton.style.opacity = "1";
        deleteButton.style.opacity = "1";
        editButton.style.cursor = "pointer";
        deleteButton.style.cursor = "pointer";
    }
}

function disableButtons() {
    const editButton = document.getElementById("editButton");
    const deleteButton = document.getElementById("deleteButton");
    
    if (editButton && deleteButton) {
        editButton.disabled = true;
        deleteButton.disabled = true;
        editButton.style.opacity = "0.6";
        deleteButton.style.opacity = "0.6";
        editButton.style.cursor = "not-allowed";
        deleteButton.style.cursor = "not-allowed";
    }
}

// 12. RESET SELECTION
function resetSelection() {
    if (selectedRow) {
        selectedRow.classList.remove("selected");
    }
    selectedRow = null;
    selectedRowId = null;
    disableButtons();
}

// 13. EVENT LISTENER UNTUK KLIK DI LUAR MODAL
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        closeModal(e.target.id);
    }
});

// ESC KEY UNTUK CLOSE MODAL
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const openModal = document.querySelector('.modal.show');
        if (openModal) {
            closeModal(openModal.id);
        }
    }
});

// 14. HANDLE DYNAMIC CONTENT (jika ada pagination atau AJAX load)
function refreshRowSelection() {
    resetSelection();
    initializeRowSelection();
}