<nav class="sidebar-karyawan">
    <div class="sidebar-header">
        <a class="brand-wrapper" href="{{ route('karyawan.dashboard') }}">
            <div class="brand-box">
            </div>
            <span class="brand-text">Absen<span class="text-blue">Karyawan</span></span>
        </a>
    </div>

    <div class="status-card">
        <div class="status-content">
            <div class="date-text">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</div>
            <div id="live-clock" class="clock-text">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }}</div>
        </div>
        <div class="status-alert">
    <div class="alert-info">
        <p class="m-0 fw-bold">Batas Masuk: 07:00 - 08:00</p>
        <p class="m-0 small opacity-75">Denda: Rp 238/mnt</p>
    </div>
</div>
    </div>


    <div class="sidebar-content">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('karyawan.absensi') }}" 
                   class="nav-link-custom {{ request()->routeIs('karyawan.absensi') ? 'active' : '' }}">
                    <span>Absensi Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('karyawan.detail_kehadiran') }}" 
                   class="nav-link-custom {{ request()->routeIs('karyawan.detail_kehadiran') ? 'active' : '' }}">
                    <span>Detail Kehadiran</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <span>Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</nav>

<style>
    :root {
        --primary-blue: #3b82f6;
        --soft-blue: #eff6ff;
        --danger-red: #ef4444;
        --soft-red: #fef2f2;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --sidebar-width: 280px;
    }

    body {
        padding-left: var(--sidebar-width);
        background-color: #f8fafc;
        transition: padding 0.3s ease;
    }

    .sidebar-karyawan {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: #ffffff;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        padding: 30px 20px;
        z-index: 1000;
    }

    /* Brand */
    .sidebar-header { margin-bottom: 35px; }
    .brand-wrapper { text-decoration: none; display: flex; align-items: center; gap: 12px; }
    .brand-box {
        width: 35px; height: 35px;
        background: var(--primary-blue);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }
    .brand-text { font-size: 1.2rem; font-weight: 800; color: var(--text-main); }
    .text-blue { color: var(--primary-blue); }

    /* Info Card */
    .status-card {
        background: var(--soft-blue);
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 30px;
    }
    .date-text { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 4px; }
    .clock-text { font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 15px; }
    
    .status-alert {
        background: #ffffff;
        padding: 12px;
        border-radius: 12px;
        border-left: 4px solid var(--danger-red);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .alert-info { color: var(--danger-red); font-size: 0.8rem; }

    /* Navigation */
    .nav-divider {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: 1px;
        margin-bottom: 15px;
        padding-left: 10px;
    }
    .nav-menu { list-style: none; padding: 0; margin: 0; }
    .nav-link-custom {
        display: block;
        padding: 14px 20px;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 600;
        border-radius: 12px;
        margin-bottom: 8px;
        transition: all 0.2s ease;
    }
    .nav-link-custom:hover {
        background: var(--soft-blue);
        color: var(--primary-blue);
        padding-left: 25px;
    }
    .nav-link-custom.active {
        background: var(--primary-blue);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    /* Logout */
    .sidebar-footer { margin-top: auto; }
    .btn-logout {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #fee2e2;
        background: var(--soft-red);
        color: var(--danger-red);
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-logout:hover { background: var(--danger-red); color: white; }

    @media (max-width: 991px) {
        body { padding-left: 0; }
        .sidebar-karyawan { width: 100%; height: auto; position: relative; border-right: none; }
    }
</style>

<script>
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: false 
        }).replace(/\./g, ':');
        document.getElementById('live-clock').textContent = timeString;
    }
    setInterval(updateClock, 1000);
</script>