<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JAHITYUK!!</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #ffffff;
        }
        .brand-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
        }
        .brand-section::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -30px;
            left: -30px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(30, 60, 114, 0.15);
            border-color: #2a5298;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(42, 82, 152, 0.3);
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
        }
        .input-group-text {
            border-right: none;
            background-color: transparent;
        }
        .form-control {
            border-left: none;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card login-card">
                    <div class="row g-0">
                        
                        <!-- Panel Kiri (Branding & Ilustrasi) -->
                        <div class="col-md-5 brand-section text-center d-none d-md-flex">
                            <div class="my-auto position-relative z-1">
                                <div class="bg-white text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 90px; height: 90px;">
                                    <i class="fa-solid fa-scissors fa-3x" style="color: #1e3c72;"></i>
                                </div>
                                <h3 class="fw-bold mb-2">JAHITYUK!!</h3>
                                <p class="text-white-50 mb-0">Solusi Pemesanan Jasa Penjahit Modern & Terpercaya.</p>
                            </div>
                        </div>

                        <!-- Panel Kanan (Form Login) -->
                        <div class="col-md-7 p-4 p-sm-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold text-dark mb-0">Masuk Akun</h4>
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Daftar</a>
                            </div>

                            <!-- Alert Error Pesan Kesalahan -->
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('login.submit') }}" method="POST">
                                @csrf
                                
                                <!-- Email Input -->
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-medium">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="fa-regular fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control form-control-lg fs-6 @error('email') is-invalid @enderror" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                                    </div>
                                </div>

                                <!-- Password Input -->
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-medium">Kata Sandi</label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control form-control-lg fs-6" placeholder="••••••••" required>
                                    </div>
                                </div>

                                <!-- Remember Me -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label small text-muted" for="remember">
                                            Ingat Saya
                                        </label>
                                    </div>
                                </div>

                                <!-- Tombol Login -->
                                <button type="submit" class="btn btn-primary-custom text-white w-100 shadow-sm">
                                    Masuk <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <p class="small text-muted mb-0">Belum punya akun pelanggan? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #1e3c72;">Daftar Sekarang</a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>