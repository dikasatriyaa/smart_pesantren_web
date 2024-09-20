<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KitabController;
use App\Http\Controllers\Api\MapelController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\Api\PelanggaranController;
use App\Http\Controllers\API\PengumumanController;
use App\Http\Controllers\Api\SantriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function()
{
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('user', 'userProfile')->middleware('auth:sanctum');
    Route::get('logout', 'userLogout')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('santri/{santri}', [SantriController::class, 'show']);
    Route::get('santri/{santri}/kehadiran', [SantriController::class, 'kehadiran']);
    Route::get('santri/{santri}/kesehatan', [SantriController::class, 'kesehatan']);
    Route::get('santri/{santri}/akademik', [SantriController::class, 'akademik']);
    Route::get('santri/{santri}/hafalan', [SantriController::class, 'hafalan']);
    Route::get('santri/{santri}/kitab', [SantriController::class, 'kitab']);
    Route::get('santri/{santri}/kehadiran/semua', [SantriController::class, 'semuaKehadiran']);
    Route::get('menu', [SantriController::class, 'menu']);
    Route::get('/pengumumen', [PengumumanController::class, 'index']);
    Route::post('/pengumumen', [PengumumanController::class, 'store']);
    Route::put('/pengumumen/{id}', [PengumumanController::class, 'update']);
    Route::delete('/pengumumen/{id}', [PengumumanController::class, 'destroy']);
    Route::get('/santri/{santri}/pelanggaran', [PelanggaranController::class, 'index']);
    Route::apiResource('mapels', MapelController::class);
    Route::post('/logout', [AuthController::class, 'userLogout']);

    Route::get('/kitabs', [KitabController::class, 'index']);
    Route::get('/kitabs/{kitab}', [KitabController::class, 'show']);

    // Routes for news
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{news}', [NewsController::class, 'show']);
    Route::post('/news', [NewsController::class, 'store']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);
});