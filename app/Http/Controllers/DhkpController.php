<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dhkp;
use App\Imports\DhkpImport;
use Maatwebsite\Excel\Facades\Excel;

class DhkpController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->search);

        $dhkps = Dhkp::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_wp', 'like', "%{$search}%")
                      ->orWhere('nop', 'like', "%{$search}%")
                      ->orWhere('alamat_wp', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); 

        return view('dhkp.index', compact('dhkps'));
    }

    public function importView()
    {
        return view('dhkp.import');
    }

    public function import(Request $request) 
    {
        // 1. Kita longgarkan validasi agar tidak mental karena masalah ekstensi file
        $request->validate(['file' => 'required' ]);
        $data = Excel::toArray(new DhkpImport, $request->file('file'));
    //dd($data);
        try {
            $file = $request->file('file');
            
            // 2. PAKSA LIHAT ISI: Jika ini muncul layar hitam, berarti Laravel bisa baca file.
            // Jika ini TIDAK muncul dan malah refresh, berarti masalah ada di Route atau Form Action.
            $data = Excel::toArray(new DhkpImport, $file);
            // dd($data); // <--- Hapus tanda // di depan dd ini kalau mau ngetes beneran

            // 3. Eksekusi Import
            Excel::import(new DhkpImport, $file);
            
            return redirect()->route('dhkp.index')->with('success', 'Import selesai! Data masuk.');
            
        } catch (\Exception $e) {
            // Menangkap semua error (Database, File, atau Logic)
            return back()->with('error', 'Waduh, sistem bilang: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=template_dhkp.csv",
        ];

        $columns = ['NOP', 'No. Blok', 'No. Persil', 'Nama WP', 'Alamat WP', 'Luas Bumi', 'Luas Bangunan'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['33.24.000.000', '1', '137', 'CONTOH NAMA', 'ALAMAT DESA', '1000', '0']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}