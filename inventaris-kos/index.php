<?php
session_start();
require_once __DIR__ . '/config/database.php';

$activePage = 'dashboard';

// Ambil statistik dari database
$resTotal = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inventaris");
$rowTotal = mysqli_fetch_assoc($resTotal);
$totalAset = $rowTotal['total'] ?? 0;

$resBaik = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inventaris WHERE kondisi = 'Baik'");
$rowBaik = mysqli_fetch_assoc($resBaik);
$asetBaik = $rowBaik['total'] ?? 0;

$resPerluPerbaikan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inventaris WHERE kondisi IN ('Rusak Ringan', 'Rusak')");
$rowPerluPerbaikan = mysqli_fetch_assoc($resPerluPerbaikan);
$asetPerluPerbaikan = $rowPerluPerbaikan['total'] ?? 0;

// Ambil 5 data aset terbaru
$queryRingkasan = "SELECT * FROM inventaris ORDER BY id DESC LIMIT 5";
$resultRingkasan = mysqli_query($conn, $queryRingkasan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Kos - Dashboard</title>

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

        .sidebar h5 {
            letter-spacing: 0.5px;
        }

        .sidebar .nav-link {
            color: #ced4da;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #343a40;
            color: #ffffff;
        }

        .card-stat {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-stat:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        .content {
            padding: 30px;
        }

        .welcome {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
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

            <!-- HEADER -->
            <div class="welcome shadow-sm d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard Inventaris Aset</h2>
                    <p class="text-muted mb-0">Sistem Manajemen Kos untuk memantau data aset dan kondisi barang secara realtime.</p>
                </div>
                <div>
                    <a href="tambah-aset.php" class="btn btn-primary px-3 py-2 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> + Tambah Aset
                    </a>
                </div>
            </div>

            <!-- FLASH MESSAGE -->
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= htmlspecialchars($_SESSION['flash_message']['type']); ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?= htmlspecialchars($_SESSION['flash_message']['text']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <!-- STATISTICS CARDS -->
            <div class="row g-4 mb-4">

                <!-- TOTAL ASET -->
                <div class="col-md-4">
                    <div class="card card-stat shadow-sm p-4 bg-white border-start border-primary border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Aset</h6>
                                <h2 class="fw-bold mb-0 text-dark"><?= $totalAset; ?></h2>
                                <small class="text-muted">Seluruh aset terdaftar di kos</small>
                            </div>
                            <div class="fs-1 text-primary opacity-75">
                                <i class="bi bi-boxes"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ASET BAIK -->
                <div class="col-md-4">
                    <div class="card card-stat shadow-sm p-4 bg-white border-start border-success border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Kondisi Baik</h6>
                                <h2 class="fw-bold mb-0 text-success"><?= $asetBaik; ?></h2>
                                <small class="text-muted">Siap dan layak digunakan</small>
                            </div>
                            <div class="fs-1 text-success opacity-75">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PERLU PERBAIKAN -->
                <div class="col-md-4">
                    <div class="card card-stat shadow-sm p-4 bg-white border-start border-warning border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Perlu Perbaikan</h6>
                                <h2 class="fw-bold mb-0 text-warning"><?= $asetPerluPerbaikan; ?></h2>
                                <small class="text-muted">Rusak ringan atau perlu servis</small>
                            </div>
                            <div class="fs-1 text-warning opacity-75">
                                <i class="bi bi-tools"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RINGKASAN DATA TERBARU -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Ringkasan Inventaris Terbaru</h5>
                        <a href="data-inventaris.php" class="btn btn-sm btn-outline-dark">
                            Kelola Semua Data &rarr;
                        </a>
                    </div>
                    <p class="text-muted small">Menampilkan 5 data aset kos yang paling baru ditambahkan atau diperbarui.</p>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-3">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Aset</th>
                                    <th>Kategori</th>
                                    <th>Merk</th>
                                    <th>Lokasi</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($totalAset > 0): ?>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($resultRingkasan)): ?>
                                        <tr>
                                            <td class="text-muted fw-bold"><?= $no++; ?></td>
                                            <td class="fw-semibold"><?= htmlspecialchars($row['nama_aset']); ?></td>
                                            <td><span class="badge bg-secondary-subtle text-secondary border"><?= htmlspecialchars($row['kategori']); ?></span></td>
                                            <td><?= htmlspecialchars($row['merk']); ?></td>
                                            <td><i class="bi bi-geo-alt text-danger me-1"></i><?= htmlspecialchars($row['lokasi']); ?></td>
                                            <td>
                                                <?php if ($row['kondisi'] === 'Baik'): ?>
                                                    <span class="badge bg-success">Baik</span>
                                                <?php elseif ($row['kondisi'] === 'Rusak Ringan'): ?>
                                                    <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Rusak</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">
                                            Belum ada data inventaris.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="data-inventaris.php" class="btn btn-dark">
                            <i class="bi bi-table me-1"></i> Buka Menu CRUD Inventaris
                        </a>
                        <a href="tambah-aset.php" class="btn btn-outline-primary">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Aset
                        </a>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="text-center text-muted mt-4">
                <small>Sistem Manajemen Kos & Properti &copy; <?= date('Y'); ?></small>
            </div>

        </div>

    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
