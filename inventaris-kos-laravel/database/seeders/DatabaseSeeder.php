<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun contoh untuk setiap role
        User::updateOrCreate(
            ['email' => 'admin@kos.com'],
            [
                'name'     => 'Admin Kos',
                'password' => 'password',
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@kos.com'],
            [
                'name'     => 'Staff Inventaris',
                'password' => 'password',
                'role'     => 'staff',
            ]
        );

        User::updateOrCreate(
            ['email' => 'penyewa@kos.com'],
            [
                'name'     => 'Ahmad Penyewa',
                'password' => 'password',
                'role'     => 'penyewa',
            ]
        );

        $this->call([
            InventarisSeeder::class,
        ]);
    }
}
