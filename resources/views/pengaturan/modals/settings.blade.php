
<!-- BACKDROP -->
<div id="pengaturanBackdrop" class="modal-backdrop"></div>

<!-- MODAL BOX -->
<div id="pengaturanModal" class="modal-box">

    <!-- Header Modal -->
    <div class="modal-header">
        <h2>Pengaturan Akun</h2>
        <button class="modal-close" onclick="closePengaturan()">×</button>
    </div>

    <!-- Body Modal -->
    <div class="modal-body">

        <!-- Tab Navigation -->
        <div class="modal-tabs">
            <button class="modal-tab active" onclick="switchTab('profile')">
                <span>👤</span> Profil
            </button>

            <button class="modal-tab" onclick="switchTab('password')">
                <span>🔒</span> Password
            </button>

            <button class="modal-tab" onclick="switchTab('info')">
                <span>ℹ️</span> Info
            </button>
        </div>

        <!-- Tab Contents -->
        <div id="tab-profile" class="tab-content active">
            @include('pengaturan.part.profile')
        </div>

        <div id="tab-password" class="tab-content">
            @include('pengaturan.part.password')
        </div>

        <div id="tab-info" class="tab-content">
            @include('pengaturan.part.info')
        </div>

    </div>
</div>
