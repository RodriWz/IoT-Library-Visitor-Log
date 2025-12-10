<div class="modal-tab" id="tab-info">
    <h2>Informasi Aplikasi</h2>

    <div class="info-box">
        <p><strong>Nama Aplikasi:</strong> Medical Library System</p>
        <p><strong>Versi:</strong> 1.0.0</p>
        <p><strong>Developer:</strong> Fakultas Kedokteran UNHAS</p>
        <p><strong>Pengguna:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    </div>

    <p class="copyright">
        &copy; {{ date('Y') }} Medical Library — All Rights Reserved
    </p>
</div>
