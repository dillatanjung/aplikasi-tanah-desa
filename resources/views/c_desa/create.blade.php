@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Input C Desa </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('c-desa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label>Nomor C Desa</label>
                        <input type="text" name="no_c_desa" class="form-control" placeholder="Masukkan No C. Desa" required>
                    </div>
                    <div class="col-md-5">
                        <label>Nama </label>
                        <input type="text" name="nama_wajib_pajak" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="col-md-4">
                        <label>Upload Hasil Scan (JPG/PNG/PDF)</label>
                        <input type="file" name="file_scan" class="form-control">
                    </div>
                </div>

                <hr>
                <h5>Rincian Bidang Tanah</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Klasifikasi</th>
                            <th>No Persil</th>
                            <th>Kelas Desa</th>
                            <th>Luas (ha)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bidang-tanah">
                        <tr>
                            <td>
                                <select name="details[0][klasifikasi]" class="form-control">
                                    <option value="sawah">Sawah</option>
                                    <option value="kering">Kering</option>
                                </select>
                            </td>
                            <td><input type="text" name="details[0][no_persil]" class="form-control" placeholder="Contoh: 12"></td>

                            <td>
                                <select name="details[0][kelas_desa]" class="form-control">
                                    <option value="S.I">S.I</option>
                                    <option value="S.II">S.II</option>
                                    <option value="S.III">S.III</option>
                                    <option value="S.IV">S.IV</option>
                                    <option value="D.I">D.I</option>
                                    <option value="D.II">D.II</option>
                                    <option value="D.III">D.III</option>
                                    <option value="D.IV">D.IV</option>
                                </select>
                            </td>


                            <td><input type="number" step="0.0001" name="details[0][luas_ha]" class="form-control" placeholder="0.0000"></td>
                            <td><button type="button" class="btn btn-danger btn-sm hapus-baris">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                
                {{-- ID Tombol saya samakan dengan JavaScript (tambah-baris-bidang) --}}
                <button type="button" class="btn btn-info" id="tambah-baris-bidang">Tambah Bidang</button>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let i = 0; 
    
    // Pastikan ID 'tambah-baris-bidang' ada di tombol atas
    document.getElementById('tambah-baris-bidang').addEventListener('click', function() {
        i++;
        let tableBody = document.getElementById('bidang-tanah');
        let newRow = `
            <tr>
                <td>
                    <select name="details[${i}][klasifikasi]" class="form-control">
                        <option value="sawah">Sawah</option>
                        <option value="kering">Kering</option>
                    </select>
                </td>
                <td><input type="text" name="details[${i}][no_persil]" class="form-control" placeholder="Contoh: 12"></td>
                <td>
                <select name="details[${i}][kelas_desa]" class="form-control">
                <option value="S.I">S.I</option>
                <option value="S.II">S.II</option>
                <option value="S.III">S.III</option>
                <option value="S.IV">S.IV</option>
                <option value="D.I">D.I</option>
                <option value="D.II">D.II</option>
                <option value="D.III">D.III</option>
                <option value="D.IV">D.IV</option>
                </select>
                </td>
                <td><input type="number" step="0.0001" name="details[${i}][luas_ha]" class="form-control" placeholder="0.0000"></td>
                <td><button type="button" class="btn btn-danger btn-sm hapus-baris">Hapus</button></td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('hapus-baris')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection