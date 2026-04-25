<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $fillable = ['nik', 'nama', 'alamat', 'pekerjaan'];
}