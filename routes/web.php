<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/export', [ExportController::class, 'store'])->name('export.store');
    Route::get('/export/download/{path}', [ExportController::class, 'download'])
        ->where('path', '[a-zA-Z0-9_.\-]+')
        ->name('export.download');

});

require __DIR__.'/auth.php';
