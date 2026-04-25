<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pertanahan Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; }
        .sidebar { min-width: 260px; max-width: 260px; min-height: 100vh; background: #2c3e50; color: white; transition: all 0.3s; position: sticky; top: 0; }
        
        /* Styling Link Sidebar */
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            font-size: 0.95rem;
            border-radius: 8px;
            margin: 2px 15px;
            padding: 10px 15px;
            transition: 0.2s;
        }
        .sidebar .nav-link:hover { background: #34495e; color: white; }
        .sidebar .nav-link.active { background: #3498db; color: white; }
        
        /* Sub-menu styling */
        .sidebar .collapse .nav-link {
            font-size: 0.85rem;
            padding-left: 40px;
            margin: 1px 15px;
        }

        .content { width: 100%; padding: 20px; }
        .sidebar .text-secondary { font-size: 0.7rem; letter-spacing: 1px; }
        hr { border-color: rgba(255,255,255,0.1); }
        .bi { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar" id="mainSidebar">
            <div class="p-4 text-center">
                <div class="mb-3">
                    <img src="{{ asset('images/logo/logo-kendal.png') }}" 
                         alt="Logo Kendal" 
                         class="img-fluid" 
                         style="max-height: 80px; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.3));">
                </div>
                <h6 class="fw-bold text-uppercase mb-0 text-white">SIM-Tanah Desa</h6>
                <small class="text-white-50">Kabupaten Kendal</small>
                <hr>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <div class="text-secondary px-4 mt-3 mb-1 text-uppercase fw-bold">Data Utama</div>

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" 
                       data-bs-toggle="collapse" href="#masterData">
                        <span><i class="bi bi-database me-2"></i> Master Data</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->is('pemilik-*') || request()->is('dhkp*') ? 'show' : '' }}" id="masterData">
                        <ul class="nav flex-column">
                            <li><a href="/pemilik-tanah" class="nav-link"><i class="bi bi-person me-2"></i> Pemilik Tanah</a></li>
                            <li><a href="/dhkp" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i> Input DHKP</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" 
                       data-bs-toggle="collapse" href="#bukuInduk">
                        <span><i class="bi bi-journal-bookmark me-2"></i> Buku Induk</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse" id="bukuInduk">
                        <ul class="nav flex-column">
                            <li><a href="/no-c-desa" class="nav-link text-white-50 small">No. C Desa</a></li>
                            <li><a href="/persil-desa" class="nav-link text-white-50 small">Persil Desa</a></li>
                            <li><a href="/peta-blok" class="nav-link text-white-50 small">Peta Blok</a></li>
                        </ul>
                    </div>
                </li>

                <div class="text-secondary px-4 mt-3 mb-1 text-uppercase fw-bold">Pelayanan</div>

                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" 
                       data-bs-toggle="collapse" href="#layanan">
                        <span><i class="bi bi-envelope-paper me-2"></i> Layanan</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse" id="layanan">
                        <ul class="nav flex-column">
                            <li><a href="/mutasi-tanah" class="nav-link text-white-50 small">Mutasi Tanah</a></li>
                            <li><a href="/mutasi-sppt" class="nav-link text-white-50 small">Mutasi SPPT</a></li>
                        </ul>
                    </div>
                </li>
            </ul>

            <div class="px-3 mt-5">
                <hr>
                <a href="/logout" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a>
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
        // Script otomatis tutup menu saat mouse keluar sidebar
        const sidebar = document.getElementById('mainSidebar');
        sidebar.addEventListener('mouseleave', function () {
            const openMenus = sidebar.querySelectorAll('.collapse.show');
            openMenus.forEach(menu => {
                const collapseInstance = bootstrap.Collapse.getOrCreateInstance(menu);
                collapseInstance.hide();
            });
        });
    </script>
</body>
</html>