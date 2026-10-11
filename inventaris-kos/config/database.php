<?php
// ===================================================
// Konfigurasi Koneksi Database MySQL (Laragon / XAMPP)
// ===================================================

$host = '127.0.0.1'; // atau localhost
$user = 'root';
$pass = '';          // default Laragon dan XAMPP kosong
$db   = 'db_inventaris_kos';
$port = 3306;

// Matikan pelaporan error default MySQLi agar bisa kita tangani secara manual
mysqli_report(MYSQLI_REPORT_OFF);

$conn = @mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    // Jika database belum dibuat atau MySQL belum running
    $error_msg = mysqli_connect_error();
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Koneksi Database Gagal</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light py-5">
        <div class="container">
            <div class="card shadow-sm border-danger mx-auto" style="max-width: 650px;">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">⚠️ Gagal Terhubung ke Database MySQL</h5>
                </div>
                <div class="card-body">
                    <p class="text-danger fw-semibold">Error: <?= htmlspecialchars($error_msg); ?></p>
                    <hr>
                    <h6>Langkah-langkah Penyelesaian:</h6>
                    <ol class="small mb-3">
                        <li>Pastikan aplikasi <strong>Laragon</strong> atau <strong>XAMPP</strong> sudah dibuka dan tombol <strong>Start All</strong> atau <strong>Start MySQL</strong> sudah aktif.</li>
                        <li>Pastikan database <code>db_inventaris_kos</code> sudah dibuat atau import file SQL dari <code>database/schema.sql</code> melalui <em>phpMyAdmin</em> atau <em>HeidiSQL</em>.</li>
                    </ol>
                    <div class="alert alert-info small mb-0">
                        Default kredensial: Host: <code>localhost</code>, User: <code>root</code>, Password: <code>(kosong)</code>, Port: <code>3306</code>.
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Set charset utf8mb4
mysqli_set_charset($conn, "utf8mb4");
?>
