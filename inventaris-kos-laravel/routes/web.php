<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarisController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Inventaris Kos dengan Role-Based Access Control
|--------------------------------------------------------------------------
*/

// ===== AUTENTIKASI (GUEST) =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ===== LOGOUT (AUTH) =====
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===== FITUR APLIKASI (AUTH TERPROTEKSI) =====
Route::middleware('auth')->group(function () {

    // Redirect root ke halaman inventaris
    Route::get('/', function () {
        return redirect()->route('inventaris.index');
    });

    // Resource Route untuk CRUD Inventaris
    // GET    /inventaris           -> index   (Admin, Staff, Penyewa)
    // GET    /inventaris/create    -> create  (Admin, Staff)
    // POST   /inventaris           -> store   (Admin, Staff)
    // GET    /inventaris/{id}/edit -> edit    (Admin, Staff)
    // PUT    /inventaris/{id}      -> update  (Admin, Staff)
    // DELETE /inventaris/{id}      -> destroy (Khusus Admin)
    Route::resource('inventaris', InventarisController::class)
        ->parameters(['inventaris' => 'inventaris'])
        ->except(['show']);
});
