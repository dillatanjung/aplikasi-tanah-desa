<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuC extends Model
{
    // Mengarahkan ke nama tabel yang benar hasil migrasi tadi
    protected $table = 'buku_cs'; 

    protected $fillable = ['no_c', 'nama_pemilik'];
}