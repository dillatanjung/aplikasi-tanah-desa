<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dhkp;
use App\Models\Permohonan; 
use App\Models\CDesaMaster;
use App\Models\CDesaDetail;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung progres DHKP (Total data DHKP)
        $totalDhkp = Dhkp::count();
        
        // 2. Menghitung peralihan nama (Permohonan dengan status proses)
        $totalPermohonan = Permohonan::where('status', 'proses')->count(); 
        
        // 3. Menghitung TOTAL NO. C (Dari CDesaMaster)
        $totalC = CDesaMaster::count(); 

        // 4. Menghitung TOTAL PERSIL (Dari CDesaDetail)
        // Pastikan variabel ini unik agar tidak menimpa data lain
        $totalPersilDetail = CDesaDetail::count();

        // Kirim semua variabel ke view dashboard
        return view('dashboard', compact(
            'totalDhkp', 
            'totalPermohonan', 
            'totalC', 
            'totalPersilDetail'
        ));
    }
}