<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persil extends Model
{
    protected $table = 'persils';

    protected $fillable = ['nomor_persil', 'kelas_tanah'];
}