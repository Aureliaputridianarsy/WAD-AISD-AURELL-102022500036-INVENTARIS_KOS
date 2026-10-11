<?php
session_start();
require_once __DIR__ . '/config/database.php';

$activePage = 'inventaris';

// Query data inventaris dari database
$query = "SELECT * FROM inventaris ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$totalData = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Inventaris - Kos Management</title>

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

        .content {
            padding: 30px;
        }

        .page-title {
            font-weight: 700;
            color: #212529;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .table-container {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
        }

        .badge-kondisi-baik {
            background-color: #198754;
            color: white;
        }

        .badge-kondisi-rusak-ringan {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-kondisi-rusak {
            background-color: #dc3545;
            color: white;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.5px;
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
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="page-title mb-1">Data Inventaris Aset</h2>
                    <p class="text-muted mb-0">Kelola dan pantau seluruh data aset yang tersimpan di database MySQL.</p>
                </div>
                <div>
                    <a href="tambah-aset.php" class="btn btn-primary px-3 py-2 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> + Tambah Aset Baru
                    </a>
                </div>
            </div>

            <!-- FLASH MESSAGE NOTIFIKASI -->
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= htmlspecialchars($_SESSION['flash_message']['type']); ?> alert-dismissible fade show shadow-sm" role="alert">
                    <strong><?= $_SESSION['flash_message']['type'] === 'success' ? 'Berhasil!' : 'Perhatian!'; ?></strong>
                    <?= htmlspecialchars($_SESSION['flash_message']['text']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash_message']); ?>
            <?php endif; ?>

            <!-- FILTER & PENCARIAN -->
            <div class="card shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-muted mb-1">Cari Aset</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
                                <input
                                    type="text"
                                    id="searchInput"
                                    class="form-control"
                                    placeholder="Cari berdasarkan nama aset, merk, atau lokasi..."
                                    onkeyup="searchAsset()"
                                >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-muted mb-1">Filter Kondisi</label>
                            <select id="conditionFilter" class="form-select" onchange="filterCondition()">
                                <option value="all">Semua Kondisi</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>

                        <div class="col-md-2 text-md-end mt-md-4">
                            <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE CONTAINER -->
            <div class="table-container shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">Daftar Aset Kos</h5>
                    <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                        Total: <strong id="totalData" class="text-primary"><?= $totalData; ?></strong> aset
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Aset</th>
                                <th>Kategori</th>
                                <th>Merk</th>
                                <th>Lokasi</th>
                                <th>Kondisi</th>
                                <th>Keterangan</th>
                                <th style="width: 160px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="assetTable">
                            <?php if ($totalData > 0): ?>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                                    <?php
                                    $kondisiClass = 'badge-kondisi-baik';
                                    if ($row['kondisi'] === 'Rusak Ringan') {
                                        $kondisiClass = 'badge-kondisi-rusak-ringan';
                                    } elseif ($row['kondisi'] === 'Rusak') {
                                        $kondisiClass = 'badge-kondisi-rusak';
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-muted fw-bold"><?= $no++; ?></td>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_aset']); ?></td>
                                        <td><span class="badge bg-secondary-subtle text-secondary border"><?= htmlspecialchars($row['kategori']); ?></span></td>
                                        <td><?= htmlspecialchars($row['merk']); ?></td>
                                        <td><i class="bi bi-geo-alt text-danger me-1"></i><?= htmlspecialchars($row['lokasi']); ?></td>
                                        <td>
                                            <span class="badge <?= $kondisiClass; ?> px-2 py-1">
                                                <?= htmlspecialchars($row['kondisi']); ?>
                                            </span>
                                        </td>
                                        <td class="small text-muted"><?= htmlspecialchars($row['keterangan'] ?: '-'); ?></td>
                                        <td class="text-center">
                                            <a href="edit-aset.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning text-dark me-1" title="Edit Aset">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <button 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmHapus(<?= $row['id']; ?>, '<?= htmlspecialchars(addslashes($row['nama_aset'])); ?>')"
                                                title="Hapus Aset"
                                            >
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr id="emptyRow">
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Belum ada data aset tersimpan di database.
                                        <br>
                                        <a href="tambah-aset.php" class="btn btn-sm btn-primary mt-2">Tambah Aset Sekarang</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="text-center text-muted mt-4">
                <small>Sistem Manajemen Kos & Properti &copy; <?= date('Y'); ?> &bull; Terhubung ke MySQL</small>
            </div>

        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                Apakah Anda yakin ingin menghapus aset <strong id="deleteAssetName" class="text-danger"></strong> dari database?
                <p class="text-muted small mt-2 mb-0">Tindakan ini permanen dan data yang dihapus tidak dapat dipulihkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="btnConfirmDelete" href="#" class="btn btn-danger">Hapus Permanen</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
let deleteModalInstance;

document.addEventListener("DOMContentLoaded", function() {
    deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteModal'));
});

function confirmHapus(id, nama) {
    document.getElementById('deleteAssetName').innerText = nama;
    document.getElementById('btnConfirmDelete').href = 'proses.php?aksi=hapus&id=' + id;
    deleteModalInstance.show();
}

function updateTotal() {
    let visibleRows = document.querySelectorAll("#assetTable tr:not([style*='display: none']):not(#emptyRow)");
    document.getElementById("totalData").innerText = visibleRows.length;
}

function searchAsset() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let filter = document.getElementById("conditionFilter").value;
    let rows = document.querySelectorAll("#assetTable tr:not(#emptyRow)");

    rows.forEach(function(row) {
        let text = row.innerText.toLowerCase();
        let condition = row.cells[5] ? row.cells[5].innerText.trim() : '';

        let matchText = text.includes(input);
        let matchCondition = (filter === 'all' || condition === filter);

        if (matchText && matchCondition) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });

    updateTotal();
}

function filterCondition() {
    searchAsset();
}

function resetFilters() {
    document.getElementById("searchInput").value = "";
    document.getElementById("conditionFilter").value = "all";
    searchAsset();
}
</script>

</body>
</html>
