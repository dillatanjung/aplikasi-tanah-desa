<?php

namespace App\Http\Controllers;

use App\Models\CDesaMaster;
use App\Models\CDesaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CDesaController extends Controller
{
    // 1. DAFTAR DATA
    public function index()
    {
        $data = CDesaMaster::withCount('details')->latest()->get();
        return view('c_desa.index', compact('data'));
    }

    // 2. FORM TAMBAH DATA
    public function create()
    {
        return view('c_desa.create');
    }

    // 3. DETAIL DATA
    public function show($id)
    {
        $cDesa = CDesaMaster::with('details')->findOrFail($id);
        return view('c_desa.show', compact('cDesa'));
    }

    // 4. SIMPAN DATA BARU
    public function store(Request $request)
    {
        // Validasi: file_scan kita naikkan jadi 10MB agar bisa masuk dulu untuk dikompres
        $request->validate([
            'no_c_desa' => 'required|unique:c_desa_master,no_c_desa',
            'nama_wajib_pajak' => 'required',
            'file_scan' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $nama_file = null;
            if ($request->hasFile('file_scan')) {
                $file = $request->file('file_scan');
                $nama_file = time() . '_' . $request->no_c_desa . '.' . $file->getClientOriginalExtension();
                
                // Path tujuan simpan di folder public agar mudah diakses
                $path = public_path('uploads/c_desa_scans');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

               // --- PROSES KOMPRES (Gunakan cara ini agar seragam dan lancar) ---
// Pastikan di bagian paling atas controller sudah ada: use Intervention\Image\Facades\Image;

if (!File::isDirectory($path)) {
    File::makeDirectory($path, 0777, true, true);
}

// Proses resize ke 1200px dan simpan kualitas 60%
Image::make($file->getRealPath())->resize(1200, null, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
})->save($path . '/' . $nama_file, 60);

                // Path yang disimpan ke database (relatif)
                $nama_file = 'uploads/c_desa_scans/' . $nama_file;
            }

            // Simpan Data Master
            $master = CDesaMaster::create([
                'no_c_desa' => $request->no_c_desa,
                'nama_wajib_pajak' => $request->nama_wajib_pajak,
                'file_scan' => $nama_file,
            ]);

            // Simpan Data Detail (Rincian Bidang)
            if ($request->has('details')) {
                foreach ($request->details as $item) {
                    $master->details()->create([
                        'klasifikasi' => $item['klasifikasi'],
                        'no_persil' => $item['no_persil'],
                        'kelas_desa' => $item['kelas_desa'],
                        'luas_ha' => $item['luas_ha'] ?? 0,
                        'sebab_perubahan' => $item['sebab_perubahan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('c-desa.index')->with('success', 'Data C Desa berhasil disimpan dan gambar telah dikompres!');

        } catch (\Exception $e) {
            DB::rollback();
            // Jika upload gagal, hapus file fisik yang mungkin sudah terlanjur dibuat
            if ($nama_file && file_exists(public_path($nama_file))) {
                unlink(public_path($nama_file));
            }
            return redirect()->back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    // 5. HALAMAN EDIT
    public function edit($id)
    {
        $cDesa = CDesaMaster::with('details')->findOrFail($id);
        return view('c_desa.edit', compact('cDesa'));
    }

    // 6. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_c_desa' => 'required|unique:c_desa_master,no_c_desa,'.$id,
            'nama_wajib_pajak' => 'required',
            'file_scan' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $master = CDesaMaster::findOrFail($id);
            
            if ($request->hasFile('file_scan')) {
                // Hapus file lama jika ada
                if ($master->file_scan && file_exists(public_path($master->file_scan))) {
                    unlink(public_path($master->file_scan));
                }

                $file = $request->file('file_scan');
                $nama_file = time() . '_' . $request->no_c_desa . '.' . $file->getClientOriginalExtension();
                $path = public_path('uploads/c_desa_scans');

                // --- Ganti Baris 143-146 dengan ini, bolo ---

// Pastikan folder tujuan ada
if (!File::exists($path)) {
    File::makeDirectory($path, 0777, true, true);
}

// Proses Kompres Ulang (Cara v2 yang stabil)
Image::make($file->getRealPath())->resize(1200, null, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
})->save($path . '/' . $nama_file, 60);
                $master->file_scan = 'uploads/c_desa_scans/' . $nama_file;
            }

            $master->update([
                'no_c_desa' => $request->no_c_desa,
                'nama_wajib_pajak' => $request->nama_wajib_pajak,
                'file_scan' => $master->file_scan,
            ]);

            // Update Detail (Hapus lama, buat baru)
            if ($request->has('details')) {
                $master->details()->delete(); 
                foreach ($request->details as $item) {
                    $master->details()->create([
                        'klasifikasi' => $item['klasifikasi'],
                        'no_persil' => $item['no_persil'],
                        'kelas_desa' => $item['kelas_desa'],
                        'luas_ha' => $item['luas_ha'] ?? 0,
                        'sebab_perubahan' => $item['sebab_perubahan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('c-desa.index')->with('success', 'Data berhasil diperbarui, bolo!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    // 7. PROSES HAPUS
    public function destroy($id)
    {
        try {
            $cDesa = CDesaMaster::findOrFail($id);
            
            // Hapus file fisik
            if ($cDesa->file_scan && file_exists(public_path($cDesa->file_scan))) {
                unlink(public_path($cDesa->file_scan));
            }

            $cDesa->delete();

            return redirect()->route('c-desa.index')->with('success', 'Data C Desa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}