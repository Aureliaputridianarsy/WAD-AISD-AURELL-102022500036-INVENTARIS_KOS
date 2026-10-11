<?php
session_start();
require_once __DIR__ . '/config/database.php';

$activePage = 'tambah';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aset Baru - Kos Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            padding: 25px 15px;
        }

        .sidebar .nav-link {
            color: #ced4da;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #343a40;
            color: #ffffff;
        }

        .content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- INCLUDE SIDEBAR -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- CONTENT -->
        <div class="col-md-9 col-lg-10 content">

            <!-- BREADCRUMB & HEADER -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="data-inventaris.php" class="text-decoration-none">Inventaris</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Aset Baru</li>
                </ol>
            </nav>

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Tambah Aset Baru</h2>
                <p class="text-muted">Lengkapi formulir di bawah ini untuk menambahkan barang inventaris baru ke database.</p>
            </div>

            <!-- FLASH MESSAGE -->
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= htmlspecialchars($_SESSION['flash_message']['type']); ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?= htmlspecialchars($_SESSION['flash_message']['text']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <!-- FORM CARD -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm p-4">
                        <form action="proses.php" method="POST">
                            <input type="hidden" name="aksi" value="tambah">

                            <div class="mb-3">
                                <label for="nama_aset" class="form-label fw-semibold">Nama Aset / Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_aset" name="nama_aset" placeholder="Contoh: AC Panasonic 1/2 PK" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Furniture">Furniture</option>
                                        <option value="Sanitasi / Kamar Mandi">Sanitasi / Kamar Mandi</option>
                                        <option value="Peralatan Kebersihan">Peralatan Kebersihan</option>
                                        <option value="Perlengkapan Keamanan">Perlengkapan Keamanan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="merk" class="form-label fw-semibold">Merk / Brand <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="merk" name="merk" placeholder="Contoh: Sharp, Informa, Maspion" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label fw-semibold">Lokasi Penempatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Contoh: Kamar 101, Dapur Bersama" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="kondisi" class="form-label fw-semibold">Kondisi Aset <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kondisi" name="kondisi" required>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak">Rusak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan / Catatan Tambahan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Tanggal pembelian, riwayat garansi, atau catatan kondisi khusus..."></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="data-inventaris.php" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bi bi-save me-1"></i> Simpan ke Database
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- SIDE INFORMATION CARD -->
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card shadow-sm border-0 bg-white p-3 mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark"><i class="bi bi-info-circle-fill text-primary me-2"></i>Panduan Pengisian</h6>
                            <ul class="small text-muted ps-3 mb-0">
                                <li>Pastikan mengisi nama barang dengan jelas dan spesifik.</li>
                                <li>Kategori memudahkan dalam pengelompokan saat audit inventaris.</li>
                                <li>Lokasi menunjukkan letak fisik aset (misal nomor kamar atau area bersama).</li>
                                <li>Pilihan kondisi akan mempengaruhi statistik pada dashboard.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="text-center text-muted mt-5">
                <small>Sistem Manajemen Kos & Properti &copy; <?= date('Y'); ?></small>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
