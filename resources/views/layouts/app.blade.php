<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pertanahan Desa</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; }
        .sidebar { min-width: 260px; max-width: 260px; min-height: 100vh; background: #2c3e50; color: white; transition: all 0.3s; position: sticky; top: 0; z-index: 1000; }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            font-size: 1rem;
            border-radius: 8px;
            margin: 2px 15px;
            padding: 10px 15px;
            transition: 0.2s;
        }
        .sidebar .nav-link:hover { background: #34495e; color: white; }
        .sidebar .nav-link.active { background: #3498db; color: white; }
        
        .sidebar .collapse .nav-link {
            font-size: 0.85rem;
            padding-left: 40px;
            margin: 1px 15px;
        }

        .content { width: 100%; padding: 20px; }
        .sidebar .text-secondary { font-size: 0.85rem; letter-spacing: 1px; }
        hr { border-color: rgba(255,255,255,0.1); }
        .bi { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar" id="mainSidebar">
            <div class="p-4 text-center">
                <h6 class="fw-bold text-uppercase mb-0 text-white">SIM-Tanah Desa</h6>
                <small class="text-white-50">Desa Wonosari Kec. Pegandon</small>
                <hr>
            </div>
            
            <ul class="nav flex-column" id="sidebar-nav">
                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <div class="text-secondary px-4 mt-3 mb-1 text-uppercase fw-bold small">Data Utama</div>

                {{-- MASTER DATA --}}
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('lahan-desa*') || request()->is('dhkp*') ? '' : 'collapsed' }}" 
                       data-bs-toggle="collapse" href="#masterData">
                        <span><i class="bi bi-database me-2"></i> Master Data</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->is('lahan-desa*') || request()->is('dhkp*') ? 'show' : '' }}" id="masterData">
                        <ul class="nav flex-column">
                            <li>
                                <a href="{{ route('lahan.index') }}" class="nav-link {{ request()->is('lahan-desa*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Lahan Desa
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dhkp.index') }}" class="nav-link {{ request()->is('dhkp*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Input DHKP
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- BUKU INDUK --}}
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('c-desa*') ? '' : 'collapsed' }}" 
                       data-bs-toggle="collapse" href="#bukuInduk">
                        <span><i class="bi bi-journal-bookmark me-2"></i> Buku Induk</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->is('c-desa*') ? 'show' : '' }}" id="bukuInduk">
                        <ul class="nav flex-column">
                            <li>
                                <a href="{{ route('c-desa.index') }}" class="nav-link {{ request()->routeIs('c-desa.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Input C Desa
                                </a>
                            </li>
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Persil Desa</a></li>
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Peta Blok</a></li>
                        </ul>
                    </div>
                </li>

                <div class="text-secondary px-4 mt-3 mb-1 text-uppercase fw-bold small">Pelayanan</div>

                {{-- LAYANAN --}}
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" href="#layanan">
                        <span><i class="bi bi-envelope-paper me-2"></i> Layanan</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse" id="layanan">
                        <ul class="nav flex-column">
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Mutasi Tanah</a></li>
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Mutasi SPPT</a></li>
                        </ul>
                    </div>
                </li>

                <div class="text-secondary px-4 mt-3 mb-1 text-uppercase fw-bold small">PENGATURAN</div>

                {{-- PENGATURAN --}}
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" href="#Pengaturan">
                        <span><i class="bi bi-gear me-2"></i> Pengaturan</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse" id="Pengaturan">
                        <ul class="nav flex-column">
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Data Kantor Desa</a></li>
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Input Pengguna</a></li>
                        </ul>
                    </div>
                </li>

                {{-- PERAWATAN --}}
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" href="#Perawatan">
                        <span><i class="bi bi-shield me-2"></i> Perawatan</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse" id="Perawatan">
                        <ul class="nav flex-column">
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Backup DB</a></li>
                            <li><a href="#" class="nav-link"><i class="bi bi-circle me-2" style="font-size: 0.7rem;"></i> Import DB</a></li>
                        </ul>
                    </div>
                </li>
            </ul>

            <div class="px-3 mt-4 mb-4">
                <hr>
                <a href="/logout" class="nav-link text-warning"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a>
            </div>
        </div>

        <div class="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1 text-secondary" style="font-size: 1rem;">
                        <i class="bi bi-list me-2"></i> Admin Kantor Desa
                    </span>
                </div>
            </nav>
            
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Logika SweetAlert
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                showClass: { popup: 'animate__animated animate__bounceIn' }
            });
        @endif
    </script>
</body>
</html>