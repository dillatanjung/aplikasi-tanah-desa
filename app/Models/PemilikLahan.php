<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemilikLahan extends Model
{
    protected $table = 'pemilik_lahans';

    protected $fillable = [
        'lahan_desa_id',
        'nama_pemilik_baru',
        'alamat_pemilik',
        'luas_milik',
        'no_c_desa',
        'status',
        'sebab_peralihan',
        'bukti_peralihan', // Ganti 'scan_peralihan' menjadi 'bukti_peralihan' sesuai database
    ];

    public function dhkp()
    {
        return $this->belongsTo(Dhkp::class, 'lahan_desa_id', 'id');
    }
}