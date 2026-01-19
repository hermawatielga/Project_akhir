@extends('layouts.app')
@include('layouts.navbar')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        --danger-gradient: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    body {
        background-color: #f8fafc;
        background-image: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.03) 0px, transparent 50%);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #334155;
    }

    .page-header {
        padding: 2.5rem 0;
        animation: fadeInDown 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-title {
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.03em;
        font-size: 2rem;
    }

    /* Stats Cards Premium */
    .stat-card {
        background: white;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 24px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .stat-icon {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 4rem;
        opacity: 0.05;
        transform: rotate(-15deg);
    }

    /* Table Styling Luxury */
    .main-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table thead th {
        background: #f8fafc;
        padding: 1.5rem;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
    }

    .table tbody td {
        padding: 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Avatar Squircle */
    .avatar-circle {
        width: 48px;
        height: 48px;
        background: var(--primary-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-weight: 800;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    /* Badges */
    .badge-attendance {
        background: #ecfdf5;
        color: #065f46;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid #d1fae5;
    }

    /* Amounts */
    .text-amount-red {
        color: #e11d48;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .text-amount-green {
        color: #059669;
        font-weight: 800;
        font-size: 1.1rem;
        font-family: 'JetBrains Mono', monospace;
    }

    .btn-print {
        background: #0f172a;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 14px;
        font-weight: 700;
        transition: 0.3s;
        border: none;
    }

    .btn-print:hover {
        background: #334155;
        transform: scale(1.05);
        color: white;
    }

    .btn-detail {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f1f5f9;
        color: #475569;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: rotate(90deg);
    }

    @media print {
        .btn-print, .btn-detail, .navbar, .stat-card { display: none !important; }
        .main-card { border: none; box-shadow: none; }
        body { background: white; }
    }
</style>

<div class="container py-4">
    
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2 rounded-pill mb-2">Finance Report</span>
                <h3 class="page-title mb-1">Rekapitulasi Gaji</h3>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar3 me-1"></i> Periode: <span class="fw-bold text-dark">{{ now()->translatedFormat('F Y') }}</span>
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button onclick="window.print()" class="btn btn-print shadow-lg">
                    <i class="bi bi-printer-fill me-2"></i> Ekspor PDF / Cetak
                </button>
            </div>
        </div>
    </div>

    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <i class="bi bi-people stat-icon"></i>
                <span class="text-muted small fw-800 text-uppercase">Total SDM</span>
                <h2 class="mt-2 mb-0 fw-bold counter">{{ $karyawan->count() }}</h2>
                <div class="text-primary small mt-2 fw-semibold">Karyawan Aktif</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-top: 4px solid #10b981;">
                <i class="bi bi-cash-stack stat-icon"></i>
                <span class="text-muted small fw-800 text-uppercase">Total Payroll</span>
                <h2 class="mt-2 mb-0 fw-bold text-success">
                    <span style="font-size: 1rem">Rp</span> <span class="counter">{{ number_format($karyawan->sum('gajiBersih'), 0, ',', '.') }}</span>
                </h2>
                <div class="text-success small mt-2 fw-semibold">Estimasi Pengeluaran</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-top: 4px solid #f43f5e;">
                <i class="bi bi-graph-down-arrow stat-icon"></i>
                <span class="text-muted small fw-800 text-uppercase">Efisiensi Absensi</span>
                <h2 class="mt-2 mb-0 fw-bold text-danger">
                    <span style="font-size: 1rem">Rp</span> <span class="counter">{{ number_format($karyawan->sum('potongan'), 0, ',', '.') }}</span>
                </h2>
                <div class="text-danger small mt-2 fw-semibold">Total Potongan Disiplin</div>
            </div>
        </div>
    </div>

    <div class="main-card">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light bg-opacity-50">
            <h5 class="mb-0 fw-bold"><i class="bi bi-list-stars me-2 text-primary"></i>Rincian Gaji Karyawan</h5>
            <span class="text-muted small">Update Terakhir: {{ now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Identitas Karyawan</th>
                        <th class="text-center">Kehadiran</th>
                        <th class="text-center">Potongan</th>
                        <th class="text-end">Gaji Bersih</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawan as $k)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($k->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $k->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $k->jabatan ?? 'Staf Karyawan' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge-attendance">
                                <i class="bi bi-calendar-check me-1"></i>{{ $k->totalHadir }} Hari
                            </span>
                        </td>
                        <td class="text-center">
                            @if($k->sudah_absen)
                                <span class="text-amount-red">
                                    -{{ number_format($k->potongan ?? 0, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($k->sudah_absen)
                                <span class="text-amount-green">
                                    <span style="font-size: 0.8rem">Rp</span> {{ number_format($k->gajiBersih ?? 0, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 px-3 py-2 rounded-pill" style="font-size: 0.7rem;">
                                    Pending Absensi
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.karyawan.detail', $k->id) }}" class="btn-detail" title="Lihat Detail">
                                    <i class="bi bi-arrow-right-short fs-4"></i>
                                </a>
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
    // Animasi angka saat load
    document.addEventListener("DOMContentLoaded", function() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const value = counter.innerText.replace(/\./g, '');
            let start = 0;
            const end = parseInt(value);
            const duration = 1000;
            const increment = end / (duration / 16);
            
            const timer = setInterval(() => {
                start += increment;
                if (start >= end) {
                    counter.innerText = end.toLocaleString('id-ID');
                    clearInterval(timer);
                } else {
                    counter.innerText = Math.floor(start).toLocaleString('id-ID');
                }
            }, 16);
        });
    });
</script>

@endsection