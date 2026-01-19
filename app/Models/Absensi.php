<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model

{
    

    protected $table = 'absensi';

    protected $fillable = [
    'user_id',
    'tanggal',
    'jam_masuk',
    'jam_pulang',
    'status',
    'keterangan',
    'latitude',
    'longitude',
    'dokumen', 
    'menit_lembur'
];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    


}

