@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Buku C Desa: {{ $cDesa->no_c_desa }}</h3>
        <div>
            <a href="{{ route('c-desa.index') }}" class="btn btn-secondary">Kembali</a>
            <button onclick="window.print()" class="btn btn-dark">Cetak Data</button>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Informasi Data -->
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pemilik</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="30%">Nomor C Desa</th>
                            <td>: {{ $cDesa->no_c_desa }}</td>
                        </tr>
                        <tr>
                            <th>Nama Wajib Pajak</th>
                            <td>: {{ $cDesa->nama_wajib_pajak }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Rincian Bidang Tanah</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Klasifikasi</th>
                                <th>No Persil</th>
                                <th>Kelas</th>
                                <th>Luas (ha)</th>
                                <th>Sebab Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cDesa->details as $detail)
                            <tr>
                                <td>{{ ucfirst($detail->klasifikasi) }}</td>
                                <td>{{ $detail->no_persil }}</td>
                                <td>{{ $detail->kelas_desa }}</td>
                                <td>{{ number_format($detail->luas_ha, 4) }} ha</td>
                                <td>{{ $detail->sebab_perubahan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Preview Scan -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Hasil Scan Buku C</h5>
                </div>
                <div class="card-body text-center">
                    @if($cDesa->file_scan)
                        <img src="{{ asset($cDesa->file_scan) }}" class="img-fluid rounded border" alt="Scan Buku C">
                        <div class="mt-3">
                            <a href="{{ asset($cDesa->file_scan) }}" target="_blank" class="btn btn-outline-primary btn-sm">Buka Gambar Penuh</a>
                        </div>
                    @else
                        <div class="py-5 text-muted">
                            <i class="fas fa-file-image fa-4x mb-3"></i>
                            <p>Belum ada file scan yang diupload.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .card-header, .col-md-5 { display: none !important; }
        .col-md-7 { width: 100% !important; }
        .card { border: none !important; }
    }
</style>
@endsection