<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Sistem Inventaris Kos</title>

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
            padding: 32px 20px;
            margin: 0;
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .register-header {
            background: linear-gradient(135deg, #1e1b4b, #2e1065);
            padding: 32px 32px 24px;
            text-align: center;
            color: #ffffff;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #3d4afe, #818cf8);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 12px;
            box-shadow: 0 10px 20px rgba(61, 74, 254, 0.3);
        }

        .register-header h4 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 4px;
        }

        .register-header p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .register-body {
            padding: 28px 32px 32px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.825rem;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
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
    </style>
</head>
<body>

<div class="register-card">
    <div class="register-header">
        <div class="brand-icon">📝</div>
        <h4>Daftar Akun Baru</h4>
        <p>Bergabung dengan Sistem Manajemen Inventaris Kos</p>
    </div>

    <div class="register-body">

        {{-- Form Register --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Contoh: Budi Santoso"
                           required
                           autofocus
                           style="border-radius: 0 10px 10px 0;">
                </div>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
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
                           value="{{ old('email') }}"
                           placeholder="nama@email.com"
                           required
                           style="border-radius: 0 10px 10px 0;">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Peran / Role --}}
            <div class="mb-3">
                <label for="role" class="form-label">Daftar Sebagai (Peran)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    <select class="form-select border-start-0 @error('role') is-invalid @enderror"
                            id="role"
                            name="role"
                            style="border-radius: 0 10px 10px 0;">
                        <option value="penyewa" {{ old('role') === 'penyewa' ? 'selected' : '' }}>👤 Penyewa (Hanya Lihat Aset)</option>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>🔧 Staff Inventaris (Kelola & Edit Aset)</option>
                    </select>
                </div>
                <div class="form-text text-muted" style="font-size: 0.775rem;">
                    *Akun Admin utama dikelola oleh pemilik kos.
                </div>
                @error('role')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
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
                           placeholder="Minimal 6 karakter"
                           required
                           style="border-radius: 0 10px 10px 0;">
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0" style="border-radius: 10px 0 0 10px;">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password"
                           class="form-control border-start-0"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Ketik ulang password"
                           required
                           style="border-radius: 0 10px 10px 0;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3 shadow-sm">
                <i class="bi bi-person-plus me-1"></i> Buat Akun Baru
            </button>

            <div class="text-center pt-2 border-top">
                <span class="text-muted small">Sudah memiliki akun?</span>
                <a href="{{ route('login') }}" class="text-primary small fw-semibold text-decoration-none ms-1">
                    Masuk di sini <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
