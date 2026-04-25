<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Imports\PendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduks = Penduduk::all();
        return view('penduduk.index', compact('penduduks'));
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new PendudukImport, $request->file('file'));
        
        return redirect()->back()->with('success', 'Data Penduduk Berhasil Diimport!');
    }

    public function downloadFormat()
    {
        // Nama kolom yang akan jadi header di Excel
        $header = ['nik', 'nama', 'alamat', 'pekerjaan'];
        
        // Data contoh biar user gak bingung
        $data = [
            ['3324010101010001', 'Budi Santoso', 'Jl. Merdeka No. 1, Kendal', 'Petani']
        ];

        // Buat koleksi data
        $exportData = collect([$header, $data[0]]);

        // Download langsung sebagai file .xlsx
        return Excel::download(new class($exportData) implements \Maatwebsite\Excel\Concerns\FromCollection {
            protected $data;
            public function __construct($data) { $this->data = $data; }
            public function collection() { return $this->data; }
        }, 'format_import_penduduk.xlsx');
    }
} // <--- KURUNG INI WAJIB ADA UNTUK MENUTUP CLASS