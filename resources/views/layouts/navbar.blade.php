<style>
    /* 🌈 SIDEBAR LAYOUT */
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: linear-gradient(180deg, #eef3ff, #fde2f3);
        padding: 24px 18px;
        border-right: 2px solid #e8e8ff;
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar-brand {
        padding: 10px 15px 20px;
    }

    .navbar-title {
        font-size: 20px;
        display: block;
        background: linear-gradient(90deg, #4f46e5, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none;
    }

    .sidebar-divider {
        border-top: 1px solid #d1d5db;
        margin: 10px 0 20px 0;
        opacity: 0.5;
    }

    /* NAV BUTTONS */
    .btn {
        border-radius: 12px;
        padding: 12px 16px !important;
        font-weight: 600;
        transition: 0.25s ease;
        margin-bottom: 8px;
        border: none;
    }

    .nav-btn-blue {
        background: #dce7ff;
        color: #1e3a8a;
    }
    .nav-btn-blue:hover {
        background: #bcd2ff;
        transform: translateX(5px);
        box-shadow: 4px 4px 12px rgba(100, 149, 255, 0.2);
        color: #1e3a8a;
    }

    .nav-btn-red {
        background: #ffd6e0;
        color: #b91c1c;
    }
    .nav-btn-red:hover {
        background: #ffb8c9;
        transform: translateX(5px);
        box-shadow: 4px 4px 12px rgba(255, 140, 170, 0.2);
        color: #b91c1c;
    }

    /* Penyesuaian Konten Utama agar tidak tertutup sidebar */
    body {
        padding-left: 260px; /* Lebar yang sama dengan sidebar */
        background-color: #f8fafc;
    }

    /* Responsive untuk HP: Sidebar jadi sembunyi atau kembali ke atas */
    @media (max-width: 991px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
            border-right: none;
            border-bottom: 2px solid #e8e8ff;
        }
        body {
            padding-left: 0;
        }
        .nav-item.mt-auto {
            margin-top: 10px !important;
        }
    }
</style>
<header class="sidebar shadow-sm">
    <div class="sidebar-brand">
        <a class="navbar-brand fw-bold navbar-title" href="{{ route('admin.dashboard') }}">
            ABSENSI
        </a>
    </div>

    <hr class="sidebar-divider">

    <nav class="sidebar-nav">
        <ul class="nav flex-column nav-gap">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="btn nav-btn-blue w-100 text-start">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.karyawan.index') }}" class="btn nav-btn-blue w-100 text-start">
                    <i class="bi bi-people me-2"></i> Karyawan
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.daftar') }}" class="btn nav-btn-blue w-100 text-start">
                    <i class="bi bi-person-plus me-2"></i> Daftar
                </a>
            </li>

            {{-- Logout dipindah ke bawah --}}
            <li class="nav-item mt-auto pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn nav-btn-red w-100 text-start">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</header>


