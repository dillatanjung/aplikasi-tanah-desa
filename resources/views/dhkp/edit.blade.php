@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold text-dark">Edit Data DHKP</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dhkp.index') }}">DHKP</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('dhkp.update', $dhkp->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">NOP</label>
                        <input type="text" name="nop" class="form-control bg-light" value="{{ $dhkp->nop }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama Wajib Pajak</label>
                        <input type="text" name="nama_wp" class="form-control" value="{{ $dhkp->nama_wp }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">No. Blok</label>
                        <input type="text" name="no_blok" class="form-control" value="{{ $dhkp->no_blok }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">No. Persil</label>
                        <input type="text" name="no_persil" class="form-control" value="{{ $dhkp->no_persil }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Luas Bumi (m²)</label>
                        <input type="number" name="luas_bumi" class="form-control" value="{{ $dhkp->luas_bumi }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Wajib Pajak</label>
                    <textarea name="alamat_wp" class="form-control" rows="3">{{ $dhkp->alamat_wp }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dhkp.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection