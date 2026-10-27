<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    /**
     * Seed data awal inventaris kos.
     */
    public function run(): void
    {
        DB::table('inventaris')->insert([
            [
                'nama_aset'   => 'AC Split 1/2 PK',
                'kategori'    => 'Elektronik',
                'merk'        => 'Panasonic',
                'lokasi'      => 'Kamar 101',
                'kondisi'     => 'Baik',
                'keterangan'  => 'Rutin servis 3 bulan sekali',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_aset'   => 'Smart TV 32 Inch',
                'kategori'    => 'Elektronik',
                'merk'        => 'Samsung',
                'lokasi'      => 'Kamar 102',
                'kondisi'     => 'Baik',
                'keterangan'  => 'Fasilitas premium kamar VIP',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_aset'   => 'Springbed Queen Size',
                'kategori'    => 'Furniture',
                'merk'        => 'Informa',
                'lokasi'      => 'Kamar 103',
                'kondisi'     => 'Rusak Ringan',
                'keterangan'  => 'Per butuh dicek, seprai baru',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_aset'   => 'Lemari Pakaian 2 Pintu',
                'kategori'    => 'Furniture',
                'merk'        => 'Olympic',
                'lokasi'      => 'Kamar 104',
                'kondisi'     => 'Baik',
                'keterangan'  => 'Kunci cadangan ada di pengelola',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'nama_aset'   => 'Meja Belajar Kayu Jati',
                'kategori'    => 'Furniture',
                'merk'        => 'IKEA',
                'lokasi'      => 'Kamar 105',
                'kondisi'     => 'Baik',
                'keterangan'  => 'Kondisi kokoh dan bersih',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
