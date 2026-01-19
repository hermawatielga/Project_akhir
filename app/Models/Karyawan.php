<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'jabatan',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($karyawan) {
            $karyawan->qr_code = 'ABSEN-' . uniqid();
        });
    }

public function absensi()
{
    return $this->hasMany(Absensi::class, 'user_id');
}





}
