<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;



/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE WAJIB LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | CRUD KARYAWAN (RESOURCE)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('karyawan', KaryawanController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD KARYAWAN
    |--------------------------------------------------------------------------
    */
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'dashboard'])
        ->name('karyawan.dashboard');

    Route::get('/karyawan/halaman', [AdminController::class, 'halaman'])
        ->name('karyawan.halaman');

    /*
    |--------------------------------------------------------------------------
    | QR CODE
    |--------------------------------------------------------------------------
    */
    Route::get('/karyawan/scan', [KaryawanController::class, 'scanQR'])
        ->name('karyawan.scan');

    Route::post('/karyawan/absen', [KaryawanController::class, 'absenQR'])
        ->name('karyawan.absenQR');

    Route::get('/karyawan/qr', [KaryawanController::class, 'showQR'])
        ->name('karyawan.qr');

    Route::post('/karyawan/generate-qr', [KaryawanController::class, 'generateQR'])
        ->name('karyawan.generateQR');

    /*
    |--------------------------------------------------------------------------
    | ABSENSI
    |--------------------------------------------------------------------------
    */
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'absenPulang'])->name('absensi.pulang');
});


/*
|--------------------------------------------------------------------------
| ABSENSI KARYAWAN (TANPA AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/karyawan/absensi', [AbsensiController::class, 'index'])
    ->name('karyawan.absensi');


/*
|--------------------------------------------------------------------------
| DAFTAR KARYAWAN (YANG BENAR)
|--------------------------------------------------------------------------
*/
Route::get('/admin/daftar', [KaryawanController::class, 'daftarKaryawan'])
    ->name('admin.daftar');


/*
|--------------------------------------------------------------------------
| QR SCAN UMUM
|--------------------------------------------------------------------------
*/
Route::get('/absen/{qr}', [AbsensiController::class, 'scan'])->name('absen.scan');
Route::get('/admin/scan', [AdminController::class, 'scan'])->name('admin.scan');
Route::get('/scan-qr', [KaryawanController::class, 'scanQR'])->name('scan.qr');
Route::get('/proses-qr', [KaryawanController::class, 'prosesQR'])->name('proses.qr');

Route::get('/karyawan/detail-kehadiran', [KaryawanController::class, 'detailKehadiran'])
         ->name('karyawan.detail_kehadiran');

Route::get('/admin/karyawan/{id}/detail', [AbsensiController::class, 'show'])->name('admin.karyawan.detail');

// Pastikan ada ->name('admin.rekap') di ujungnya
Route::get('/admin/rekap', [AdminController::class, 'rekapBulanan'])->name('admin.rekap');

Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('admin.absensi.destroy');
Route::delete('/absensi-clear', [AbsensiController::class, 'destroyAll'])->name('admin.absensi.destroyAll');