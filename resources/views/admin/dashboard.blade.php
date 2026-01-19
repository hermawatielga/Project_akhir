@extends('layouts.app')
@include('layouts.navbar')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --accent-color: #6366f1;
        --bg-main: #f8fafc;
        --text-dark: #1e293b;
        --text-soft: #64748b;
        --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
        background-color: var(--bg-main);
        background-image: 
            radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.03) 0px, transparent 50%),
            radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.03) 0px, transparent 50%);
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding-left: 260px;
        color: var(--text-dark);
        transition: all 0.3s;
    }

    .dashboard-wrapper { 
        padding: 40px; 
        animation: fadeInPage 0.8s ease-out;
    }

    @keyframes fadeInPage {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Modern Headers */
    h1 { font-size: 1.75rem !important; font-weight: 800; letter-spacing: -0.025em; color: #0f172a; }

    /* Statistic Cards */
    .card-box {
        padding: 28px;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.7);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: var(--card-shadow);
    }

    .card-box:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .bg-total { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); }
    .bg-hadir { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
    .bg-izin { background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); }

    .card-title { 
        font-size: 0.7rem; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 0.1em; 
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.8);
    }

    .card-value { 
        font-size: 2.2rem; 
        font-weight: 800; 
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-icon { 
        font-size: 3rem; 
        opacity: 0.15; 
        position: absolute; 
        right: -10px; 
        bottom: -10px;
        transform: rotate(-15deg);
    }

    /* Filters */
    .filter-select {
        border: 1.5px solid #e2e8f0;
        background: white;
        border-radius: 12px;
        padding: 8px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        transition: 0.3s;
    }

    .filter-select:focus { outline: none; border-color: var(--accent-color); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

    .btn-apply { 
        background: var(--accent-color); 
        border: none; 
        border-radius: 12px; 
        padding: 8px 24px; 
        color: white; 
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-apply:hover { background: #4f46e5; transform: scale(1.05); }

    /* Table Card */
    .big-card {
        background: white;
        padding: 30px;
        border-radius: 30px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    }

    .table thead th {
        background: #f8fafc;
        padding: 18px;
        font-size: 0.7rem;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        border: none;
    }

    .table tbody td { 
        padding: 16px; 
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr { transition: 0.2s; cursor: default; }
    .table tbody tr:hover { background-color: #f8fafc; }

    /* Avatar Squircle */
    .avatar-placeholder {
        width: 45px !important;
        height: 45px !important;
        border-radius: 14px !important;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }

    /* Badges */
    .badge-status {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Evidence Image */
    .img-evidence {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
    .img-evidence:hover { transform: scale(1.2) rotate(3deg); box-shadow: 0 10px 15px rgba(0,0,0,0.2); }

    /* Custom Search */
    #customSearch {
        border-radius: 12px;
        border: 1.5px solid #f1f5f9;
        background: #f8fafc;
        padding: 10px 16px;
        font-size: 0.85rem;
        transition: 0.3s;
    }
    #customSearch:focus { background: white; border-color: var(--accent-color); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

    @media (max-width: 991px) { body { padding-left: 0; } .dashboard-wrapper { padding: 20px; } }
</style>

<div class="dashboard-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-4">
        <div>
            <h1 class="mb-1">Dashboard Admin</h1>
            <p class="text-muted fw-medium">
                <i class="bi bi-calendar3 me-1"></i> Periode: 
                <span class="text-dark fw-bold">{{ \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') }} {{ $tahun }}</span>
            </p>
        </div>
        
        <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2">
            <select name="bulan" class="filter-select shadow-sm">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="filter-select shadow-sm">
                @for($y = date('Y'); $y >= date('Y')-2; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn-apply shadow-sm">
                <i class="bi bi-filter me-1"></i> Filter
            </button>
        </form>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-box bg-total">
                <div class="card-title">Karyawan Terdaftar</div>
                <div class="card-value"><span class="counter">{{ $totalKaryawan ?? 0 }}</span></div>
                <i class="bi bi-people card-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box bg-hadir">
                <div class="card-title">Kehadiran (Hadir)</div>
                <div class="card-value"><span class="counter">{{ $stats['hadir'] ?? 0 }}</span></div>
                <i class="bi bi-person-check card-icon"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box bg-izin">
                <div class="card-title">Izin & Sakit</div>
                <div class="card-value"><span class="counter">{{ ($stats['izin'] ?? 0) + ($stats['sakit'] ?? 0) }}</span></div>
                <i class="bi bi-envelope-paper card-icon"></i>
            </div>
        </div>
    </div>

    <div class="big-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary">
                    <i class="bi bi-journal-text fs-4"></i>
                </div>
                <div class="fw-bold fs-5 text-dark">Log Absensi Karyawan</div>
            </div>
            
            <div class="d-flex gap-3">
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0 border-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="customSearch" class="form-control border-start-0 border-light shadow-none" placeholder="Cari nama atau status...">
                </div>
                <form action="{{ route('admin.absensi.destroyAll') }}" method="POST" onsubmit="return confirm('Peringatan! Semua data absensi pada periode ini akan dihapus permanen. Lanjutkan?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger border-0 fw-bold px-3"><i class="bi bi-trash3-fill"></i></button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="tableAbsenFinal">
                <thead>
                    <tr>
                        <th>Informasi Karyawan</th>
                        <th class="text-center">Waktu Kerja</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Dokumen</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatAbsensi as $item)
                        @if($item->status != 'alpha')
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->user->name ?? '-' }}</div>
                                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2 py-1 rounded small" style="font-size: 10px;">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> {{ $item->jam_masuk ?? '--:--' }}
                                    </span>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 px-2 py-1 rounded small" style="font-size: 10px;">
                                        <i class="bi bi-box-arrow-left me-1"></i> {{ $item->jam_pulang ?? '--:--' }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClass = match($item->status) {
                                        'hadir' => 'bg-success text-white',
                                        'izin' => 'bg-warning text-dark',
                                        'sakit' => 'bg-info text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }} shadow-sm">{{ $item->status }}</span>
                            </td>
                            <td class="text-center">
                                @if($item->dokumen)
                                    <img src="{{ asset('storage/surat_izin/' . $item->dokumen) }}" 
                                         class="img-evidence" 
                                         onclick="previewImage(this.src)">
                                @else
                                    <span class="text-muted" style="font-size: 11px;">N/A</span>
                                @endif
                            </td>
                            <td>
                                <p class="mb-0 text-muted small" style="max-width: 180px; font-style: italic;">"{{ $item->keterangan ?? '-' }}"</p>
                            </td>
                        </tr>
                        @endif
                    @empty
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center">
                <img src="" id="modalImage" class="img-fluid rounded-4 shadow-lg border border-white border-4">
                <div class="mt-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Tutup Preview</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    // 1. Inisialisasi DataTable
    var table = $('#tableAbsenFinal').DataTable({
        "pageLength": 10,
        "dom": 'tp', 
        "ordering": true,
        "language": {
            "emptyTable": "Belum ada riwayat absensi pada periode ini.",
            "paginate": { "previous": "<i class='bi bi-chevron-left'></i>", "next": "<i class='bi bi-chevron-right'></i>" }
        }
    });

    // 2. Custom Search Logic
    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    // 3. Efek Counter Angka (Animate Numbers)
    $('.counter').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 1200,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // 4. Baris Muncul Bertahap (Staggered Animation)
    $('tbody tr').each(function(i) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(10px)',
            'transition': 'all 0.3s ease'
        });
        setTimeout(() => {
            $(this).css({
                'opacity': '1',
                'transform': 'translateY(0)'
            });
        }, 80 * i);
    });
});

// Fungsi Preview Gambar
function previewImage(src) {
    $('#modalImage').attr('src', src);
    var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
    myModal.show();
}
</script>
@endsection