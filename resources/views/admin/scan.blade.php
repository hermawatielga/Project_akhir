@extends('layouts.app')
@include('layouts.navbar')
@section('content')

<style>
    body {
        background: #a9c3d6;
    }

    .qr-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .qr-card {
        background: #e5e5e5;
        width: 600px;
        padding: 35px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
    }

    .qr-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .qr-date {
        font-size: 15px;
        color: #333;
        margin-bottom: 15px;
    }

    .qr-image {
        width: 200px;
        margin: 15px auto;
        display: block;
    }

    .btn-blue {
        background: #4169e1;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        margin-right: 8px;
        cursor: pointer;
    }

    .btn-print {
        background: white;
        border: 1px solid #dcdcdc;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        color: #333;
        cursor: pointer;
    }

    .btn-green {
        background: #2d7d2f;
        border: none;
        padding: 10px 25px;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        margin-top: 15px;
        cursor: pointer;
        width: 100%;
    }
</style>

<div class="qr-wrapper">
    <div class="qr-card">

        {{-- JUDUL --}}
        <p class="qr-title">Generate QR Absensi - Hari Ini</p>

        {{-- TANGGAL --}}
        <p class="qr-date">{{ date('Y-m-d') }}</p>

        {{-- QR CODE --}}
        <img 
            src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(url('/proses-qr?kode=' . auth()->user()->qr_code)) }}"
            class="qr-image"
            alt="QR Absensi"
        />


        {{-- TOMBOL DOWNLOAD PNG --}}
        <button class="btn-blue" id="downloadBtn">Download PNG</button>

        {{-- TOMBOL PRINT --}}
        <button class="btn-print" onclick="window.print()">Print</button>

        {{-- TOMBOL GENERATE --}}
        <form action="{{ route('karyawan.generateQR') }}" method="POST">
            @csrf
            <button class="btn-green" type="submit">
                Generate QR Hari Ini (Simpan)
            </button>
        </form>

    </div>
</div>

<script>
document.getElementById("downloadBtn").addEventListener("click", function () {
    const qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ auth()->user()->qr_code }}";
    const link = document.createElement("a");
    link.href = qrUrl;
    link.download = "qr_absensi.png";
    link.click();
});
</script>

@endsection
