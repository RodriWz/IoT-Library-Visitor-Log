<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengunjungController;

/*
|--------------------------------------------------------------------------
| Rute untuk Tamu (Guest) - Yang belum login
|--------------------------------------------------------------------------
*/

// Halaman utama sekarang HANYA mengarah ke halaman login.
Route::get('/', [LoginController::class, 'index'])->name('login');

// REGISTER
Route::get('/register', [RegisterController::class, 'index'])->name('register'); 
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// LOGIN
Route::get('/login', [LoginController::class, 'index']); // name 'login' sudah ada di atas
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');


/*
|--------------------------------------------------------------------------
| Rute untuk Pengguna yang Sudah Login (Authenticated)
|--------------------------------------------------------------------------
|
| Semua rute di dalam grup ini WAJIB login. Jika belum, akan
| otomatis dialihkan ke halaman 'login'.
|
*/
Route::middleware('auth')->group(function () {
    
    // LOGOUT (Hanya bisa diakses jika sudah login)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PENGUNJUNG (FORM INPUT DATA)
    // URL diubah menjadi /pengunjung agar tidak bentrok
    Route::get('/pengunjung', [PengunjungController::class, 'index'])->name('pengunjung');
    Route::post('/pengunjung', [PengunjungController::class, 'store'])->name('pengunjung.store');

});
