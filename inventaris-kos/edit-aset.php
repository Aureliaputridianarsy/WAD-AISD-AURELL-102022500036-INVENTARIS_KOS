<?php
session_start();
require_once __DIR__ . '/config/database.php';

$activePage = 'inventaris';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'text' => 'ID aset tidak valid!'
    ];
    header('Location: data-inventaris.php');
    exit;
}

// Ambil data aset berdasarkan ID
$stmt = mysqli_prepare($conn, "SELECT * FROM inventaris WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$aset = mysqli_fetch_assoc($result);

if (!$aset) {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'text' => 'Data aset dengan ID tersebut tidak ditemukan!'
    ];
    header('Location: data-inventaris.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aset - <?= htmlspecialchars($aset['nama_aset']); ?></title>

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
                    <li class="breadcrumb-item active" aria-current="page">Edit Aset</li>
                </ol>
            </nav>

            <div class="mb-4">
                <h2 class="fw-bold mb-1">Edit Data Aset</h2>
                <p class="text-muted">Perbarui informasi barang inventaris ID #<?= $aset['id']; ?> (<?= htmlspecialchars($aset['nama_aset']); ?>).</p>
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
                            <input type="hidden" name="aksi" value="edit">
                            <input type="hidden" name="id" value="<?= $aset['id']; ?>">

                            <div class="mb-3">
                                <label for="nama_aset" class="form-label fw-semibold">Nama Aset / Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_aset" name="nama_aset" value="<?= htmlspecialchars($aset['nama_aset']); ?>" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <?php
                                        $kategoriList = ['Elektronik', 'Furniture', 'Sanitasi / Kamar Mandi', 'Peralatan Kebersihan', 'Perlengkapan Keamanan', 'Lainnya'];
                                        foreach ($kategoriList as $kat) {
                                            $selected = ($aset['kategori'] === $kat) ? 'selected' : '';
                                            echo "<option value=\"$kat\" $selected>$kat</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="merk" class="form-label fw-semibold">Merk / Brand <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="merk" name="merk" value="<?= htmlspecialchars($aset['merk']); ?>" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="lokasi" class="form-label fw-semibold">Lokasi Penempatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?= htmlspecialchars($aset['lokasi']); ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="kondisi" class="form-label fw-semibold">Kondisi Aset <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kondisi" name="kondisi" required>
                                        <option value="Baik" <?= ($aset['kondisi'] === 'Baik') ? 'selected' : ''; ?>>Baik</option>
                                        <option value="Rusak Ringan" <?= ($aset['kondisi'] === 'Rusak Ringan') ? 'selected' : ''; ?>>Rusak Ringan</option>
                                        <option value="Rusak" <?= ($aset['kondisi'] === 'Rusak') ? 'selected' : ''; ?>>Rusak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan / Catatan Tambahan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= htmlspecialchars($aset['keterangan'] ?? ''); ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="data-inventaris.php" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 shadow-sm">
                                    <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- SIDE INFORMATION CARD -->
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card shadow-sm border-0 bg-white p-3 mb-3">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Informasi Data</h6>
                            <ul class="list-unstyled small text-muted mb-0">
                                <li class="mb-2"><strong>ID Aset:</strong> #<?= $aset['id']; ?></li>
                                <li class="mb-2"><strong>Dibuat Pada:</strong> <?= !empty($aset['created_at']) ? date('d M Y, H:i', strtotime($aset['created_at'])) : '-'; ?></li>
                                <li><strong>Terakhir Diperbarui:</strong> <?= !empty($aset['updated_at']) ? date('d M Y, H:i', strtotime($aset['updated_at'])) : '-'; ?></li>
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
