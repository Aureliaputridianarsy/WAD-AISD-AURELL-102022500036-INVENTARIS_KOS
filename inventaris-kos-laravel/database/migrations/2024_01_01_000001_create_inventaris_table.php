<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel inventaris di database db_inventaris_kos.
     */
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aset', 100);
            $table->string('kategori', 50);
            $table->string('merk', 50);
            $table->string('lokasi', 50);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak'])->default('Baik');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel inventaris.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
