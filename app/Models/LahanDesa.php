<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LahanDesa extends Model
{
    // Nama tabel kita tadi
    protected $table = 'lahan_desa';
    protected $primaryKey = 'id_lahan';

    // Kolom yang boleh diisi
    protected $fillable = [
        'nop_dhkp',
        'no_c_desa',
        'no_persil',
        'no_blok',
        'kelas_desa',
        'id_geometry',
        'keterangan_tambahan'
    ];

    // Relasi: Lahan Desa ini miliknya satu data DHKP
    public function dhkp(): BelongsTo
    {
        return $this->belongsTo(Dhkp::class, 'nop_dhkp', 'nop');
    }

    public function pemiliks()
{
    // Satu data lahan bisa punya banyak pemilik riil
    return $this->hasMany(PemilikLahan::class, 'lahan_desa_id');
}
}