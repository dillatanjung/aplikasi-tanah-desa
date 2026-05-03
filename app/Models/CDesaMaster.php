<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CDesaMaster extends Model
{
    protected $table = 'c_desa_master';
    protected $fillable = ['no_c_desa', 'nama_wajib_pajak', 'file_scan'];

    // Relasi: Satu Nomor C punya banyak rincian bidang tanah
    public function details()
    {
        return $this->hasMany(CDesaDetail::class, 'c_desa_master_id');
    }
}