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
}