<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan Halaman Login
     */
    public function showLogin()
    {
        // Jika sudah login, otomatis arahkan ke halaman sesuai role
        if (Auth::check()) {
            return $this->redirectUserByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses Autentikasi
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        $credentials = $request->only('email', 'password');

        // 2. Proses Login
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Berikan pesan sukses yang mencantumkan email/nama agar user tahu dia login sebagai siapa
            return $this->redirectUserByRole($user)
                ->with('success', "Selamat datang, {$user->name} ({$user->email})");
        }

        // 3. Jika Gagal: Kembalikan dengan Error yang spesifik
        return back()->withErrors([
            'loginError' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Helper untuk Manajemen Redirect berdasarkan Role
     */
    private function redirectUserByRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($user->role === 'karyawan') {
            // Kita gunakan redirect()->route() secara langsung 
            // agar tidak "terjebak" di URL lama (intended)
            return redirect()->route('karyawan.absensi');
        }

        // Jika role tidak dikenal
        Auth::logout();
        return redirect()->route('login')->withErrors(['loginError' => 'Akses ditolak: Role tidak dikenali.']);
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}