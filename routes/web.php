<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DhkpController;
use App\Http\Controllers\LahanDesaController;
use App\Http\Controllers\CDesaController;

Route::get('/', function () {
    return view('welcome');
});

// --- Route Dashboard ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --- Group Route Penduduk ---
Route::prefix('penduduk')->name('penduduk.')->group(function() {
    Route::get('/', [PendudukController::class, 'index'])->name('index');
    Route::post('/import', [PendudukController::class, 'import'])->name('import');
    Route::get('/download-format', [PendudukController::class, 'downloadFormat'])->name('download-format');
});

// --- Group Route DHKP ---
Route::prefix('dhkp')->name('dhkp.')->group(function() {
    // Rute tambahan diletakkan di atas agar tidak bentrok dengan rute resource {id}
    Route::get('/import-halaman', [DhkpController::class, 'importView'])->name('import-view');
    Route::post('/import-eksekusi', [DhkpController::class, 'import'])->name('import');
    Route::get('/download-template', [DhkpController::class, 'downloadTemplate'])->name('download-template');
});
Route::resource('dhkp', DhkpController::class);

// --- Group Route Lahan Desa ---
Route::prefix('lahan-desa')->name('lahan.')->group(function() {
    Route::get('/', [LahanDesaController::class, 'index'])->name('index');
    Route::post('/store', [LahanDesaController::class, 'store'])->name('store');
    
    // Manajemen Pemilik & Mutasi
    Route::post('/store-pemilik', [LahanDesaController::class, 'storePemilik'])->name('storePemilik');
    Route::put('/update-pemilik/{id}', [LahanDesaController::class, 'updatePemilik'])->name('updatePemilik');
    Route::delete('/pemilik/{id}', [LahanDesaController::class, 'destroyPemilik'])->name('destroyPemilik');
    
    // Detail Pemilik (Ikon Mata) - CUKUP SATU RUTE SAJA
    Route::get('/detail/{id}', [LahanDesaController::class, 'detailPemilik'])->name('detail');
});

// --- Group Route C Desa ---
Route::resource('c-desa', CDesaController::class);