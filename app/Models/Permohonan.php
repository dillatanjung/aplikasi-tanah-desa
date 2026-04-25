<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya sesuai dengan yang ada di database (hasil migrate tadi)
    protected $table = 'permohonans'; 

    // Kolom yang boleh diisi
    protected $fillable = ['nomor_surat', 'jenis_mutasi', 'status'];
}