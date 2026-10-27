<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Inventaris Kos
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman inventaris
Route::get('/', function () {
    return redirect()->route('inventaris.index');
});

// Resource Route untuk CRUD Inventaris
// Menghasilkan 6 route otomatis:
// GET    /inventaris           -> index  (Daftar aset)
// GET    /inventaris/create    -> create (Form tambah)
// POST   /inventaris           -> store  (Simpan data baru)
// GET    /inventaris/{id}/edit -> edit   (Form edit)
// PUT    /inventaris/{id}      -> update (Update data)
// DELETE /inventaris/{id}      -> destroy (Hapus data)
Route::resource('inventaris', InventarisController::class)
    ->except(['show']);
