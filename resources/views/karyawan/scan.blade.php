@extends('layouts.app')
@include('layouts.navbar2')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #d7e6f5, #f1f7ff);
        min-height: 100vh;
    }

    .qr-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .qr-card {
        background: #ffffff;
        width: 520px;
        padding: 35px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0px 8px 25px rgba(0,0,0,0.12);
        border: 1px solid #e3eaf5;
    }

    .qr-title {
        font-size: 26px;
        font-weight: 700;
        color: #2a3d66;
        margin-bottom: 5px;
    }

    .qr-date {
        font-size: 15px;
        color: #5c6a82;
        margin-bottom: 20px;
    }

    .qr-image {
        width: 220px;
        margin: 20px auto;
        display: block;
        border: 5px solid #e8eef7;
        border-radius: 12px;
    }

    .btn-blue {
        background: #4a74c9;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        margin-right: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-blue:hover {
        background: #3c61ac;
    }

    .btn-print {
        background: white;
        border: 1px solid #d1d9e6;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        color: #3a4a64;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-print:hover {
        background: #f5f7fa;
    }

    .btn-green {
        background: #2e8b57;
        border: none;
        padding: 11px 25px;
        border-radius: 14px;
        color: white;
        font-weight: 600;
        margin-top: 18px;
        cursor: pointer;
        width: 100%;
        transition: 0.2s;
    }

    .btn-green:hover {
        background: #267749;
    }
</style>

<div class="qr-wrapper">
    <div class="qr-card">

        {{-- JUDUL --}}
        <p class="qr-title">QR Absensi - Hari Ini</p>

        {{-- TANGGAL --}}
        <p class="qr-date">{{ date('Y-m-d') }}</p>

        {{-- QR CODE --}}
        <img 
            src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(url('/proses-qr?kode=' . auth()->user()->qr_code)) }}"
            class="qr-image"
            alt="QR Absensi"
        />

        {{-- DOWNLOAD --}}
        <button class="btn-blue" id="downloadBtn">Download PNG</button>

        {{-- PRINT --}}
        <button class="btn-print" onclick="window.print()">Print</button>

        {{-- GENERATE QR --}}
        <form action="{{ route('karyawan.generateQR') }}" method="POST">
            @csrf
            <button class="btn-green" type="submit">
                Generate QR Baru (Simpan)
            </button>
        </form>

    </div>
</div>

<script>
document.getElementById("downloadBtn").addEventListener("click", function () {
    const qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ auth()->user()->qr_code }}";
    const link = document.createElement("a");
    link.href = qrUrl;
    link.download = "qr_absensi.png";
    link.click();
});
</script>

@endsection
