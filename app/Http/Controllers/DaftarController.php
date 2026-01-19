<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class DaftarController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $bulan = Carbon::now()->format('Y-m');

        $karyawan = User::where('role', 'karyawan')->get();

        foreach ($karyawan as $k) {

            // CEK HADIR HARI INI
            $k->hadirHariIni = Absensi::where('user_id', $k->id)
                ->whereDate('tanggal', $today)
                ->exists();

            // TOTAL HADIR BULAN INI
            $k->totalHadir = Absensi::where('user_id', $k->id)
                ->where('tanggal', 'LIKE', "$bulan%")
                ->count();

            // HITUNG TANGGAL BULAN INI
            $tanggalDalamBulan = Carbon::now()->daysInMonth;

            // TOTAL TIDAK HADIR
            $k->totalTidakHadir = $tanggalDalamBulan - $k->totalHadir;

            // DAFTAR TANGGAL TIDAK HADIR
            $absenTanggal = Absensi::where('user_id', $k->id)
                ->where('tanggal', 'LIKE', "$bulan%")
                ->pluck('tanggal')
                ->toArray();

            $tanggalTidakHadir = [];

            for ($i = 1; $i <= $tanggalDalamBulan; $i++) {
                $tanggal = Carbon::now()->format("Y-m-") . str_pad($i, 2, "0", STR_PAD_LEFT);

                if (!in_array($tanggal, $absenTanggal)) {
                    $tanggalTidakHadir[] = $tanggal;
                }
            }

            $k->tanggalTidakHadir = $tanggalTidakHadir;

            // POTONGAN = 100.000 × tidak hadir
            $k->potongan = $k->totalTidakHadir * 100000;

            // GAJI BERSIH = GAJI NORMAL - POTONGAN (misal 30 hari × 100 ribu)
            $gajiNormal = 30 * 100000;
            $k->gajiBersih = $gajiNormal - $k->potongan;
        }

        return view('admin.daftar', compact('karyawan'));
    }
}
