@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">Data Himpunan Ketetapan Pajak (DHKP)</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex gap-2">
                   <a href="#" class="btn btn-dark btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </a>
                    <a href="{{ route('dhkp.import-view') }}" class="btn btn-success btn-sm text-white">
                        <i class="bi bi-file-earmark-excel"></i> Import
                    </a>
                </div>
                <div class="col-md-6 mt-2 mt-md-0">
                    <form action="{{ route('dhkp.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-sm bg-light" 
                                   placeholder="masukkan kata kunci dan enter..." value="{{ request('search') }}">
                            <button class="btn btn-white border-start-0 border shadow-none" type="submit">
                                <i class="bi bi-search text-muted"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">NO.</th>
                            <th>NOP</th>
                            <th>BLOK</th>
                            <th>PERSIL</th>
                            <th>NAMA WAJIB PAJAK</th>
                            <th>ALAMAT WP</th>
                            <th>LUAS BUMI</th>
                            <th>LUAS BNG</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dhkps as $index => $item)
                        <tr>
                            <td class="ps-3">{{ $dhkps->firstItem() + $index }}</td>
                            <td><span class="badge bg-secondary opacity-75 fw-normal">{{ $item->nop }}</span></td>
                            <td>{{ $item->no_blok }}</td>
                            <td>{{ $item->no_persil }}</td>
                            <td class="fw-semibold">{{ $item->nama_wp }}</td>
                            <td class="text-muted small">{{ $item->alamat_wp }}</td>
                            <td>{{ number_format($item->luas_bumi) }} m²</td>
                            <td>{{ number_format($item->luas_bng) }} m²</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-primary me-1 rounded"><i class="bi bi-pencil-fill"></i></a>
                                    <button class="btn btn-danger rounded"><i class="bi bi-trash-fill"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-folder2-open display-6 d-block mb-2"></i>
                                Data tidak ditemukan atau masih kosong.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-end">
                {{ $dhkps->links() }}
            </div>
        </div>
    </div>
</div>
@endsection