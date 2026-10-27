<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Inventaris Aset Kos - Kelola dan pantau seluruh aset properti kos Anda dengan mudah.">
    <title>@yield('title', 'Dashboard') - Inventaris Kos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #1a1d23;
            --sidebar-hover: #2a2f3a;
            --sidebar-active: #3d4afe;
            --sidebar-width: 260px;
            --accent: #3d4afe;
            --accent-light: #e8eaff;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f0f2f8;
            margin: 0;
            padding: 0;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent), #7986ff);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            margin-bottom: 12px;
        }

        .sidebar-brand h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .sidebar-brand p {
            color: #6c7585;
            font-size: 0.75rem;
            margin: 2px 0 0;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
        }

        .sidebar-nav .nav-label {
            color: #4a5060;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0 8px;
            margin-bottom: 6px;
            margin-top: 12px;
        }

        .sidebar-nav .nav-link {
            color: #9ba3b2;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 2px;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #ffffff;
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, var(--accent), #5c6bff);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(61,74,254,0.35);
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-footer p {
            color: #4a5060;
            font-size: 0.72rem;
            margin: 0;
            text-align: center;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOP NAVBAR ===== */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e8ecf0;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }

        .top-navbar .page-breadcrumb {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .top-navbar .page-breadcrumb .current {
            color: #212529;
            font-weight: 600;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-user .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent), #7986ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .navbar-user .user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: #212529;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 28px 30px;
            flex: 1;
        }

        /* ===== FLASH MESSAGE ===== */
        .flash-message {
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        /* ===== BADGE KONDISI ===== */
        .badge-baik {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-rusak-ringan {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-rusak {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* ===== TABLE ===== */
        .table th {
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 2px solid #e8ecf0 !important;
        }

        .table td {
            vertical-align: middle;
            border-color: #f0f2f8;
        }

        .table tbody tr {
            transition: background 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
        }

        /* ===== FORM STYLES ===== */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(61,74,254,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #5c6bff);
            border: none;
            box-shadow: 0 4px 12px rgba(61,74,254,0.3);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3038e0, #4d5cf0);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(61,74,254,0.4);
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border-radius: 14px;
            padding: 20px;
            color: white;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }
    </style>

    @stack('styles')
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">🏠</div>
        <h5>Inventaris Kos</h5>
        <p>Manajemen Aset & Properti</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>

        <a href="{{ route('inventaris.index') }}"
           class="nav-link {{ request()->routeIs('inventaris.index') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Data Inventaris</span>
        </a>

        <a href="{{ route('inventaris.create') }}"
           class="nav-link {{ request()->routeIs('inventaris.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Tambah Aset Baru</span>
        </a>

        <div class="nav-label" style="margin-top: 20px;">Informasi</div>

        <div class="nav-link" style="cursor: default; opacity: 0.5;">
            <i class="bi bi-database-fill"></i>
            <span>db_inventaris_kos</span>
        </div>

        <div class="nav-link" style="cursor: default; opacity: 0.5;">
            <i class="bi bi-layers-fill"></i>
            <span>Laravel + Eloquent</span>
        </div>
    </nav>

    <div class="sidebar-footer">
        <p>Sistem Manajemen Kos &copy; {{ date('Y') }}<br>Built with Laravel</p>
    </div>
</aside>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

    <!-- TOP NAVBAR -->
    <header class="top-navbar">
        <div class="page-breadcrumb">
            <i class="bi bi-house-door me-1"></i>
            Inventaris Kos &rsaquo;
            <span class="current">@yield('breadcrumb', 'Dashboard')</span>
        </div>
        <div class="navbar-user">
            <div class="avatar">IK</div>
            <span class="user-name">Admin Kos</span>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="page-content">

        {{-- FLASH MESSAGE --}}
        @if(session('flash_success'))
            <div class="alert alert-success alert-dismissible fade show flash-message shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Berhasil!</strong> {{ session('flash_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('flash_error'))
            <div class="alert alert-danger alert-dismissible fade show flash-message shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Perhatian!</strong> {{ session('flash_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
