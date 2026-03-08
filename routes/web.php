<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/export', [ExportController::class, 'store'])->middleware('throttle:3,1')->name('export.store');
    Route::get('/export/download/{path}', [ExportController::class, 'download'])
        ->name('export.download');

    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');

});

require __DIR__.'/auth.php';
