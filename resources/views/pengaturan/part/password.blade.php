<div class="modal-tab" id="tab-password">
    <h2>Ubah Password</h2>

    <form action="{{ route('pengaturan.update.password') }}" method="POST">
        @csrf

        <label>Password Lama</label>
        <input type="password" name="password_lama">

        <label>Password Baru</label>
        <input type="password" name="password_baru">

        <label>Konfirmasi Password Baru</label>
        <input type="password" name="password_konfirmasi">

        <button type="submit" class="btn-save">Simpan Password</button>
    </form>
</div>
