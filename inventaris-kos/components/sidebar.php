<?php
$currentPage = $activePage ?? 'dashboard';
?>
<!-- SIDEBAR -->
<div class="col-md-3 col-lg-2 sidebar p-3 text-white">
    <div class="d-flex align-items-center mb-4 px-2">
        <span class="fs-4 me-2">🏢</span>
        <h5 class="mb-0 fw-bold tracking-wide">KOS MANAGEMENT</h5>
    </div>

    <nav class="nav flex-column">
        <a href="index.php" class="nav-link <?= ($currentPage === 'dashboard') ? 'active' : '' ?>">
            <span class="me-2">🏠</span> Dashboard
        </a>
        <a href="data-inventaris.php" class="nav-link <?= ($currentPage === 'inventaris') ? 'active' : '' ?>">
            <span class="me-2">📦</span> Data Inventaris
        </a>
        <a href="tambah-aset.php" class="nav-link <?= ($currentPage === 'tambah') ? 'active' : '' ?>">
            <span class="me-2">➕</span> Tambah Aset
        </a>
    </nav>

    <hr class="text-secondary my-4">

    <div class="px-2 small text-muted">
        <div>Status DB: <span class="badge bg-success">Terhubung</span></div>
        <div class="mt-1">MySQL: <code>db_inventaris_kos</code></div>
    </div>
</div>
