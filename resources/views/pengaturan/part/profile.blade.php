<div class="modal-tab active" id="tab-profil">
    <h2>Pengaturan Profil</h2>

    <form action="{{ route('pengaturan.update.profile') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Foto Profil</label>
        <input type="file" name="foto">

        <label>Nama</label>
        <input type="text" name="name" value="{{ auth()->user()->name }}">

        <label>Email</label>
        <input type="email" value="{{ auth()->user()->email }}" name="email">

        <button type="submit" class="btn-save">Simpan Perubahan</button>
    </form>
</div>
