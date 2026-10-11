<?php
session_start();
require_once __DIR__ . '/config/database.php';

$aksi = $_GET['aksi'] ?? $_POST['aksi'] ?? '';

// ==========================================
// 1. PROSES TAMBAH ASET (CREATE)
// ==========================================
if ($aksi === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_aset  = trim($_POST['nama_aset'] ?? '');
    $kategori   = trim($_POST['kategori'] ?? '');
    $merk       = trim($_POST['merk'] ?? '');
    $lokasi     = trim($_POST['lokasi'] ?? '');
    $kondisi    = trim($_POST['kondisi'] ?? 'Baik');
    $keterangan = trim($_POST['keterangan'] ?? '');

    // Validasi sederhana
    if (empty($nama_aset) || empty($kategori) || empty($merk) || empty($lokasi)) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'text' => 'Mohon lengkapi semua kolom yang wajib diisi!'
        ];
        header('Location: tambah-aset.php');
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO inventaris (nama_aset, kategori, merk, lokasi, kondisi, keterangan) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $nama_aset, $kategori, $merk, $lokasi, $kondisi, $keterangan);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Data aset "' . htmlspecialchars($nama_aset) . '" berhasil ditambahkan ke database!'
            ];
            header('Location: data-inventaris.php');
            exit;
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'text' => 'Gagal menyimpan data: ' . mysqli_error($conn)
            ];
            header('Location: tambah-aset.php');
            exit;
        }
    }
}

// ==========================================
// 2. PROSES EDIT ASET (UPDATE)
// ==========================================
elseif ($aksi === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = (int)($_POST['id'] ?? 0);
    $nama_aset  = trim($_POST['nama_aset'] ?? '');
    $kategori   = trim($_POST['kategori'] ?? '');
    $merk       = trim($_POST['merk'] ?? '');
    $lokasi     = trim($_POST['lokasi'] ?? '');
    $kondisi    = trim($_POST['kondisi'] ?? 'Baik');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($id <= 0 || empty($nama_aset) || empty($kategori) || empty($merk) || empty($lokasi)) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'text' => 'Data tidak valid atau kolom wajib belum diisi!'
        ];
        header("Location: edit-aset.php?id=$id");
        exit;
    }

    $stmt = mysqli_prepare($conn, "UPDATE inventaris SET nama_aset = ?, kategori = ?, merk = ?, lokasi = ?, kondisi = ?, keterangan = ? WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $nama_aset, $kategori, $merk, $lokasi, $kondisi, $keterangan, $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Data aset "' . htmlspecialchars($nama_aset) . '" berhasil diperbarui!'
            ];
            header('Location: data-inventaris.php');
            exit;
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'text' => 'Gagal memperbarui data: ' . mysqli_error($conn)
            ];
            header("Location: edit-aset.php?id=$id");
            exit;
        }
    }
}

// ==========================================
// 3. PROSES HAPUS ASET (DELETE)
// ==========================================
elseif ($aksi === 'hapus') {
    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'text' => 'ID aset tidak ditemukan!'
        ];
        header('Location: data-inventaris.php');
        exit;
    }

    // Ambil nama aset dulu untuk pesan konfirmasi
    $stmtNama = mysqli_prepare($conn, "SELECT nama_aset FROM inventaris WHERE id = ?");
    mysqli_stmt_bind_param($stmtNama, "i", $id);
    mysqli_stmt_execute($stmtNama);
    $resNama = mysqli_stmt_get_result($stmtNama);
    $rowNama = mysqli_fetch_assoc($resNama);
    $namaHapus = $rowNama['nama_aset'] ?? 'Aset';

    $stmt = mysqli_prepare($conn, "DELETE FROM inventaris WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Data aset "' . htmlspecialchars($namaHapus) . '" berhasil dihapus dari database!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'text' => 'Gagal menghapus data: ' . mysqli_error($conn)
            ];
        }
    }

    header('Location: data-inventaris.php');
    exit;
}

// Default redirect jika aksi tidak cocok
header('Location: data-inventaris.php');
exit;
