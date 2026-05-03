@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Edit Data C Desa: {{ $cDesa->no_c_desa }}</h5>
            <a href="{{ route('c-desa.index') }}" class="btn btn-sm btn-light">Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('c-desa.update', $cDesa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No. C Desa</label>
                        <input type="text" name="no_c_desa" class="form-control" value="{{ $cDesa->no_c_desa }}" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nama Wajib Pajak</label>
                        <input type="text" name="nama_wajib_pajak" class="form-control" value="{{ $cDesa->nama_wajib_pajak }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Update File Scan (Opsional)</label>
                    <input type="file" name="file_scan" class="form-control">
                    @if($cDesa->file_scan)
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $cDesa->file_scan) }}" target="_blank">Lihat Scan Lama</a></small>
                    @endif
                </div>

                <h5 class="border-bottom pb-2">Rincian Bidang Tanah</h5>
                <table class="table table-sm table-bordered" id="tableDetails">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Klasifikasi</th>
                            <th>No. Persil</th>
                            <th>Kelas</th>
                            <th>Luas (ha)</th>
                            <th>Sebab Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cDesa->details as $index => $detail)
                        <tr>
                            <td><input type="text" name="details[{{$index}}][klasifikasi]" class="form-control form-control-sm" value="{{ $detail->klasifikasi }}" required></td>
                            <td><input type="text" name="details[{{$index}}][no_persil]" class="form-control form-control-sm" value="{{ $detail->no_persil }}" required></td>
                            <td><input type="text" name="details[{{$index}}][kelas_desa]" class="form-control form-control-sm" value="{{ $detail->kelas_desa }}" required></td>
                            <td><input type="number" step="0.001" name="details[{{$index}}][luas_ha]" class="form-control form-control-sm" value="{{ $detail->luas_ha }}" required></td>
                            <td><input type="text" name="details[{{$index}}][sebab_perubahan]" class="form-control form-control-sm" value="{{ $detail->sebab_perubahan }}"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection