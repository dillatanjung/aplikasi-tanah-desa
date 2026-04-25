@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    ```

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Data Penduduk Desa</h5>
        <div>
            <a href="{{ route('penduduk.download-format') }}" class="btn btn-outline-primary btn-sm px-3 me-2">
                <i class="bi bi-download me-1"></i> Download Format
            </a>

            <button class="btn btn-success btn-sm px-3" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Pekerjaan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data dari database --}}
                    @forelse($penduduks as $p)
                    <tr>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->pekerjaan }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-database-exclamation display-4 d-block mb-2"></i>
                            Belum ada data penduduk. Silakan download format dan klik <b>Import Excel</b>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('penduduk.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small">
    <i class="bi bi-info-circle me-1"></i> Gunakan file <b>.xlsx</b> hasil download format agar data terbaca dengan sempurna.
</div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Mulai Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection