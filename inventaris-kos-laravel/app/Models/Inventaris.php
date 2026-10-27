<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    /**
     * Nama tabel di database.
     */
    protected $table = 'inventaris';

    /**
     * Kolom yang boleh diisi (mass assignment).
     */
    protected $fillable = [
        'nama_aset',
        'kategori',
        'merk',
        'lokasi',
        'kondisi',
        'keterangan',
    ];

    /**
     * Aktifkan timestamps (created_at, updated_at sudah ada di tabel).
     */
    public $timestamps = true;
}
