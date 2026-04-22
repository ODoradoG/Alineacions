<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LineupController;
use App\Http\Controllers\PlayerController;
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

    Route::resource('lineups', LineupController::class);
    Route::resource('players', PlayerController::class)->except(['create', 'store']);
    Route::resource('players', PlayerController::class)
        ->only(['create', 'store'])
        ->middleware('can:admin-only');
});

require __DIR__.'/auth.php';
