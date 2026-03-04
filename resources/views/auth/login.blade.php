<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | INV-SCHOOL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fdfdfd;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            height: 100vh;
        }

        /* Sisi Kiri: Ilustrasi & Brand */
        .login-sidebar {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 60px;
            position: relative;
        }

        .login-sidebar::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.1;
        }

        /* Sisi Kanan: Form Login */
        .login-form-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            background: white;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .form-control-custom {
            border: 1.5px solid #eaecf0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
            outline: none;
        }

        .btn-login {
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #2e59d9;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 115, 223, 0.25);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #98a2b3;
            cursor: pointer;
        }

        /* Responsif Mobile */
        @media (max-width: 991.98px) {
            .login-sidebar { display: none; }
            .login-form-section { padding: 40px 20px; }
            body { overflow: auto; }
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0 login-container">
        <div class="col-lg-6 login-sidebar">
            <div class="brand-logo shadow-sm">
                <i class="fa-solid fa-boxes-stacked fa-2x"></i>
            </div>
            <h1 class="fw-bold mb-3">INV-SCHOOL</h1>
            <p class="text-center opacity-75 fs-5">"Kelola aset sekolah lebih rapi, terstruktur, dan transparan dalam satu platform modern."</p>
            <div class="mt-4 p-3 bg-white bg-opacity-10 rounded-4 border border-white border-opacity-25 small">
                <i class="fa-solid fa-shield-halved me-2"></i> Sistem Keamanan Terenkripsi
            </div>
        </div>

        <div class="col-lg-6 login-form-section">
            <div class="mx-auto" style="max-width: 400px; width: 100%;">
                <div class="mb-5">
                    <h2 class="fw-bold text-dark mb-2">Selamat Datang 👋</h2>
                    <p class="text-muted">Silakan masukkan akun Anda untuk mulai mengelola inventaris.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 small mb-4">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">USERNAME</label>
                        <input type="text" name="username" class="form-control-custom w-100" placeholder="Masukkan username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                        <div class="input-icon">
                            <input type="password" name="password" id="password" class="form-control-custom w-100" placeholder="••••••••" required>
                            <i class="fa-solid fa-eye" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small text-muted" for="remember">Ingat saya di perangkat ini</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-1">
                        Masuk ke Dashboard <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center text-muted small mt-1">
                    Butuh bantuan akses? <a href="#" class="text-primary fw-bold text-decoration-none">Hubungi IT Support</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>