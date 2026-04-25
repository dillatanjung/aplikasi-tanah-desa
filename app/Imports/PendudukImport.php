<?php

namespace App\Imports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\ToModel;

class PendudukImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
  public function model(array $row)
{
    return new Penduduk([
        'nik'       => $row[0], // Kolom A
        'nama'      => $row[1], // Kolom B
        'alamat'    => $row[2], // Kolom C
        'pekerjaan' => $row[3], // Kolom D
    ]);
}
}
