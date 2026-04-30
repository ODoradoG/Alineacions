<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LineupController;
use App\Http\Controllers\PlayerController;
use App\Models\Lineup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $lineups = Schema::hasTable('lineups')
        ? Lineup::with(['user', 'players'])->latest()->limit(5)->get()
        : collect();

    return view('welcome', [
        'lineups' => $lineups,
    ]);
});

Route::get('/dashboard', function (Request $request) {
    return view('dashboard', [
        'lineups' => $request->user()->lineups()->with('players')->latest()->get(),
        'isAdmin' => $request->user()->is_admin,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/lineups/create', [LineupController::class, 'create'])->name('lineups.create');
    Route::post('/lineups', [LineupController::class, 'store'])->name('lineups.store');
    Route::get('/lineups/{lineup}/edit', [LineupController::class, 'edit'])->name('lineups.edit');
    Route::put('/lineups/{lineup}', [LineupController::class, 'update'])->name('lineups.update');
    Route::delete('/lineups/{lineup}', [LineupController::class, 'destroy'])->name('lineups.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/lineups', [LineupController::class, 'index'])->name('lineups.index');
Route::get('/lineups/{lineup}', [LineupController::class, 'show'])->name('lineups.show');
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');

Route::middleware(['auth', 'can:admin-only'])->group(function () {
    Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/players/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/players/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

require __DIR__.'/auth.php';
