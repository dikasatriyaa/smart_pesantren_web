<?php

use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AktivitasPendidikanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GurusController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KesehatanController;
use App\Http\Controllers\KitabController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('welcome');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/santri', SantriController::class);
    Route::post('/santri/upload', [SantriController::class, 'upload'])->name('santri.upload.post');
    Route::get('/file/download', [SantriController::class, 'download']);
    Route::resource('/akademik', AkademikController::class);
    Route::resource('/aktivitas', AktivitasPendidikanController::class);
    Route::resource('/hafalan', HafalanController::class);
    Route::resource('/kehadiran', KehadiranController::class);
    Route::resource('/kesehatan', KesehatanController::class);
    Route::resource('/kitab', KitabController::class);
    Route::resource('/guru', GurusController::class);
    Route::resource('/rombel', RombelController::class);
    Route::resource('/mapel', MapelController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/menu', MenuController::class);
    Route::resource('/pengumuman', PengumumanController::class);
    Route::resource('/news', NewsController::class);
    Route::resource('/pelanggaran', PelanggaranController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/santris-by-rombel/{rombelId}', [KehadiranController::class, 'santrisByRombel']);
    Route::post('/kesehatan/sembuh/{id}', [KesehatanController::class, 'sembuh'])->name('kesehatan.sembuh');
    Route::get('/hafalan/santris-by-rombel/{rombelId}', [HafalanController::class, 'getSantrisByRombel']);
    Route::get('/get-santris', [AkademikController::class, 'getSantris'])->name('getSantris');
    Route::get('/getSantrisByRombel', [HafalanController::class, 'getSantri'])->name('hafalan.getSantrisByRombel');



});

require __DIR__.'/auth.php';
