<!-- resources/views/admin/data.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Data Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Data Karyawan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Gaji Pokok</th>
                <th>Jumlah Alpa</th>
                <th>Potongan</th>
                <th>Gaji Akhir</th>
            </tr>
        </thead>
        <tbody>
            {{ $ }}
            @foreach($karyawans as $k)
            <tr>
                <td>{{ $k->nama }}</td>
                <td>Rp{{ number_format($k->gaji_pokok,0,',','.') }}</td>
                <td>{{ $k->absensi->where('status','Alpa')->count() }} hari</td>
                <td>Rp{{ number_format($k->potongan,0,',','.') }}</td>
                <td>Rp{{ number_format($k->gaji_akhir,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
