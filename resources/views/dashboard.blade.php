@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">Ringkasan Data Pertanahan</h4>
        <span class="badge bg-primary px-3 py-2">{{ date('d F Y') }}</span>
    </div>

    <div class="row g-3">
        <!-- Widget DHKP -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #3498db;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-bold">PROGRES DHKP</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalDhkp) }}</h3>
                        </div>
                        <div class="icon-box text-primary">
                            <i class="bi bi-file-earmark-check fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Peralihan Nama -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #e67e22;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-bold">PERALIHAN NAMA</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalPermohonan) }}</h3>
                        </div>
                        <div class="icon-box text-warning">
                            <i class="bi bi-arrow-left-right fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Total C Desa (Data Baru) -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #2ecc71;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-bold">TOTAL NO. C</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalC) }}</h3>
                        </div>
                        <div class="icon-box text-success">
                            <i class="bi bi-book fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Total Persil (Data Baru) -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-left: 5px solid #9b59b6;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-bold">TOTAL PERSIL</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalPersilDetail) }}</h3>
                        </div>
                        <div class="icon-box text-purple" style="color: #9b59b6;">
                            <i class="bi bi-map fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection