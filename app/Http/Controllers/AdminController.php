<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Batas waktu masuk disesuaikan menjadi pukul 07:00
    protected $batasMasuk = '07:00'; 
    protected $batasLembur = '15:00';
    protected $tarifTerlambat = 500;  // Rp 500 / menit
    protected $tarifLembur = 416;     // Rp 416 / menit (± Rp 25rb/jam)
    protected $dendaIzin = 50000;
    protected $dendaAlpha = 100000;


    public function rekapBulanan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $karyawan = User::where('role', 'karyawan')
            ->with(['absensi' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            }])->get();

        foreach ($karyawan as $k) {
            $totalPotongan = 0;
            $totalUangLembur = 0;
            $totalMenitLembur = 0;

            foreach ($k->absensi as $absen) {
                // HITUNG TERLAMBAT MASUK (Batas 07:00)
                if ($absen->status == 'hadir' && $absen->jam_masuk) {
                    $jamMasuk = \Carbon\Carbon::parse($absen->jam_masuk);
                    if ($jamMasuk->format('H:i') > '07:00') {
                        $menitTerlambat = \Carbon\Carbon::parse('07:00')->diffInMinutes($jamMasuk);
                        $totalPotongan += ($menitTerlambat * 500); // Denda 500/menit
                    }
                }

                // HITUNG POTONGAN STATUS
                if (strtolower($absen->status) == 'izin') $totalPotongan += 50000;
                if (strtolower($absen->status) == 'alpha') $totalPotongan += 100000;

                // HITUNG LEMBUR (Batas 15:00)
                if ($absen->menit_lembur > 0) {
                    $totalMenitLembur += $absen->menit_lembur;
                    $totalUangLembur += ($absen->menit_lembur * 416); // Rp 25.000 per jam
                }
            }

            // SIMPAN KE OBJEK (WAJIB!)
            $k->totalHadir = $k->absensi->where('status', 'hadir')->count();
            $k->potongan = $totalPotongan; 
            $k->totalMenitLembur = $totalMenitLembur;
            $k->totalUangLembur = $totalUangLembur;

            // HITUNG GAJI BERSIH
            $gajiPokok = $k->totalHadir * 100000;
            $k->gajiBersih = ($gajiPokok + $totalUangLembur) - $totalPotongan;
        }

        // CEK DISINI: Jika file blade Anda namanya daftar.blade.php, maka ganti 'admin.rekap' menjadi 'admin.daftar'
        return view('admin.daftar', compact('karyawan', 'bulan', 'tahun'));
    }

    public function showDetail($id)
    {
        $user = User::findOrFail($id);
        
        $riwayatAbsensi = Absensi::where('user_id', $id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPotongan = 0;
        $totalLembur = 0;
        $totalMenitLembur = 0;

        foreach ($riwayatAbsensi as $absen) {
            // Logika Potongan Terlambat
            if ($absen->status == 'hadir' && !empty($absen->jam_masuk)) {
                $jamMasuk = Carbon::parse($absen->jam_masuk);
                if ($jamMasuk->format('H:i') > $this->batasMasuk) {
                    $selisih = Carbon::parse($this->batasMasuk)->diffInMinutes($jamMasuk);
                    $totalPotongan += ($selisih * $this->tarifTerlambat); 
                }
            }

            // Logika Potongan Status
            $status = strtolower($absen->status);
            if ($status == 'izin') $totalPotongan += $this->dendaIzin;
            if ($status == 'alpha') $totalPotongan += $this->dendaAlpha;

            // Logika Bonus Lembur
            if ($absen->menit_lembur > 0) {
                $totalMenitLembur += $absen->menit_lembur;
                $totalLembur += ($absen->menit_lembur * $this->tarifLembur); 
            }
        }

        return view('admin.detail_karyawan', [
            'user' => $user,
            'riwayatAbsensi' => $riwayatAbsensi,
            'totalPotongan' => $totalPotongan,
            'totalLembur' => $totalLembur,
            'totalMenitLembur' => $totalMenitLembur,
            'start' => now()->startOfMonth(),
            'end' => now()->endOfMonth()
        ]);
    }

    public function dashboard(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $totalKaryawan = User::where('role', 'karyawan')->count();
        
        $stats = [
            'hadir' => Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'hadir')->count(),
            'izin'  => Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'izin')->count(),
            'sakit' => Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'sakit')->count(),
            'alpha' => Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'alpha')->count(),
        ];

        $riwayatAbsensi = Absensi::with('user')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.dashboard', compact('totalKaryawan', 'riwayatAbsensi', 'bulan', 'tahun', 'stats'));
    }

    public function destroyAllAbsensi(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        if ($bulan && $tahun) {
            Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->delete();
            return redirect()->back()->with('success', "Data berhasil dikosongkan.");
        }
        return redirect()->back()->with('error', "Gagal menghapus data.");
    }
}