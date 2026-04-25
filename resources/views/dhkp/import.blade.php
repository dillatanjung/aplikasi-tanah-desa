@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('dhkp.index') }}" class="btn btn-dark">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('dhkp.download-template') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-spreadsheet"></i> Contoh Format
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-person-up"></i> Import DHKP</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dhkp.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold">File Excel</label>
                    <input type="file" name="file" class="form-control" required>
                    <div class="form-text">Pastikan file bertipe .xlsx atau .csv</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark px-4">Upload</button>
                    <button type="reset" class="btn btn-warning text-white px-4">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection