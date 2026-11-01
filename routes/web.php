<?php

use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RekapController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('auth')->group(function () {
    Route::resource('laporans', LaporanController::class)->only(['index', 'store', 'show', 'update']);
    Route::patch('laporans/{laporan}/review', [LaporanController::class, 'review'])->name('laporans.review');
    Route::get('sekolahs/{sekolah}/distribusis', [DistribusiController::class, 'bySekolah'])->name('sekolahs.distribusis');

    Route::get('rekap', [RekapController::class, 'index'])
        ->middleware('role:monitor,koordinator')
        ->name('rekap.index');
});

require __DIR__.'/auth.php';
