<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Sekolah - Dashboard</title>
    <link rel="icon" href="{{ asset('img/logo-alazhar.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            height: 100%;
            background: #212529;
            color: white;
            width: 270px;
            position: fixed;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
            /* TAMBAHKAN DUA BARIS INI */
            overflow-y: auto;

        }

        /* OPSIONAL: Mempercantik Scrollbar agar terlihat modern (untuk Chrome, Safari, Edge) */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #212529;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            margin: 4px 15px;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link.active,
        .aktif {
            background: #0d6efd;
            color: white;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        /* Sub-menu styling */
        .sidebar .nav-tree {
            background: rgba(0, 0, 0, 0.2);
            margin: 0 15px;
            border-radius: 8px;
            padding: 5px 0;
        }

        .sidebar .nav-tree .nav-link {
            margin: 2px 10px;
            font-size: 0.85rem;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            transition: all 0.3s ease-in-out;
        }

        .logout-section {
            margin-top: auto;
            padding-bottom: 20px;
        }

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
            .sidebar {
                margin-left: -270px;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            /* Class saat sidebar dipanggil di mobile */
            .sidebar.show-mobile {
                margin-left: 0;
            }

            .sidebar-overlay.show-mobile {
                opacity: 1;
                visibility: visible;
            }
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .btn-mobile-toggle:hover {
            background: #f8f9fa;
        }

        /* Styling Footer Modern */
        .main-footer {
            background-color: #ffffff;
            border-top: 1px solid #f1f1f1;
            padding: 30px 0;
            margin-top: 50px;
            color: #64748b;
            font-size: 0.9rem;
        }

        .footer-link {
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .footer-link:hover {
            color: #2c3e50;
        }

        .footer-brand {
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }

        .footer-status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #10b981;
            /* Hijau Emerald */
            border-radius: 50%;
            margin-right: 5px;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
        }

        .transition-icon {
            transition: transform 0.3s ease;
        }

        .nav-link[aria-expanded="true"] .transition-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .footer-content {
                text-align: center;
                flex-direction: column;
                gap: 15px;
            }
        }

        /* .brand-logo {
            padding: 10px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        } */
    </style>
</head>

<body>
    @auth
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <div  class="sidebar d-flex flex-column shadow" id="sidebar">
            <div class="p-4 text-center align-items-center d-flex gap-2 position-relative">
                <div class="brand-logo">
                    <img src="{{ asset('img/logo-alazhar.png') }}" style="width:60px; height: 60px;" alt="">

                </div>

                <small class=" text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Sistem
                    Inventaris <br> <span style="font-size:10px" class=" text-uppercase">
                        Sekolah Islam <br> Al-Azhar Pekalongan
                    </span>
                </small>

                <button
                    class="btn btn-link text-white d-lg-none position-absolute top-0 end-0 mt-3 me-1 text-decoration-none"
                    id="closeSidebarBtn">
                    <i class="fa-solid fa-xmark fs-5"></i>
                </button>
            </div>

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>

                @if (Auth::check() && Auth::user()->role->slug === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear me-2"></i> Kelola User
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('role.index') }}" class="nav-link {{ request()->is('role*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-shield me-2"></i>Kelola Role
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center {{ request()->is('master*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" href="#menuMaster" role="button"
                            aria-expanded="{{ request()->is('master*') ? 'true' : 'false' }}">
                            <i class="fa-solid fa-database me-2"></i>
                            <span>Data Master</span>
                            <i class="fa-solid fa-chevron-down ms-auto mt-1 small transition-icon"></i>
                        </a>
                        <div class="collapse {{ request()->is('master*') ? 'show' : '' }}" id="menuMaster">
                            <ul class="nav flex-column nav-tree mt-1">
                                <li>
                                    <a href="{{ route('master.jenjang.index') }}"
                                        class="nav-link {{ request()->is('master/jenjang*') ? 'aktif text-white fw-bold' : '' }}">
                                        <i class="fa-solid fa-layer-group me-2" style="font-size: 0.8rem;"></i> Master
                                        Jenjang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('master.kategori.index') }}"
                                        class="nav-link {{ request()->is('master/kategori*') ? 'aktif text-white fw-bold' : '' }}">
                                        <i class="fa-solid fa-tag me-2" style="font-size: 0.8rem;"></i> Kode Barang
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('master.gedung.index') }}"
                                        class="nav-link {{ request()->is('master/gedung*') ? 'aktif text-white fw-bold' : '' }}">
                                        <i class="fa-solid fa-building me-2" style="font-size: 0.8rem;"></i> Master Gedung
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('master.ruangan.index') }}"
                                        class="nav-link {{ request()->is('master/ruangan*') ? 'aktif text-white fw-bold' : '' }}">
                                        <i class="fa-solid fa-door-open me-2" style="font-size: 0.8rem;"></i> Master Ruangan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('master.sumber-dana.index') }}"
                                        class="nav-link {{ request()->is('master/sumber-dana*') ? 'aktif text-white fw-bold' : '' }}">
                                        <i class="fa-solid fa-wallet me-2" style="font-size: 0.8rem;"></i> Data Pembelian
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif


                <li class="nav-item">
                    <a href="{{ route('barang.index') }}" class="nav-link {{ request()->is('barang*') ? 'active' : '' }}">
                        <i class="fa-solid fa-boxes-stacked me-2"></i> Kelola Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengajuan.index') }}"
                        class="nav-link {{ request()->is('pengajuan*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i> Pengajuan Barang
                    </a>
                </li>

                {{-- <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list me-2"></i> Rekap Laporan
            </a>
        </li> --}}
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
    @endauth
    <div class="main-content">
        @auth

            <div class="d-lg-none d-flex align-items-center mb-4">
                <button class="btn-mobile-toggle me-3" id="openSidebarBtn">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark">Menu Navigasi</h5>
            </div>
        @endauth

        <div class="container-fluid p-0">
            @yield('content')
            <footer class="main-footer ">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-center align-items-center footer-content">
                        <div>
                            <span class="footer-brand">SISTEM INVENTARIS DIGITAL</span>
                            <span class="mx-2 text-muted opacity-25">|</span>
                            <span>&copy; {{ date('Y') }} Sekolah Islam Al-Azhar.</span>
                        </div>

                        {{-- <div class="d-none d-md-block">
                <span class="footer-status-indicator"></span>
                <small class="text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">System Operational</small>
            </div>

            <div class="d-flex align-items-center gap-4">
                <a href="#" class="footer-link">Bantuan</a>
                <a href="#" class="footer-link">Panduan</a>
                <div class="bg-light px-3 py-1 rounded-pill border shadow-sm">
                    <small class="fw-bold text-dark">v2.1.0-stable</small>
                </div>
            </div> --}}
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
  AOS.init();
</script>
    @yield('scripts')
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
            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

            // Menutup sidebar jika area gelap (overlay) di klik
            if (overlay) overlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>

</html>
