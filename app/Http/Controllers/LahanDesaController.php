<?php

namespace App\Http\Controllers;

use App\Models\Dhkp; 
use App\Models\PemilikLahan; 
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class LahanDesaController extends Controller
{
    /**
     * Tampilkan data lahan dan pemilik (mutasi)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data_lahan = Dhkp::with('pemiliks')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nop', 'like', "%{$search}%")
                      ->orWhere('nama_wp', 'like', "%{$search}%");
                });
            })
            ->latest() 
            ->paginate(10) 
            ->withQueryString(); 

        return view('lahan.index', compact('data_lahan'));
    }

    /**
     * Simpan Mutasi Baru
     */
    public function storePemilik(Request $request)
    {
        $request->validate([
            'lahan_desa_id'     => 'required|exists:dhkps,id',
            'nama_pemilik_baru' => 'required|string|max:255',
            'luas_milik'        => 'required|numeric',
            'bukti_peralihan'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);

        $data = $request->only(['lahan_desa_id', 'nama_pemilik_baru', 'alamat_pemilik', 'luas_milik', 'status', 'no_c_desa']);

        if ($request->hasFile('bukti_peralihan')) {
            $data['bukti_peralihan'] = $this->handleUpload($request->file('bukti_peralihan'));
        }

        PemilikLahan::create($data);
        return redirect()->back()->with('success', 'Data mutasi baru berhasil ditambahkan, bolo!');
    }

    /**
     * Update Data Mutasi
     */
    public function updatePemilik(Request $request, $id)
    {
        $pemilik = PemilikLahan::findOrFail($id);

        $request->validate([
            'nama_pemilik_baru' => 'required|string|max:255',
            'luas_milik'        => 'required|numeric',
            'bukti_peralihan'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->only(['nama_pemilik_baru', 'alamat_pemilik', 'luas_milik', 'status', 'no_c_desa']);

        if ($request->hasFile('bukti_peralihan')) {
            // Hapus file lama jika ada (Samakan path: upload/bukti_mutasi)
            if ($pemilik->bukti_peralihan) {
                $oldPath = public_path('upload/bukti_mutasi/' . $pemilik->bukti_peralihan);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $data['bukti_peralihan'] = $this->handleUpload($request->file('bukti_peralihan'));
        }

        $pemilik->update($data);
        return redirect()->back()->with('success', 'Data pemilik berhasil diperbarui, bolo!');
    }

    /**
     * Detail Data Pemilik
     */
    public function detailPemilik($id)
    {
        $pemilik = PemilikLahan::with('dhkp')->findOrFail($id);
        return view('lahan.detail', compact('pemilik'));
    }

    /**
     * Hapus Data Mutasi
     */
    public function destroyPemilik($id)
    {
        $pemilik = PemilikLahan::findOrFail($id);

        if ($pemilik->bukti_peralihan) {
            $filePath = public_path('upload/bukti_mutasi/' . $pemilik->bukti_peralihan);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $pemilik->delete();
        return redirect()->back()->with('success', 'Data mutasi berhasil dihapus!');
    }

    /**
     * Proses Upload dan Kompresi Image (Private Helper)
     */
    private function handleUpload($file)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        // SINKRONKAN DISINI: Pakai 'upload' sesuai keinginanmu sebelumnya
        $path = public_path('upload/bukti_mutasi');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            // Kompresi Gambar
            Image::make($file->getRealPath())->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path . '/' . $filename, 80);
        } else {
            // Move PDF langsung
            $file->move($path, $filename);
        }

        return $filename;
    }
}