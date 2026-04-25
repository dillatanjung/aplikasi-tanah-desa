<?php

namespace App\Imports;

use App\Models\Dhkp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;

class DhkpImport implements ToModel, WithStartRow, WithUpserts, WithUpsertColumns
{
    public function startRow(): int
    {
        return 2; 
    }

    public function uniqueBy()
    {
        return 'nop';
    }

    public function upsertColumns()
    {
        return ['no_blok', 'no_persil', 'nama_wp', 'alamat_wp', 'luas_bumi', 'luas_bng'];
    }

    public function model(array $row)
    {
        // 1. Ambil data NOP dan bersihkan dari spasi
        $nopRaw = isset($row[0]) ? trim($row[0]) : null;

        // 2. Jika NOP kosong, lewati baris ini
        if (!$nopRaw) {
            return null;
        }

        // 3. Fungsi pembantu (Closure) diletakkan di dalam fungsi model dengan benar
        $cleanNumber = function($value) {
            if (!$value) return 0;
            // Menghapus semua karakter non-angka (seperti titik ribuan)
            $clean = preg_replace('/[^0-9]/', '', $value);
            return (float) $clean;
        };

        // 4. Proses input ke database
        return new Dhkp([
            'nop'        => (string) $nopRaw,
            'no_blok'    => $row[1] ?? '-',
            'no_persil'  => $row[2] ?? '-',
            'nama_wp'    => $row[3] ?? 'TANPA NAMA',
            'alamat_wp'  => $row[4] ?? '-',
            // Menggunakan fungsi cleanNumber untuk memastikan 10.000 jadi 10000
            'luas_bumi'  => $cleanNumber($row[5]), 
            'luas_bng'   => $cleanNumber($row[6]),
        ]);
    }
}