<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CDesaDetail extends Model
{
    protected $table = 'c_desa_detail';
    protected $fillable = [
        'c_desa_master_id', 'klasifikasi', 'no_persil', 'kelas_desa',
        'luas_ha', 'luas_da', 'luas_s', 'ipeda_r', 'ipeda_s', 'sebab_perubahan'
    ];

    // Relasi: Rincian ini milik dari satu data master
    public function master()
    {
        return $this->belongsTo(CDesaMaster::class, 'c_desa_master_id');
    }
}