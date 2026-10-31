<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('auth')->group(function () {
    Route::resource('laporans', LaporanController::class)->only(['index', 'store', 'show', 'update']);
});

require __DIR__.'/auth.php';
