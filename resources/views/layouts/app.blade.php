<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Sekolah - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar { 
            min-height: 100vh; 
            background: #212529; 
            color: white; 
            width: 260px; 
            position: fixed; 
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar .nav-link { 
            color: rgba(255,255,255,0.7); 
            margin: 4px 15px; 
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover { 
            background: rgba(255,255,255,0.1); 
            color: white; 
        }
        .sidebar .nav-link.active { 
            background: #0d6efd; 
            color: white; 
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }
        
        /* Sub-menu styling */
        .sidebar .nav-tree { background: rgba(0,0,0,0.2); margin: 0 15px; border-radius: 8px; padding: 5px 0; }
        .sidebar .nav-tree .nav-link { margin: 2px 10px; font-size: 0.85rem; }

        .main-content { margin-left: 260px; padding: 30px; min-height: 100vh; }
        
        .logout-section { margin-top: auto; padding-bottom: 20px; }
        
        @media (max-width: 992px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column shadow">
    <div class="p-4 text-center">
        <h4 class="fw-bold tracking-tight text-white mb-0">INV-SCHOOL</h4>
        <small class="text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Sistem Inventaris</small>
    </div>
    
<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
        </a>
    </li>

    @if(Auth::check() && Auth::user()->role === 'admin')
    <li class="nav-item">
        <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('master/user*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-gear me-2"></i> Kelola User
        </a>
    </li>
    @endif
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ request()->is('master*') && !request()->is('master/user*') ? 'active' : '' }}" 
           data-bs-toggle="collapse" href="#menuMaster" role="button" 
           aria-expanded="{{ request()->is('master*') && !request()->is('master/user*') ? 'true' : 'false' }}">
            <i class="fa-solid fa-database me-2"></i> 
            <span>Data Master</span>
            <i class="fa-solid fa-chevron-down ms-auto mt-1 small transition-icon"></i>
        </a>
        <div class="collapse {{ request()->is('master*') && !request()->is('master/user*') ? 'show' : '' }}" id="menuMaster">
            <ul class="nav flex-column nav-tree mt-1">
                <li>
                    <a href="{{ route('master.jenjang.index') }}" class="nav-link {{ request()->is('master/jenjang*') ? 'text-white fw-bold' : '' }}">
                        <i class="fa-solid fa-layer-group me-2" style="font-size: 0.8rem;"></i> Master Jenjang
                    </a>
                </li>

                <li>
                        <a href="{{ route('master.kategori.index') }}" class="nav-link {{ request()->is('master/kategori*') ? 'text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-tag me-2" style="font-size: 0.8rem;"></i> Kode Barang
                        </a>
                </li>

                <li>

                        <a href="{{ route('master.gedung.index') }}"class="nav-link {{ request()->is('master/gedung*') ? 'text-white fw-bold' : '' }}">

                            <i class="fa-solid fa-building me-2" style="font-size: 0.8rem;"></i> Master Gedung

                        </a>

                    </li>

                    <li>
                        <a href="{{ route('master.sumber-dana.index') }}" class="nav-link {{ request()->is('master/sumber-dana*') ? 'text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-wallet me-2" style="font-size: 0.8rem;"></i> Data Pembelian
                        </a>
                    </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
            <a href="" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-stacked me-2"></i> Kelola Barang
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list me-2"></i> Rekap Laporan
            </a>
        </li>
    </ul>

<div class="logout-section mt-auto border-top border-secondary">
    <a href="{{ route('logout') }}" class="nav-link text-danger mt-3" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
    </a>
    {{-- Perbaikan action form logout --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
</div>

<div class="main-content">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>