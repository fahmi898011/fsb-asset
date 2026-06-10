<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIASTERA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .brand-section {
            background-color: #2563eb; /* Primary Blue */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .form-section {
            background-color: white;
            padding: 3rem;
        }
        .form-floating > .form-control:focus, 
        .form-floating > .form-control:not(:placeholder-shown) {
            padding-top: 1.625rem;
            padding-bottom: .625rem;
        }
        .btn-primary {
            background-color: #2563eb;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card login-card row flex-row mx-0">
                
                <div class="col-md-5 brand-section p-5 d-none d-md-flex text-center">
                    <div class="mb-4">
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <i class="fas fa-cubes fa-3x"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-2">SIASTERA</h3>
                    <p class="small opacity-75 mb-0">Sistem Informasi Aset & Inventaris Terpadu</p>
                    <hr class="border-white opacity-25 w-50 my-4 mx-auto">
                    <p class="small mb-0">Aplikasi Manajemen Aset dan Inventaris<br> PT. Fan Sukses Bersama</p>
                </div>

                <div class="col-md-7 form-section">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark">Selamat Datang Kembali</h4>
                        <p class="text-muted small">Silakan masukkan akun Anda untuk melanjutkan.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
                            <label for="username" class="text-muted"><i class="fas fa-user me-2"></i> Username</label>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                            <label for="password" class="text-muted"><i class="fas fa-lock me-2"></i> Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small text-muted" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Masuk Aplikasi <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">&copy; {{ date('Y') }} Tim IT FSB</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>