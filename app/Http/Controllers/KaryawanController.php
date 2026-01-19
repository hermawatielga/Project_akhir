<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KaryawanController extends Controller
{
    /* ============================================================
        ADMIN – CRUD KARYAWAN
    ============================================================ */

    public function index()
    {
        $users = User::where('role', 'karyawan')->get();
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required',
            'email'   => 'required|email|unique:users,email',
            'jabatan' => 'nullable',
            'gaji_per_hari' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'name'    => $request->nama,
            'email'   => $request->email,
            'jabatan' => $request->jabatan,
            'role' => 'karyawan', 
            'gaji_per_hari' => $request->gaji_per_hari,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $request->validate([
            'nama'    => 'required',
            'email'   => 'required|email|unique:users,email,' . $karyawan->id,
            'jabatan' => 'nullable',
            'password' => 'nullable',
        ]);

        $karyawan->update([
            'name'    => $request->nama,
            'email'   => $request->email,
            'jabatan' => $request->jabatan,
            'gaji_per_hari' => $request->gaji_per_hari,
        ]);

        if (filled($request->password)) {
            $karyawan->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Karyawan berhasil dihapus.');
    }

    /* ============================================================
        KARYAWAN – QR CODE & DASHBOARD
    ============================================================ */

    public function dashboard()
    {
        // Mendefinisikan $users agar tidak error di View
        $users = User::where('role', 'karyawan')->get();

        $totalKaryawan = $users->count();

        $absensiHariIni = Absensi::whereDate('tanggal', today())->count();

        $riwayatAbsensi = Absensi::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('karyawan.halaman', compact(
            'users', // Variabel ini yang tadi hilang
            'totalKaryawan',
            'absensiHariIni',
            'riwayatAbsensi'
        ));
    }

    public function absen()
    {
        Absensi::create([
            'user_id' => auth()->id(), // Pastikan menggunakan user_id sesuai tabel
            'tanggal' => date('Y-m-d'),
            'status'  => 'hadir',
        ]);

        return back()->with('success', 'Absen berhasil!');
    }

    public function scanQR()
    {
        return view('karyawan.scan');
    }

    public function showQR()
    {
        $karyawan = auth()->user();
        return view('karyawan.scan', compact('karyawan'));
    }

    public function generateQR()
    {
        $user = auth()->user();
        $user->qr_code = 'ABSEN-' . uniqid();
        $user->save();

        return back()->with('success', 'QR berhasil diperbarui!');
    }

    public function prosesQR(Request $request)
    {
        $karyawan = User::where('qr_code', $request->kode)->first();

        if (!$karyawan) {
            return back()->with('error', 'QR Code tidak valid');
        }

        auth()->login($karyawan);
        return redirect()->route('karyawan.dashboard');
    }
    public function daftarKaryawan(Request $request)
{
    // Ambil data karyawan beserta absensi bulan ini
    $karyawan = \App\Models\User::where('role', 'karyawan')
        ->with(['absensi' => function ($q) {
            $q->whereMonth('tanggal', now()->month)
              ->whereYear('tanggal', now()->year);
        }])->get();

    foreach ($karyawan as $k) {
        $totalPotongan = 0;
        $totalUangLembur = 0;
        $totalMenitLembur = 0;
        $jmlHadir = 0;

        foreach ($k->absensi as $absen) {
            $status = strtolower($absen->status);

            if ($status == 'hadir') {
                $jmlHadir++;
                
                // 1. HITUNG TERLAMBAT
                if ($absen->jam_masuk > '08:00:59') {
                    $jamMasuk = \Carbon\Carbon::parse($absen->jam_masuk);
                    $batas = \Carbon\Carbon::parse('08:00:00');
                    $menitLate = $batas->diffInMinutes($jamMasuk);
                    $totalPotongan += ($menitLate * 238); 
                }
                
                // 2. HITUNG LEMBUR
                if ($absen->menit_lembur > 0) {
                    $totalMenitLembur += $absen->menit_lembur;
                    $totalUangLembur += ($absen->menit_lembur * 416);
                }
            } 
            
            if ($status == 'izin') $totalPotongan += 0;
            if ($status == 'alpha') $totalPotongan += 0;
        }

        // Data Dasar
        $k->totalHadir = $jmlHadir;
        $k->potongan = $totalPotongan; 
        
        // AMBIL GAJI POKOK
        $gajiPokokDB = $k->gaji_per_hari ?? $k->gaji_pokok ?? 0;

        // LOGIKA UTAMA: Cek apakah sudah pernah absen
        if ($jmlHadir > 0 || $totalPotongan > 0) {
            // Jika sudah ada aktivitas (Hadir/Izin/Alpha), hitung gajinya
            $k->gajiBersih = ($gajiPokokDB + $totalUangLembur) - $totalPotongan;
            $k->sudah_absen = true; 
        } else {
            // Jika karyawan baru (belum ada data absen bulan ini)
            $k->gajiBersih = 0;
            $k->sudah_absen = false;
        }
        
        if($k->gajiBersih < 0) $k->gajiBersih = 0;
    }

    return view('admin.daftar', compact('karyawan'));
}
public function detailKehadiran(Request $request)
{
    $userId = auth()->id();
    $user = auth()->user();
    
    // Mengambil filter bulan & tahun dari request (default bulan/tahun sekarang)
    $bulan = (int) $request->get('bulan', date('m'));
    $tahun = (int) $request->get('tahun', date('Y'));

    // Ambil data absensi berdasarkan filter
    $absensi = Absensi::where('user_id', $userId)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun) 
                ->orderBy('tanggal', 'asc')
                ->get();

    // Inisialisasi hitungan
    $totalPotongan = 0;
    $totalLembur = 0;

    foreach ($absensi as $absen) {
        $status = strtolower($absen->status);
        
        if ($status == 'hadir') {
            // 1. Hitung denda jika terlambat (Batas 08:00)
            if ($absen->jam_masuk > '08:00:59') {
                $late = Carbon::parse('08:00:00')->diffInMinutes(Carbon::parse($absen->jam_masuk));
                $totalPotongan += ($late * 238);
            }
            // 2. Hitung lembur jika ada (Tarif 416)
            if ($absen->menit_lembur > 0) {
                $totalLembur += ($absen->menit_lembur * 416);
            }
        } elseif ($status == 'izin') {
            $totalPotongan += 50000;
        } elseif ($status == 'alpha') {
            $totalPotongan += 100000;
        }
    }

    $stats = [
        'hadir' => $absensi->where('status', 'hadir')->count(),
        'izin'  => $absensi->where('status', 'izin')->count(),
        'sakit' => $absensi->where('status', 'sakit')->count(),
        'alpha' => $absensi->where('status', 'alpha')->count(),
        'total_potongan' => $totalPotongan,
        'total_lembur'   => $totalLembur
    ];

    // Perhatikan: compact menggunakan variabel yang ADA ('stats', bukan 'status')
    return view('karyawan.detail_kehadiran', compact('absensi', 'stats', 'bulan', 'tahun'));
}
}