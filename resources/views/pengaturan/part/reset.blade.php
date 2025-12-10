<div class="modal-tab" id="tab-reset">
    <h2>Reset Pengaturan</h2>

    <p class="desc">Gunakan menu ini untuk mereset beberapa data profil Anda.</p>

    <form action="{{ route('pengaturan.reset.foto') }}" method="POST">
        @csrf
        <button type="submit" class="btn-reset">
            Reset Foto Profil
        </button>
    </form>

    <form action="{{ route('pengaturan.reset.password') }}" method="POST">
        @csrf
        <button type="submit" class="btn-reset">
            Reset Password ke Default
        </button>
    </form>

    <form action="{{ route('pengaturan.reset.semua') }}" method="POST">
        @csrf
        <button type="submit" class="btn-danger">
            Reset Semua Pengaturan
        </button>
    </form>
</div>
