<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dhkp extends Model
{
    use HasFactory;

    // WAJIB ADA INI BOLO!
    protected $fillable = [
        'nop', 
        'no_blok', 
        'no_persil', 
        'nama_wp', 
        'alamat_wp', 
        'luas_bumi', 
        'luas_bng'
    ];
    public function pemiliks()
{
    // Hubungkan ID di tabel dhkps ke kolom lahan_desa_id di tabel pemilik_lahans
    return $this->hasMany(PemilikLahan::class, 'lahan_desa_id', 'id');
}
}