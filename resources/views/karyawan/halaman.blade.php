@extends('layouts.app')
@include('layouts.navbar2')

@section('content')

<style>
    body {
        /* Gradasi pastel yang sangat lembut dan menenangkan */
        background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%), 
                    linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
        background-blend-mode: screen;
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.5px;
    }

    /* Kartu utama dengan efek Glassmorphism yang lebih 'deep' */
    .card-table {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        padding: 35px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 15px;
    }

    /* Warna header tabel yang soft */
    .table thead th {
        border: none;
        color: #8e9aaf;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding-left: 20px;
    }

    /* Baris tabel dengan warna soft-white dan transisi halus */
    .table tbody tr {
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
    }

    .table tbody tr:hover {
        transform: scale(1.02); /* Sedikit membesar saat hover */
        background: #ffffff;
        box-shadow: 0 15px 30px rgba(172, 224, 249, 0.3);
    }

    .table td {
        padding: 20px !important;
        border: none !important;
        vertical-align: middle;
    }

    /* Styling lengkungan baris */
    .table tbody tr td:first-child { border-radius: 20px 0 0 20px; }
    .table tbody tr td:last-child { border-radius: 0 20px 20px 0; }

    /* Badge Jabatan dengan warna pastel yang indah */
    .badge-soft {
        background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(142, 197, 252, 0.4);
    }

    /* Lingkaran nomor urut yang estetik */
    .number-circle {
        width: 35px;
        height: 35px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #6a11cb;
        font-weight: 800;
        font-size: 13px;
        border: 1px solid #eee;
    }
</style>


<div class="container mt-5 pb-5">

    <div class="mb-5 text-center">
        <h2 class="page-title">📋 Daftar Karyawan</h2>
        <p style="color: #7f8c8d; font-weight: 500;">Pantau dan kelola aset berharga perusahaan Anda dengan kenyamanan visual.</p>
    </div>

    <div class="card-table">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="100">#</th>
                        <th>Nama Lengkap</th>
                        <th>Email Perusahaan</th>
                        <th>Posisi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $i => $item)
                    <tr>
                        <td>
                            <div class="number-circle">{{ $i + 1 }}</div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark" style="font-size: 16px;">{{ $item->name }}</span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $item->email }}</span>
                        </td>
                        <td>
                            <span class="badge-soft">
                                {{ $item->jabatan ?? 'Anggota Tim' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection