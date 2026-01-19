@include('layouts.navbar2')
@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body { 
        background-color: #f8fafc; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        color: #1e293b;
    }
    .glass-card {
        background: #ffffff;
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .stat-card {
        border: none;
        border-radius: 20px;
        background: #ffffff;
        transition: all 0.3s ease;
    }
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 15px;
        border: none;
    }
    .table tbody td { 
        padding: 18px 15px; 
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .filter-section {
        background: white;
        padding: 12px 20px;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    /* Status Badge Soft Colors */
    .badge-soft-success { background: #dcfce7; color: #15803d; }
    .badge-soft-danger { background: #fee2e2; color: #b91c1c; }
    .badge-soft-warning { background: #fef3c7; color: #b45309; }
    .badge-soft-info { background: #e0f2fe; color: #0369a1; }
    
    .time-badge {
        background: #f1f5f9;
        color: #334155;
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 8px;
    }
    
    /* Agar keterangan membungkus rapi */
    .col-keterangan {
        min-width: 250px;
        max-width: 400px;
        line-height: 1.5;
        word-wrap: break-word;
        white-space: normal;
    }
</style>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
            <h2 class="fw-800 mb-1">Detail Kehadiran</h2>
            <p class="text-muted mb-0">Laporan absensi bulanan Anda secara transparan.</p>
        </div>
        <div class="col-md-6">
            <div class="filter-section d-flex justify-content-md-end align-items-center gap-3">
                <form action="{{ route('karyawan.detail_kehadiran') }}" method="GET" class="d-flex gap-2 w-100 w-md-auto">
                    <select name="bulan" class="form-select border-light shadow-none" style="border-radius: 10px; min-width: 160px;">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-primary px-4 fw-600" style="border-radius: 10px;">
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        @php
            $config = [
                ['label' => 'Hadir', 'val' => $stats['hadir'], 'color' => '#10b981', 'icon' => 'bi-check-all'],
                ['label' => 'Izin', 'val' => $stats['izin'], 'color' => '#f59e0b', 'icon' => 'bi-envelope-paper'],
                ['label' => 'Sakit', 'val' => $stats['sakit'], 'color' => '#3b82f6', 'icon' => 'bi-heart-pulse'],
                ];
        @endphp

        @foreach($config as $c)
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" 
                         style="width: 48px; height: 48px; background: {{ $c['color'] }}15; color: {{ $c['color'] }};">
                        <i class="bi {{ $c['icon'] }} fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-0" style="font-size: 0.65rem; letter-spacing: 0.5px;">{{ $c['label'] }}</p>
                        <h4 class="fw-800 mb-0">{{ $c['val'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card glass-card">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Riwayat: {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</h5>
                <span class="text-muted small fw-600"><i class="bi bi-info-circle me-1"></i> {{ count($absensi) }} Hari Tercatat</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-center">Waktu Kerja</th>
                            <th class="text-center">Status</th>
                            <th>Keterangan & Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $row)
                        <tr>
                            <td>
                                <span class="fw-bold d-block text-dark">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}</span>
                                <small class="text-muted text-uppercase" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <div class="time-badge" title="Jam Masuk">
                                        <i class="bi bi-box-arrow-in-right text-success me-1"></i>{{ $row->jam_masuk ?? '--:--' }}
                                    </div>
                                    <div class="time-badge" title="Jam Pulang">
                                        <i class="bi bi-box-arrow-left text-danger me-1"></i>{{ $row->jam_pulang ?? '--:--' }}
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $badge = 'badge-soft-warning';
                                    if($row->status == 'hadir') $badge = 'badge-soft-success';
                                    if($row->status == 'alpha') $badge = 'badge-soft-danger';
                                    if($row->status == 'sakit') $badge = 'badge-soft-info';
                                @endphp
                                <span class="badge {{ $badge }} px-3 py-2 text-uppercase fw-bold" style="font-size: 0.7rem;">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td class="col-keterangan">
                                <div class="d-flex flex-column gap-2">
                                    <span class="small text-secondary">{{ $row->keterangan ?? '-' }}</span>
                                    @if($row->dokumen)
                                        <a href="{{ asset('storage/surat_izin/'.$row->dokumen) }}" target="_blank" 
                                           class="btn btn-sm btn-light border text-primary fw-bold" 
                                           style="border-radius: 8px; font-size: 0.75rem; width: fit-content;">
                                            <i class="bi bi-file-earmark-text me-1"></i>Lihat Lampiran
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-calendar-x text-muted display-4"></i>
                                    <p class="text-muted mt-3">Tidak ada riwayat absensi untuk periode ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection