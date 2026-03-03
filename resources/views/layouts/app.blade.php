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
            transition: all 0.3s ease-in-out;
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
        .sidebar .nav-link.active, .aktif { 
            background: #0d6efd; 
            color: white; 
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }
        
        /* Sub-menu styling */
        .sidebar .nav-tree { background: rgba(0,0,0,0.2); margin: 0 15px; border-radius: 8px; padding: 5px 0; }
        .sidebar .nav-tree .nav-link { margin: 2px 10px; font-size: 0.85rem; }

        .main-content { 
            margin-left: 260px; 
            padding: 30px; 
            min-height: 100vh; 
            transition: all 0.3s ease-in-out;
        }
        
        .logout-section { margin-top: auto; padding-bottom: 20px; }

        /* Mobile Overlay styling */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        /* Responsive Mobile Styles */
        @media (max-width: 992px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; padding: 20px; }
            
            /* Class saat sidebar dipanggil di mobile */
            .sidebar.show-mobile { margin-left: 0; }
            .sidebar-overlay.show-mobile { opacity: 1; visibility: visible; }
        }

        /* Topbar Mobile Button */
        .btn-mobile-toggle {
            background: white;
            border: 1px solid #dee2e6;
            color: #212529;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        .btn-mobile-toggle:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar d-flex flex-column shadow" id="sidebar">
    <div class="p-4 text-center position-relative">
        <h4 class="fw-bold tracking-tight text-white mb-0">INV-SCHOOL</h4>
        <small class="text-muted text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Sistem Inventaris</small>
        
        <button class="btn btn-link text-white d-lg-none position-absolute top-0 end-0 mt-3 me-2 text-decoration-none" id="closeSidebarBtn">
            <i class="fa-solid fa-xmark fs-5"></i>
        </button>
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
            </a>
        </li>

        @if(Auth::check() && Auth::user()->role === 'admin')
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
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
                        <a href="{{ route('master.jenjang.index') }}" class="nav-link {{ request()->is('master/jenjang') ? 'aktif text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-layer-group me-2" style="font-size: 0.8rem;"></i> Master Jenjang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('master.kategori.index') }}" class="nav-link {{ request()->is('master/kategori*') ? 'aktif text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-tag me-2" style="font-size: 0.8rem;"></i> Kode Barang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('master.gedung.index') }}" class="nav-link {{ request()->is('master/gedung*') ? 'aktif text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-building me-2" style="font-size: 0.8rem;"></i> Master Gedung
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('master.sumber-dana.index') }}" class="nav-link {{ request()->is('master/sumber-dana*') ? 'aktif text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-wallet me-2" style="font-size: 0.8rem;"></i> Data Pembelian
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="{{ route('barang.index') }}" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
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
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

<div class="main-content">
    <div class="d-lg-none d-flex align-items-center mb-4">
        <button class="btn-mobile-toggle me-3" id="openSidebarBtn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h5 class="mb-0 fw-bold text-dark">Menu Navigasi</h5>
    </div>

    <div class="container-fluid p-0">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Logic untuk mengatur buka-tutup sidebar di layar mobile
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        // Fungsi untuk membuka sidebar
        function openSidebar() {
            sidebar.classList.add('show-mobile');
            overlay.classList.add('show-mobile');
            document.body.style.overflow = 'hidden'; // Mencegah scroll pada body
        }

        // Fungsi untuk menutup sidebar
        function closeSidebar() {
            sidebar.classList.remove('show-mobile');
            overlay.classList.remove('show-mobile');
            document.body.style.overflow = 'auto'; // Mengembalikan scroll
        }

        // Event Listeners
        if(openBtn) openBtn.addEventListener('click', openSidebar);
        if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
        
        // Menutup sidebar jika area gelap (overlay) di klik
        if(overlay) overlay.addEventListener('click', closeSidebar);
    });
</script>
</body>
</html>