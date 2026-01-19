@extends('layouts.app')
@include('layouts.navbar')
@section('content')

<style>
    body {
        background: #f2f6fc;
    }

    .edit-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.08);
    }

    .title-edit {
        font-size: 26px;
        font-weight: 700;
        color: #2c3e50;
    }

    label {
        font-weight: 600;
        color: #34495e;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 12px;
    }

    .btn-primary {
        border-radius: 10px;
        padding: 8px 15px;
    }

    .btn-secondary {
        border-radius: 10px;
        padding: 8px 15px;
    }
</style>


<div class="container mt-4">

    <h2 class="mb-4 fw-bold">✏ Edit Data Karyawan</h2>

    <div class="card shadow-sm p-4">

        <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
            
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="fw-semibold">Nama</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ $karyawan->name }}" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ $karyawan->email }}" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Jabatan</label>
                <input type="text" name="jabatan" class="form-control"
                       value="{{ $karyawan->jabatan }}">
            </div>

            <div class="mb-3">
                <label>Gaji Per Hari</label>
                <input type="number" name="gaji_per_hari" class="form-control" 
                    placeholder="Masukkan gaji per hari" value="{{ $karyawan->gaji_per_hari }}">
            </div>

            <button type="submit" class="btn btn-success px-4">Update</button>
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary px-4">Kembali</a>


        </form>

    </div>

</div>

@endsection
