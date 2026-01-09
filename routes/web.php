<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\DaftarPengunjungController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Rute untuk Tamu (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [LoginController::class, 'index'])->name('login');

// REGISTER
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// LOGIN
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');

// RESET PASSWORD TANPA LOGIN
Route::post('/reset-password/send-code', [SettingController::class, 'sendResetCode'])
    ->name('reset.send.code');

Route::post('/reset-password/reset', [SettingController::class, 'resetPassword'])
    ->name('reset.password');

/*
|--------------------------------------------------------------------------
| Rute Setelah Login (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // FORM PENGUNJUNG
    Route::get('/formpengunjung', [PengunjungController::class, 'create'])->name('formpengunjung');
    Route::post('/formpengunjung', [PengunjungController::class, 'store'])->name('pengunjung.store');

    // DAFTAR PENGUNJUNG
    Route::get('/daftarpengunjung', [DaftarPengunjungController::class, 'index'])->name('daftarpengunjung');
    Route::post('/pengunjung/{id}/update', [DaftarPengunjungController::class, 'update'])->name('pengunjung.update');
    Route::post('/pengunjung/{id}/delete', [DaftarPengunjungController::class, 'destroy'])->name('pengunjung.delete');

    // LAPORAN
    Route::get('/laporanpengunjung', [LaporanController::class, 'index'])->name('laporanpengunjung');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN / SETTINGS
    |--------------------------------------------------------------------------
    */

    // HALAMAN PENGATURAN
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan');

    // UPDATE FOTO PROFIL
    Route::post('/pengaturan/update-profile', [SettingController::class, 'updateProfile'])
        ->name('pengaturan.update.profile');

    // UPDATE PASSWORD MANUAL
    Route::post('/pengaturan/update-password', [SettingController::class, 'updatePassword'])
        ->name('pengaturan.update.password');

    // GET FOTO USER (AJAX)
    Route::get('/get-user-photo', [SettingController::class, 'getUserPhoto'])
        ->name('get.user.photo');

    // Route Chart Data untuk AJAX
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
});
