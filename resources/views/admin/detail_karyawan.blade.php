@extends('layouts.app')
@include('layouts.navbar')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --brand-dark: #0f172a;
        --brand-primary: #6366f1;
        --brand-success: #10b981;
        --brand-danger: #f43f5e;
        --brand-warning: #f59e0b;
        --glass: rgba(255, 255, 255, 0.95);
    }

    body { 
        background: #f8fafc; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        color: #334155;
    }

    .premium-container { padding: 40px 20px; animation: fadeIn 0.8s ease; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Header Profile Card */
    .profile-card {
        background: linear-gradient(135deg, var(--brand-dark) 0%, #1e293b 100%);
        border-radius: 30px; 
        padding: 40px; 
        color: white; 
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1);
    }

    .profile-card::after {
        content: "";
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: rgba(99, 102, 241, 0.1);
        border-radius: 50%;
    }

    .avatar-main {
        width: 90px; height: 90px; 
        font-size: 36px; 
        border: 4px solid rgba(255,255,255,0.15);
        background: var(--brand-primary);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
    }

    /* Salary Highlight Card */
    .salary-banner {
        background: white;
        border-radius: 24px;
        border: none;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .salary-main-zone {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-right: 1px solid #bbf7d0;
        padding: 35px;
    }

    .salary-detail-zone {
        background: #ffffff;
        padding: 35px;
    }

    /* Small Cards */
    .info-box {
        padding: 24px;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.03);
        height: 100%;
    }

    .info-box:hover { transform: translateY(-5px); }
    .ib-blue { background: #f5f3ff; border-left: 6px solid #8b5cf6; }
    .ib-red { background: #fff1f2; border-left: 6px solid #fb7185; }
    .ib-green { background: #f0fdf4; border-left: 6px solid #34d399; }

    /* Attendance Grid */
    .glass-card { 
        background: var(--glass); 
        border-radius: 30px; 
        padding: 35px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.04);
        border: 1px solid rgba(255,255,255,0.8);
    }

    .date-square {
        width: 60px; height: 75px;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: default;
    }

    .date-square:hover {
        transform: scale(1.1);
        z-index: 10;
    }

    .status-hadir { background: var(--brand-success); color: white; box-shadow: 0 8px 15px -3px rgba(16, 185, 129, 0.3); }
    .status-izin { background: var(--brand-warning); color: white; box-shadow: 0 8px 15px -3px rgba(245, 158, 11, 0.3); }
    .status-sakit { background: #0ea5e9; color: white; box-shadow: 0 8px 15px -3px rgba(14, 165, 233, 0.3); }
    .status-empty { background: #f1f5f9; color: #94a3b8; opacity: 0.6; }

    .btn-back {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        backdrop-filter: blur(10px);
        transition: 0.3s;
    }

    .btn-back:hover {
        background: white;
        color: var(--brand-dark);
    }
</style>

<div class="container premium-container">
    <div class="profile-card d-flex flex-wrap align-items-center justify-content-between gap-4">
        <div class="d-flex align-items-center gap-4">
            <div class="avatar-main rounded-circle d-flex align-items-center justify-content-center fw-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="mb-1 fw-800" style="letter-spacing: -1px;">{{ $user->name }}</h2>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
                        <i class="bi bi-shield-check me-1"></i> {{ $user->jabatan ?? 'Staff Karyawan' }}
                    </span>
                    <span class="text-white-50 small"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.daftar') }}" class="btn btn-back rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i>Kembali Ke Daftar
        </a>
    </div>

    <div class="salary-banner">
        <div class="row g-0">
            <div class="col-lg-7 salary-main-zone">
                <h6 class="text-success fw-800 text-uppercase mb-2" style="letter-spacing: 1.5px; font-size: 11px;">Estimasi Gaji Bersih (Bulan Ini)</h6>
                <div class="d-flex align-items-baseline gap-2">
                    <h1 class="display-5 fw-800 text-dark mb-0">Rp {{ number_format($gajiBersih, 0, ',', '.') }}</h1>
                    <span class="text-muted fw-bold">/Periode</span>
                </div>
                <div class="mt-4 d-flex gap-3">
                    <div class="p-2 px-3 rounded-pill bg-white border small fw-bold text-muted">
                        <i class="bi bi-info-circle me-1"></i> Perhitungan otomatis oleh sistem
                    </div>
                </div>
            </div>
            <div class="col-lg-5 salary-detail-zone">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold">Gaji Pokok Pokok</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($gajiPokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold text-success">Total Lembur (+)</span>
                        <span class="fw-bold text-success">+ Rp {{ number_format($totalLembur, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold text-danger">Total Potongan (-)</span>
                        <span class="fw-bold text-danger">- Rp {{ number_format($totalPotongan, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-dark fw-800">TOTAL DITERIMA</span>
                        <span class="fw-800 text-primary">Rp {{ number_format($gajiBersih, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-box ib-blue">
                    <small class="text-muted d-block mb-1 fw-800 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Status Kepegawaian</small>
                    <span class="fw-800 text-dark d-block fs-5">{{ $user->name }}</span>
                    <div class="mt-2 small text-muted">ID Karyawan: <span class="text-primary fw-bold">#{{ 1000 + $user->id }}</span></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box ib-red">
                    <small class="text-danger d-block mb-1 fw-800 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Akumulasi Denda</small>
                    <span class="fw-800 text-danger fs-5">
                        - Rp {{ number_format($totalPotongan, 0, ',', '.') }}
                    </span>
                    <div class="small text-muted mt-2" style="font-size: 11px;"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terlambat </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box ib-green">
                    <small class="text-success d-block mb-1 fw-800 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Akumulasi Lembur</small>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <span class="fw-800 text-success fs-5">+ Rp {{ number_format($totalLembur, 0, ',', '.') }}</span>
                        <span class="badge bg-success text-white px-2 py-1" style="font-size: 11px;">{{ $totalMenitLembur ?? 0 }} Min</span>
                    </div>
                    <div class="small text-muted mt-2" style="font-size: 11px;"><i class="bi bi-clock-history me-1"></i> Dihitung dari waktu pulang (>15:00)</div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h5 class="fw-800 mb-0"><i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>Visualisasi Kehadiran</h5>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge status-hadir px-3 rounded-pill" style="font-size: 10px;">Hadir</span>
                <span class="badge status-izin px-3 rounded-pill" style="font-size: 10px;">Izin</span>
                <span class="badge status-sakit px-3 rounded-pill" style="font-size: 10px;">Sakit</span>
                <span class="badge status-alpha px-3 rounded-pill" style="font-size: 10px;">Alpha</span>
            </div>
        </div>
        
        <div class="row g-3 justify-content-start">
            @php
                $dataAbsen = $riwayatAbsensi->keyBy(function($item) {
                return $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') 
                                    : \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
            });
            @endphp

            @for($date = clone $start; $date <= $end; $date->addDay())
                @php 
                    $currDate = $date->format('Y-m-d');
                    $absenRecord = $dataAbsen->get($currDate);
                    
                    $boxClass = 'status-empty'; 
                    $icon = '';
                    $tooltipInfo = $date->translatedFormat('d F Y') . ': Belum ada data';

                    if($absenRecord) {
                        $boxClass = 'status-' . $absenRecord->status;
                        $icon = $absenRecord->status == 'hadir' ? '<i class="bi bi-check-circle-fill" style="font-size: 10px;"></i>' : '';
                        
                        $infoLembur = $absenRecord->menit_lembur > 0 ? " | Lembur: " . $absenRecord->menit_lembur . " min" : "";
                        $tooltipInfo = $date->translatedFormat('d M') . ' - ' . ucfirst($absenRecord->status) . $infoLembur;
                    }
                @endphp

                <div class="col-auto">
                    <div class="date-square {{ $boxClass }}" 
                         data-bs-toggle="tooltip" 
                         title="{{ $tooltipInfo }}">
                        <span style="font-size: 9px; font-weight: 800; text-transform: uppercase; opacity: 0.8;">{{ $date->translatedFormat('D') }}</span>
                        <span class="fw-bold fs-5">{{ $date->format('d') }}</span>
                        <div class="mt-1">{!! $icon !!}</div>
                        @if($absenRecord && $absenRecord->menit_lembur > 0)
                            <div style="font-size: 8px; font-weight: 800; background: rgba(0,0,0,0.1); padding: 1px 4px; border-radius: 4px; margin-top: 2px;">OT</div>
                        @endif
                    </div>
                </div>
            @endfor
        </div>

        <div class="mt-5 p-4 bg-light rounded-4 border-0 d-flex align-items-center gap-3">
            <div class="bg-white p-3 rounded-circle shadow-sm">
                <i class="bi bi-info-circle-fill text-primary fs-4"></i>
            </div>
            <div>
                <h6 class="mb-1 fw-bold text-dark">Catatan Periode</h6>
                <small class="text-muted">Data ini mencakup periode <strong>{{ $start->translatedFormat('d M') }}</strong> hingga <strong>{{ $end->translatedFormat('d M Y') }}</strong>. Pastikan absensi dilakukan tepat waktu untuk menghindari potongan otomatis.</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection