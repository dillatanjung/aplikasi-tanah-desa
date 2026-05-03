@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">Data Himpunan Ketetapan Pajak (DHKP)</h4>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex gap-2">
                    <a href="{{ route('dhkp.create') }}" class="btn btn-dark btn-sm">
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
                                    <a href="{{ route('dhkp.edit', $item->id) }}" class="btn btn-primary me-1 rounded">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('dhkp.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger rounded btn-delete" data-nama="{{ $item->nama_wp }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
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

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Notifikasi Sukses
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#7066e0',
            });
        @endif

        // 2. Logika Tombol Hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('.delete-form');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data DHKP atas nama " + nama + " akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection