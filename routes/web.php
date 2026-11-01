<?php

use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('auth')->group(function () {
    Route::resource('laporans', LaporanController::class)->only(['index', 'store', 'show', 'update']);
    Route::patch('laporans/{laporan}/review', [LaporanController::class, 'review'])->name('laporans.review');
    Route::get('sekolahs/{sekolah}/distribusis', [DistribusiController::class, 'bySekolah'])->name('sekolahs.distribusis');
});

require __DIR__.'/auth.php';
