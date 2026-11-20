<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Kos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3d4afe;
            --primary-hover: #2f3be0;
            --bg: #0f172a;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            margin: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 440px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header {
            background: linear-gradient(135deg, #1e1b4b, #2e1065);
            padding: 36px 32px 28px;
            text-align: center;
            color: #ffffff;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #3d4afe, #818cf8);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 14px;
            box-shadow: 0 10px 20px rgba(61, 74, 254, 0.3);
        }

        .login-header h4 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 4px;
        }

        .login-header p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .login-body {
            padding: 32px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.825rem;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61, 74, 254, 0.15);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 10px;
            padding: 11px;
            font-weight: 600;
            font-size: 0.925rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .role-demo-pill {
            cursor: pointer;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 0.775rem;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            transition: all 0.15s ease;
            text-align: left;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .role-demo-pill:hover {
            border-color: var(--primary);
            background: #eff2fe;
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">🏠</div>
        <h4>Inventaris Kos</h4>
        <p>Silakan masuk untuk mengakses fitur sistem</p>
    </div>

    <div class="login-body">

        {{-- Flash Success / Message --}}
        @if(session('flash_success'))
            <div class="alert alert-success alert-dismissible fade show text-sm py-2 px-3 mb-3" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('flash_success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email"
                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                           id="email"
                           name="email"
                           value="{{ old('email', 'admin@kos.com') }}"
                           required
                           autofocus
                           style="border-radius: 0 10px 10px 0;">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password"
                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           value="password"
                           required
                           style="border-radius: 0 10px 10px 0;">
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                    <label class="form-check-label text-muted small" for="remember">
                        Ingat Saya
                    </label>
                </div>
                <span class="text-muted small">Default pass: <code>password</code></span>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
            </button>

            <div class="text-center mb-4">
                <span class="text-muted small">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-primary small fw-semibold text-decoration-none ms-1">
                    Daftar di sini <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </form>

        {{-- Bantuan Cepat Pengujian Hak Akses --}}
        <div class="border-top pt-3">
            <p class="text-muted small fw-semibold mb-2">
                <i class="bi bi-shield-check text-primary me-1"></i> Klik untuk Isi Cepat Akun Uji:
            </p>
            <div class="d-flex flex-column gap-2">
                <button type="button" class="role-demo-pill" onclick="fillLogin('admin@kos.com', 'password')">
                    <span>👑 <strong>Admin Kos</strong> (Full CRUD)</span>
                    <code class="text-primary">admin@kos.com</code>
                </button>
                <button type="button" class="role-demo-pill" onclick="fillLogin('staff@kos.com', 'password')">
                    <span>🔧 <strong>Staff</strong> (Create, Edit)</span>
                    <code class="text-primary">staff@kos.com</code>
                </button>
                <button type="button" class="role-demo-pill" onclick="fillLogin('penyewa@kos.com', 'password')">
                    <span>👤 <strong>Penyewa</strong> (Read-only)</span>
                    <code class="text-primary">penyewa@kos.com</code>
                </button>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
</body>
</html>
