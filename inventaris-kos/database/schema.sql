-- ===================================================
-- Skrip Pembuatan Database & Tabel Inventaris Kos
-- ===================================================

CREATE DATABASE IF NOT EXISTS `db_inventaris_kos` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `db_inventaris_kos`;

-- Buat tabel inventaris jika belum ada
CREATE TABLE IF NOT EXISTS `inventaris` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_aset` VARCHAR(100) NOT NULL,
    `kategori` VARCHAR(50) NOT NULL,
    `merk` VARCHAR(50) NOT NULL,
    `lokasi` VARCHAR(50) NOT NULL,
    `kondisi` ENUM('Baik', 'Rusak Ringan', 'Rusak') NOT NULL DEFAULT 'Baik',
    `keterangan` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Data Awal
INSERT INTO `inventaris` (`nama_aset`, `kategori`, `merk`, `lokasi`, `kondisi`, `keterangan`) VALUES
('AC Split 1/2 PK', 'Elektronik', 'Panasonic', 'Kamar 101', 'Baik', 'Rutin servis 3 bulan sekali'),
('Smart TV 32 Inch', 'Elektronik', 'Samsung', 'Kamar 102', 'Baik', 'Fasilitas premium kamar VIP'),
('Springbed Queen Size', 'Furniture', 'Informa', 'Kamar 103', 'Rusak Ringan', 'Per butuh dicek, seprai baru'),
('Lemari Pakaian 2 Pintu', 'Furniture', 'Olympic', 'Kamar 104', 'Baik', 'Kunci cadangan ada di pengelola'),
('Meja Belajar Kayu Jati', 'Furniture', 'IKEA', 'Kamar 105', 'Baik', 'Kondisi kokoh dan bersih');
