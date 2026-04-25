<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DhkpController;

Route::get('/', function () {
    return view('welcome');
});

// --- Group Route Penduduk ---
Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
Route::post('/penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
Route::get('/penduduk/download-format', [PendudukController::class, 'downloadFormat'])->name('penduduk.download-format');

// --- Route Dashboard ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --- Group Route DHKP (VERSI BERSIH) ---

// 1. Halaman Utama (Tabel & Search)
Route::get('/dhkp', [DhkpController::class, 'index'])->name('dhkp.index');

// Halaman untuk menampilkan Form (GET)
Route::get('/dhkp/import-halaman', [DhkpController::class, 'importView'])->name('dhkp.import-view');

// Proses untuk mengeksekusi file (POST)
// NAMA route ini 'dhkp.import' harus sama dengan yang ada di FORM ACTION
Route::post('/dhkp/import-eksekusi', [DhkpController::class, 'import'])->name('dhkp.import');
// 4. Download Template
Route::get('/dhkp/download-template', [DhkpController::class, 'downloadTemplate'])->name('dhkp.download-template');