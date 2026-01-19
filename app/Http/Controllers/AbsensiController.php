<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Absensi::where('user_id', $userId);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        if ($request->exact_date) {
            $query->whereDate('tanggal', $request->exact_date);
        }

        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $absen = Absensi::where('user_id', $userId)
                        ->where('tanggal', $today)
                        ->first();

        $riwayat = $query->orderBy('tanggal', 'desc')->get();

        return view('karyawan.absensi', compact('absen', 'riwayat'));
    }

    public function absenMasuk(Request $request)
    {
        $sekarang = Carbon::now('Asia/Jakarta');
        $jam = $sekarang->format('H:i');
        $tanggalHariIni = $sekarang->format('Y-m-d');

        // 1. VALIDASI JAM MULAI
        if ($jam < '07:00') {
            return redirect()->back()->with('error', 'Maaf, absen masuk baru dibuka pukul 07.00.');
        }

        $request->validate([
            'status' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'dokumen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cekAbsen = Absensi::where('user_id', Auth::id())->where('tanggal', $tanggalHariIni)->first();
        if ($cekAbsen) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // 2. VALIDASI GPS
        $daftarKantor = [
            ['nama' => 'Kantor Utama', 'lat' => -7.4645961, 'lng' => 112.4233275, 'radius' => 500],
            ['nama' => 'Kantor Cabang', 'lat' => -7.453665, 'lng' => 112.4075066, 'radius' => 500],
            ['nama' => 'Selalukopi', 'lat' => -7.489342, 'lng' => 112.4167471, 'radius' => 500]
        ];

        $isDiLokasi = false;
        $jarakTerdekat = 999999;
        foreach ($daftarKantor as $kantor) {
            $jarak = $this->hitungJarak($request->latitude, $request->longitude, $kantor['lat'], $kantor['lng']);
            if ($jarak < $jarakTerdekat) $jarakTerdekat = $jarak;
            if ($jarak <= $kantor['radius']) { $isDiLokasi = true; break; }
        }

        if ($request->status == 'hadir' && !$isDiLokasi) {
            return back()->with('error', 'Posisi terlalu jauh. Jarak: ' . round($jarakTerdekat) . 'm');
        }

        // 3. HITUNG DENDA TERLAMBAT (Batas 08:00, Tarif 238)
        $statusTerlambat = "";
        if ($request->status == 'hadir' && $sekarang->format('H:i:s') > '08:00:59') {
            $menitLate = Carbon::parse('08:00:00')->diffInMinutes($sekarang);
            $denda = $menitLate * 238;
            $statusTerlambat = "[TERLAMBAT $menitLate Menit - Potongan Rp " . number_format($denda, 0, ',', '.') . "]";
        }

        // 4. SIMPAN
        $absensi = new Absensi();
        $absensi->user_id = Auth::id();
        $absensi->tanggal = $tanggalHariIni;
        $absensi->jam_masuk = $sekarang->format('H:i:s');
        $absensi->status = $request->status;
        $absensi->latitude = $request->latitude;
        $absensi->longitude = $request->longitude;
        $absensi->menit_lembur = 0;
        $absensi->keterangan = $statusTerlambat . " " . ($request->keterangan ?? '');

        if ($request->hasFile('dokumen')) {
            $nama_file = time() . "_" . $request->file('dokumen')->getClientOriginalName();
            $request->file('dokumen')->move(public_path('storage/surat_izin'), $nama_file);
            $absensi->dokumen = $nama_file;
        }

        $absensi->save();
        return redirect()->back()->with('success', 'Absen masuk berhasil! ' . $statusTerlambat);
    }

    public function absenPulang()
    {
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $sekarang = Carbon::now('Asia/Jakarta');

        $absen = Absensi::where('user_id', Auth::id())->where('tanggal', $today)->first();
        if (!$absen) return back()->with('error', 'Kamu belum absen masuk.');
        if ($absen->jam_pulang != null) return back()->with('error', 'Sudah absen pulang.');

        // HITUNG LEMBUR (Batas 15:00)
        $batasPulang = Carbon::createFromTimeString('15:00:00', 'Asia/Jakarta');
        $menitLembur = 0;
        if ($sekarang->greaterThan($batasPulang)) {
            $menitLembur = $sekarang->diffInMinutes($batasPulang);
        }

        $absen->update([
            'jam_pulang' => $sekarang->format('H:i:s'),
            'menit_lembur' => $menitLembur,
        ]);

        return back()->with('success', "Berhasil pulang! Lembur: $menitLembur menit.");
    }
public function show($id) 
{
    $user = User::findOrFail($id);
    
    // Ambil riwayat bulan ini agar sinkron
    $riwayatAbsensi = Absensi::where('user_id', $id)
                        ->whereMonth('tanggal', now()->month)
                        ->whereYear('tanggal', now()->year)
                        ->orderBy('tanggal', 'desc')
                        ->get();

    $totalPotongan = 0;
    $totalLemburNominal = 0;
    $totalMenitLembur = 0;

    // AMBIL GAJI DARI DATABASE (PENTING!)
    // Sesuaikan nama kolomnya, jika di DB namanya 'gaji_per_hari' gunakan itu.
    $gajiPokok = $user->gaji_pokok ?? $user->gaji_per_hari ?? 0;

    foreach ($riwayatAbsensi as $absen) {
        $st = strtolower($absen->status);
        if ($st == 'hadir') {
            // 1. Logika Terlambat (Batas 08:00, Tarif 238)
            if ($absen->jam_masuk > '08:00:59') {
                $m = \Carbon\Carbon::parse('08:00:00')->diffInMinutes(\Carbon\Carbon::parse($absen->jam_masuk));
                $totalPotongan += ($m * 238);
            }
            // 2. Logika Lembur (Tarif 416)
            if ($absen->menit_lembur > 0) {
                $totalMenitLembur += $absen->menit_lembur;
                $totalLemburNominal += ($absen->menit_lembur * 416);
            }
        } elseif ($st == 'izin') {
            $totalPotongan += 50000;
        } elseif ($st == 'alpha') {
            $totalPotongan += 100000;
        }
    }

    // 3. Hitung Gaji Bersih
    $gajiBersih = ($gajiPokok + $totalLemburNominal) - $totalPotongan;

    return view('admin.detail_karyawan', [
        'user' => $user,
        'riwayatAbsensi' => $riwayatAbsensi,
        'totalPotongan' => $totalPotongan,
        'totalLembur' => $totalLemburNominal,
        'totalMenitLembur' => $totalMenitLembur,
        'gajiPokok' => $gajiPokok, // Kirim ke view
        'gajiBersih' => $gajiBersih, // Kirim ke view
        'start' => \Carbon\Carbon::now()->startOfMonth(),
        'end' => \Carbon\Carbon::now()->endOfMonth()
    ]);
}  
  public function destroy($id)
    {
        Absensi::findOrFail($id)->delete();
        return back()->with('success', 'Data dihapus.');
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}