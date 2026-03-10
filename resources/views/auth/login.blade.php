<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | INV-SCHOOL</title>
    <link rel="icon" href="{{ asset('img/logo-alazhar.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3a30f4; /* Indigo / Futuristic Blue */
            --primary-hover: #685ddf;
            --bg-light: #f3f4f6;
            --text-main: #111827;
            --text-muted: #6b7280;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* --- SISI KIRI: BRANDING --- */
        .brand-section {
            background: linear-gradient(135deg, #2823bebb 0%, var(--primary-color) 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            overflow: hidden;
        }

        /* Ornamen Futuristik (Grid & Glow) */
        .brand-section::before {
            content: "";
            position: absolute;
            width: 150%;
            height: 150%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            transform: rotate(-15deg);
            z-index: 1;
        }

        .brand-section::after {
            content: "";
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(60px);
            border-radius: 50%;
            z-index: 1;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 420px; /* Sedikit dilebarkan agar teks lebih leluasa */
        }

        .brand-logo {
            width:  120px; /* Sedikit disesuaikan agar proporsional saat ada 2 logo */
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px; /* Memberikan ruang napas di dalam kotak */
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Mencegah gambar gepeng/terdistorsi */
        }

        .glass-badge {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            margin-top: 30px;
        }

        /* --- SISI KANAN: FORM --- */
        .form-section {
            background-color: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-card {
            background: white;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 450px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        /* Style Input Modern */
        .input-group-custom {
            margin-bottom: 1.5rem;
        }

        .input-group-custom label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
            letter-spacing: 0.5px;
        }

        .form-control-custom {
            width: 100%;
            background: #f9fafb;
            border: 2px solid transparent;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 1rem;
            color: var(--text-main);
            transition: all 0.3s ease;
        }

        .form-control-custom::placeholder {
            color: #9ca3af;
        }

        .form-control-custom:focus {
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
            outline: none;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.3s ease;
            padding: 5px;
        }

        .input-icon-wrapper .toggle-password:hover {
            color: var(--primary-color);
        }

        /* Tombol Login */
        .btn-login {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
            color: white;
        }

        /* --- RESPONSIVITAS MOBILE --- */
        @media (max-width: 991.98px) {
            .login-wrapper {
                flex-direction: column;
            }

            .brand-section {
                padding: 60px 20px 80px 20px; 
                border-bottom-left-radius: 40px;
                border-bottom-right-radius: 40px;
                min-height: auto;
            }

            .brand-logo {
                width: 90px; 
                height: 90px;
                padding: 10px;
            }

            .brand-content h3 {
                font-size: 1.5rem;
            }

            .brand-content p {
                font-size: 0.95rem !important;
            }

            .form-section {
                padding: 0 20px 40px 20px;
                background: transparent;
                margin-top: -60px; 
                position: relative;
                z-index: 10;
            }

            .form-card {
                padding: 30px 20px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="col-lg-5 brand-section">
        <div class="brand-content">
            <div class="d-flex justify-content-center gap-4 mb-4">
                <div class="brand-logo">
                    <img src="{{ asset('img/logo-alazhar.png') }}" alt="Logo Al-Azhar">
                </div>
                <div class="brand-logo">
                    <img src="{{ asset('img/sigma.png') }}" alt="Logo Sigma">
                </div>
            </div>
            
            <h3 class="fw-bold mb-2">SISTEM INVENTARIS DIGITAL</h3>
            <div class="fs-5 fw-semibold text-light mb-3">
                Sekolah Islam Al-Azhar Pekalongan
            </div>
            <p class="text-center text-white-50 fs-6 mb-0 lh-base">
                Kelola aset sekolah lebih rapi, terstruktur, dan transparan dalam satu platform modern.
            </p>
            
            <div class="glass-badge">
                <i class="fa-solid fa-shield-halved me-2"></i> Sistem Keamanan Terenkripsi
            </div>
        </div>
    </div>

    <div class="col-lg-7 form-section">
        <div class="form-card">
            <div class="mb-4">
                <h2 class="fw-bold text-dark mb-2">Selamat Datang 👋</h2>
                <p class="text-muted">Silakan masuk ke akun Anda untuk mengelola inventaris.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-3 small mb-4 bg-danger text-white bg-opacity-75">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="input-group-custom">
                    <label for="username">USERNAME</label>
                    <input type="text" name="username" id="username" class="form-control-custom" placeholder="Masukkan username Anda" required autofocus>
                </div>

                <div class="input-group-custom">
                    <div class="d-flex justify-content-between">
                        <label for="password">PASSWORD</label>
                        </div>
                    <div class="input-icon-wrapper">
                        <input type="password" name="password" id="password" class="form-control-custom" placeholder="••••••••" required>
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" style="cursor: pointer;">
                        <label class="form-check-label small text-muted" for="remember" style="cursor: pointer; padding-top: 2px;">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-login w-100">
                    Masuk ke Dashboard <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Script Toggle Password
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Animasi icon ganti
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>