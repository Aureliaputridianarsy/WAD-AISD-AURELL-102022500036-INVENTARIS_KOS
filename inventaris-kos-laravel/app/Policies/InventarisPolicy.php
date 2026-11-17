<?php

namespace App\Policies;

use App\Models\Inventaris;
use App\Models\User;

class InventarisPolicy
{
    /**
     * Menentukan apakah pengguna dapat melihat daftar inventaris.
     * Semua pengguna yang login (Admin, Staff, Penyewa) diizinkan membaca data.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Menentukan apakah pengguna dapat melihat detail aset.
     */
    public function view(User $user, Inventaris $inventaris): bool
    {
        return true;
    }

    /**
     * Menentukan apakah pengguna dapat menambah data aset baru.
     * Hanya Admin dan Staff yang diizinkan.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    /**
     * Menentukan apakah pengguna dapat memperbarui data aset.
     * Hanya Admin dan Staff yang diizinkan.
     */
    public function update(User $user, Inventaris $inventaris): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    /**
     * Menentukan apakah pengguna dapat menghapus data aset.
     * HANYA Admin yang diizinkan menghapus data dari sistem.
     */
    public function delete(User $user, Inventaris $inventaris): bool
    {
        return $user->isAdmin();
    }
}
