@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
            <h4 class="mb-0 fw-bold text-primary">Daftar Buku C Desa</h4>
            <a href="{{ route('c-desa.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Tambah Data Baru
            </a>
        </div>
        <div class="card-body">
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="100">No. C Desa</th>
                            <th>Nama Wajib Pajak</th>
                            <th>Jumlah Bidang</th>
                            <th>Scan</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="text-center fw-bold">{{ $item->no_c_desa }}</td>
                            <td>{{ $item->nama_wajib_pajak }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark">
                                    {{ $item->details_count ?? $item->details->count() }} Bidang
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->file_scan)
                                    <a href="{{ asset($item->file_scan) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-file-pdf"></i> Lihat Scan
                                @else
                                    <span class="text-muted small italic">Tidak ada file</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('c-desa.show', $item->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                        Detail
                                    </a>
                                    
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('c-desa.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        Edit
                                    </a>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('c-desa.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau menghapus data {{ $item->nama_wajib_pajak }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data Buku C Desa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection