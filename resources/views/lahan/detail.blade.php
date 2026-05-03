@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <h2 class="h4 fw-bold text-dark">Detail Mutasi Lahan: {{ $pemilik->no_c_desa }}</h2>
        <div>
            <a href="{{ route('lahan.index') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button class="btn btn-dark shadow-sm" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak Data
            </button>
        </div>
    </div>

    <div class="row">
        {{-- Sisi Kiri: Informasi Data --}}
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="bi bi-person-badge"></i> Informasi Pemilik
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td width="40%" class="text-muted">Nomor C Desa</td>
                            <td>: <strong>{{ $pemilik->no_c_desa }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Nama Pemilik</td>
                            <td>: <strong>{{ $pemilik->nama_pemilik_baru }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>: {{ $pemilik->alamat_pemilik ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info text-white fw-bold">
                    <i class="bi bi-map"></i> Rincian Bidang Tanah
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">NOP</th>
                                <th>Luas Mutasi</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-3 fw-bold text-primary">{{ $pemilik->dhkp->nop ?? '-' }}</td>
                                <td>{{ number_format($pemilik->luas_milik, 0, ',', '.') }} m²</td>
                                <td class="text-center">
                                    <span class="badge {{ $pemilik->status == 'SINKRON' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $pemilik->status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Hasil Scan Bukti --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="bi bi-file-earmark-image"></i> Hasil Scan Bukti Peralihan
                </div>
                <div class="card-body text-center bg-light" style="min-height: 400px;">
                    @if($pemilik->bukti_peralihan)
                        @php
                            $extension = pathinfo($pemilik->bukti_peralihan, PATHINFO_EXTENSION);
                            // Sesuaikan path ke public/upload/bukti_mutasi
                            $filePath = asset('upload/bukti_mutasi/' . $pemilik->bukti_peralihan);
                        @endphp

                        @if(strtolower($extension) == 'pdf')
                            <div class="ratio ratio-4x3 mb-3">
                                <embed src="{{ $filePath }}" type="application/pdf" class="rounded shadow-sm">
                            </div>
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bi bi-fullscreen"></i> Lihat PDF Full Screen
                            </a>
                        @else
                            <div class="p-2 bg-white border rounded shadow-sm d-inline-block">
                                <img src="{{ $filePath }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 600px;"
                                     alt="Bukti Peralihan"
                                     onerror="this.onerror=null;this.src='{{ asset('img/no-image.png') }}';">
                            </div>
                            <div class="mt-3">
                                <a href="{{ $filePath }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-zoom-in"></i> Perbesar Gambar
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="py-5">
                            <i class="bi bi-image text-muted display-1"></i>
                            <p class="text-muted mt-3">Belum ada dokumen bukti peralihan yang diunggah untuk data ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .d-print-none { display: none !important; }
        .card { border: 1px solid #ddd !important; shadow: none !important; }
        .card-header { background-color: #f8f9fa !important; color: black !important; }
    }
</style>
@endsection