<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dhkp;
use App\Models\Permohonan; // 1. Hapus 's' di sini
use App\Models\BukuC;
use App\Models\Persil;


class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah total data dari masing-masing tabel
        $totalDhkp = Dhkp::count();
        
        // 2. Ubah juga di sini menjadi Permohonan (tunggal)
        $totalPermohonan = Permohonan::where('status', 'proses')->count(); 
        
        $totalBukuC = BukuC::count();
        $totalPersil = Persil::count();

        return view('dashboard', compact('totalDhkp', 'totalPermohonan', 'totalBukuC', 'totalPersil'));
    }
}