# Panduan Menjalankan Sistem Inventaris Kos (CRUD MySQL)

Sistem ini dibuat untuk memenuhi tugas lanjutan web studi kasus manajemen kos dengan fitur **1 CRUD lengkap (Inventaris Aset)** yang terhubung langsung ke basis data **MySQL** menggunakan **Laragon** atau **XAMPP**.

---

## 📁 Struktur File & Direktori

```text
inventaris-kos/
├── config/
│   └── database.php         # Koneksi PHP ke MySQL (Host: localhost, User: root, Pass: kosong)
├── database/
│   └── schema.sql           # Query pembuatan database & tabel otomatis + sample data
├── components/
│   └── sidebar.php          # Komponen navigasi reusable
├── index.php                # DASHBOARD: Ringkasan & statistik realtime (Total, Baik, Rusak)
├── data-inventaris.php      # READ: Menampilkan daftar seluruh aset dari MySQL + Filter & Search
├── tambah-aset.php          # CREATE: Formulir penambahan data aset baru ke database
├── edit-aset.php            # UPDATE: Formulir edit/perbarui data aset berdasarkan ID
├── proses.php               # CONTROLLER/HANDLER: Logika proses Simpan, Edit, dan Hapus
└── README.md                # Dokumentasi petunjuk penggunaan
```

---

## 🚀 Langkah Menjalankan dengan Laragon / XAMPP

### Menggunakan Laragon:
1. Buka aplikasi **Laragon**.
2. Klik tombol **Start All** (memastikan Apache & MySQL berjalan).
3. Klik tombol **Database** (membuka HeidiSQL / phpMyAdmin).
4. Buat database baru bernama `db_inventaris_kos` atau buka menu **Query / File -> Load SQL File** lalu pilih file:
   `database/schema.sql` dan klik **Run / Execute**.
5. Salin folder proyek ini ke direktori `www` Laragon (biasanya di `C:\laragon\www\` atau `D:\laragon\www\`), atau buka langsung melalui terminal built-in dengan perintah:
   ```bash
   php -S localhost:8000
   ```
6. Buka browser dan akses: `http://localhost:8000/index.php` atau `http://localhost/inventaris-kos/index.php`.

### Menggunakan XAMPP:
1. Buka **XAMPP Control Panel**.
2. Klik tombol **Start** pada modul **Apache** dan **MySQL**.
3. Buka browser dan buka `http://localhost/phpmyadmin`.
4. Buat database baru dengan nama `db_inventaris_kos`.
5. Klik tab **Import**, pilih file `database/schema.sql`, lalu klik **Import / Go**.
6. Letakkan folder ini di `htdocs` XAMPP (biasanya `C:\xampp\htdocs\inventaris-kos`).
7. Buka browser dan akses: `http://localhost/inventaris-kos/index.php`.

---

## ⚙️ Fitur CRUD yang Disediakan

| Operasi | File Terkait | Deskripsi |
| :--- | :--- | :--- |
| **Create** | `tambah-aset.php`, `proses.php` | Menambah data aset baru (Nama, Kategori, Merk, Lokasi, Kondisi, Catatan) ke MySQL. |
| **Read** | `data-inventaris.php`, `index.php` | Menampilkan seluruh data aset dari tabel MySQL dengan filter kondisi & pencarian realtime. |
| **Update** | `edit-aset.php`, `proses.php` | Mengubah informasi aset yang sudah ada secara dinamis berdasarkan `id`. |
| **Delete** | `data-inventaris.php`, `proses.php` | Menghapus aset dari tabel MySQL dengan modal konfirmasi keamanan. |
