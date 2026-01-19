<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon; 
use App\Models\Absensi;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'jabatan',
        'role',
        'gaji_per_hari',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($karyawan) {
            $karyawan->qr_code = 'ABSEN-' . uniqid();
        });
    }

    // RELASI ABSENSI
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // ACCESSOR: ABSENSI TIDAK HADIR BULAN INI
    public function getAbsensiTidakHadirAttribute()
    {
        return $this->absensi()
            ->whereIn('status', ['alpha', 'izin', 'sakit'])
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->get();
    }
    // app/Models/User.php

}
