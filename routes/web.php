<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SpelController::class, 'landing'])->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/spellen', [SpelController::class, 'index'])->name('spellen.index');
    Route::get('/spellen/nieuw', [SpelController::class, 'create'])->name('spellen.create');
    Route::post('/spellen', [SpelController::class, 'store'])->name('spellen.store');
    Route::get('/spellen/{spel}', [SpelController::class, 'show'])->name('spellen.show');
    Route::post('/spellen/{spel}/zet', [SpelController::class, 'play'])->name('spellen.play');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';