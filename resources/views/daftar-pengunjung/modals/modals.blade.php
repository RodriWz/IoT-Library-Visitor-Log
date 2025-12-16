<!-- Modal Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Edit Data Pengunjung</div>
        <form id="editForm">
            @csrf
            @method('PUT')
            
            <div class="modal-input-group">
                <label>Nama</label>
                <input type="text" name="nama" id="editNama" class="modal-input" required>
            </div>
            
            <div class="modal-input-group">
                <label>NIM</label>
                <input type="text" name="nim" id="editNim" class="modal-input" required>
            </div>
            
            <div class="modal-input-group">
                <label>Prodi</label>
                <input type="text" name="prodi" id="editProdi" class="modal-input" required>
            </div>
            
            <div class="modal-input-group">
                <label>Tujuan</label>
                <input type="text" name="tujuan" id="editTujuan" class="modal-input" required>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>