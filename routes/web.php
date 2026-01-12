<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\DaftarPengunjungController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OtpResetPasswordController;

/*
|-------------------------------------------------------------------------- 
| RUTE TAMU (BELUM LOGIN)
|-------------------------------------------------------------------------- 
*/

Route::get('/', [LoginController::class, 'index'])->name('login');

// REGISTER
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// LOGIN
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.auth');

// ===== OTP RESET PASSWORD (TANPA LOGIN) =====
Route::get('/forgot-password', [OtpResetPasswordController::class, 'showEmailForm'])
    ->name('otp.email.form');

Route::post('/forgot-password', [OtpResetPasswordController::class, 'sendOtp'])
    ->name('otp.send');

Route::get('/reset-password-otp', [OtpResetPasswordController::class, 'showResetForm'])
    ->name('otp.reset.form');

Route::post('/reset-password-otp', [OtpResetPasswordController::class, 'resetPassword'])
    ->name('otp.reset');



/*
|-------------------------------------------------------------------------- 
| RUTE SETELAH LOGIN
|-------------------------------------------------------------------------- 
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/formpengunjung', [PengunjungController::class, 'create'])->name('formpengunjung');
    Route::post('/formpengunjung', [PengunjungController::class, 'store'])->name('pengunjung.store');

    Route::get('/daftarpengunjung', [DaftarPengunjungController::class, 'index'])->name('daftarpengunjung');
    Route::post('/pengunjung/{id}/update', [DaftarPengunjungController::class, 'update'])->name('pengunjung.update');
    Route::post('/pengunjung/{id}/delete', [DaftarPengunjungController::class, 'destroy'])->name('pengunjung.delete');

    Route::get('/laporanpengunjung', [LaporanController::class, 'index'])->name('laporanpengunjung');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    // PENGATURAN
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/update-profile', [SettingController::class, 'updateProfile'])->name('pengaturan.update.profile');
    Route::post('/pengaturan/update-password', [SettingController::class, 'updatePassword'])->name('pengaturan.update.password');

    Route::get('/get-user-photo', [SettingController::class, 'getUserPhoto'])->name('get.user.photo');

    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
});
