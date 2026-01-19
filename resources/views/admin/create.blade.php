@extends('layouts.app')
@include('layouts.navbar')
@section('content')

<style>
    body {
        background: linear-gradient(135deg, #e3f2fd, #fce4ec);
        min-height: 100vh;
    }

    .create-card {
        background: #ffffff;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transition: transform 0.3s;
    }
    .create-card:hover {
        transform: translateY(-5px);
    }

    .title-create {
        font-size: 28px;
        font-weight: 800;
        color: #34495e;
        margin-bottom: 30px;
    }

    label {
        font-weight: 600;
        color: #2c3e50;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #ccc;
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 0 0.2rem rgba(106,17,203,0.25);
    }

    .btn-primary {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        background: linear-gradient(45deg, #6a11cb, #2575fc);
        border: none;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #2575fc, #6a11cb);
        color: #fff;
    }

    .btn-secondary {
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        background: #f0f0f0;
        border: none;
        color: #2c3e50;
        transition: 0.3s;
    }
    .btn-secondary:hover {
        background: #dcdcdc;
    }
</style>

<div class="container mt-5">

    <h2 class="title-create">➕ Tambah Karyawan</h2>

    <div class="create-card">

        <form action="{{ route('admin.karyawan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama karyawan" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" placeholder="Masukkan jabatan">
            </div>

            <div class="mb-3">
                <label>Gaji Per Hari</label>
                <input type="number" name="gaji_per_hari" class="form-control" placeholder="Masukkan gaji per hari">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password">
            </div>

            <div class="d-flex gap-3">
                <button class="btn btn-primary">💾 Simpan</button>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">🔙 Kembali</a>
            </div>
        </form>

    </div>

</div>

@endsection
