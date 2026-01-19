@extends('layouts.app')
@include('layouts.navbar')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary: #4f46e5;
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        --primary-soft: #eef2ff;
        --secondary: #64748b;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --background: #f8fafc;
        --card-bg: #ffffff;
    }

    body {
        background-color: var(--background);
        background-image: radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%), 
                          radial-gradient(at 100% 0%, rgba(124, 58, 237, 0.05) 0px, transparent 50%);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1e293b;
    }

    .main-container {
        padding: 40px 20px;
        max-width: 1200px;
        margin: auto;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header Styling */
    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -1px;
        margin-bottom: 5px;
    }

    .sub-title {
        color: var(--secondary);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Button Tambah Premium */
    .btn-add-custom {
        background: var(--primary-gradient);
        color: white;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.85rem;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        display: inline-flex;
        align-items: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-add-custom:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        color: white;
    }

    /* Card Table Luxury */
    .glass-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-top: 30px;
    }

    .table thead th {
        background: #f8fafc;
        color: var(--secondary);
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f8fafc;
        transition: all 0.2s ease;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f5f9;
        transform: scale(1.002);
    }

    /* Avatar Minimalist */
    .avatar-circle {
        width: 42px;
        height: 42px;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 800;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
    }

    /* Badge Jabatan */
    .badge-posisi {
        background: var(--primary-soft);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        border: 1px solid rgba(79, 70, 229, 0.1);
    }

    /* Text Gaji */
    .text-gaji {
        font-weight: 800;
        color: var(--success);
        font-size: 0.95rem;
    }

    /* Action Buttons Soft Style */
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: scale(1.15) rotate(5deg);
    }

    .btn-edit-soft {
        background-color: #fffbeb;
        color: #b45309;
        box-shadow: 0 4px 6px -1px rgba(180, 83, 9, 0.1);
    }

    .btn-delete-soft {
        background-color: #fef2f2;
        color: #b91c1c;
        box-shadow: 0 4px 6px -1px rgba(185, 28, 28, 0.1);
    }

    /* Alert Styling */
    .alert-custom {
        border-radius: 18px;
        border-left: 5px solid var(--success);
        background: #ffffff;
        color: #166534;
        padding: 18px 25px;
        font-weight: 600;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        animation: slideInRight 0.5s ease-out;
    }

    @keyframes slideInRight {
        from { transform: translateX(50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

</style>

<div class="main-container">

    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-4">
        <div>
            <h2 class="page-title">Manajemen Karyawan</h2>
            <p class="sub-title">Kelola informasi tim Anda dengan mudah. Total <span class="badge bg-primary rounded-pill px-3">{{ $users->count() }} Orang</span></p>
        </div>

        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-add-custom shadow-sm">
            <i class="bi bi-person-plus-fill me-2 fs-5"></i> TAMBAH KARYAWAN
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-custom mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                    <i class="bi bi-check2"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table" id="karyawanTable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Profil Karyawan</th>
                        <th>Email & Kontak</th>
                        <th class="text-center">Jabatan</th>
                        <th class="text-center">Gaji / Hari</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $i => $item)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $item->name }}</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">ID: #EMP-{{ 100 + $item->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-secondary mb-1" style="font-size: 0.85rem;">
                                <i class="bi bi-envelope-fill me-2 text-primary opacity-50"></i> {{ $item->email }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-posisi">
                                {{ $item->jabatan ?? 'Generalist' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="text-gaji">
                                Rp {{ number_format($item->gaji_per_hari ?? 0, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.karyawan.edit', $item->id) }}" class="btn-action btn-edit-soft" data-bs-toggle="tooltip" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.karyawan.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete-soft" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" data-bs-toggle="tooltip" title="Hapus Data">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Animasi baris tabel saat load
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                row.style.transition = 'all 0.4s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
            }, 100 * index);
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

@endsection