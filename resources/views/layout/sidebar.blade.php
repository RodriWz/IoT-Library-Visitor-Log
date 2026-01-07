<aside class="sidebar">
    <div class="sidebar-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="/icon/logo.png" alt="UNHAS Logo" class="sidebar-logo">
            </div>
            <div class="header-text">
                <h2>Medical Library</h2>
                <div class="university-name">Hasanuddin University</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/formpengunjung"
                    class="{{ request()->is('formpengunjung') || request()->is('pengunjung*') ? 'active' : '' }}">
                    <i class="fas fa-edit"></i>
                    <span>Form Pengunjung</span>
                </a>
            </li>
            <li>
                <a href="/daftarpengunjung" class="{{ request()->is('daftarpengunjung') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Daftar Pengunjung</span>
                </a>
            </li>
            <li>
                <a href="/laporanpengunjung" class="{{ request()->is('laporanpengunjung') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan Pengunjung</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="user-info">
        <div class="user-avatar" id="sidebarAvatarContainer">
            @if(auth()->user()->foto)
                <img src="{{ asset('uploads/profile/' . auth()->user()->foto) }}" 
                     alt="Profile" 
                     class="user-profile-img"
                     id="sidebarProfileImg">
            @else
                <div class="default-avatar" id="sidebarDefaultAvatar">
                    <i class="fas fa-user-md"></i>
                </div>
            @endif
        </div>
        <div class="user-details">
            <div class="user-name" id="sidebarUserName">{{ auth()->user()->name ?? 'Admin Library' }}</div>
            <div class="user-role">Medical Faculty</div>
        </div>
    </div>

    <div class="sidebar-footer">
        <ul class="sidebar-menu">
            <li>
                <a href="javascript:void(0)" onclick="openPengaturan()">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </li>

            <li>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>