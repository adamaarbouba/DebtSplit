<?php

use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Redirect::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/colocations', [ColocationController::class, 'index'])->name('colocation.index');
Route::get('/colocation/{id}', [ColocationController::class, 'show'])->name('colocation.show');
Route::get('/colocations/join', [ColocationController::class, 'join'])->name('colocation.join');
Route::post('/colocations/join', [ColocationController::class, 'processJoin'])->name('colocation.processJoin');
Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocation.create');
Route::post('/colocations', [ColocationController::class, 'store'])->name('colocation.store');
Route::patch('/colocations/{id}/cancel', [ColocationController::class, 'cancel'])->name('colocation.cancel');

require __DIR__ . '/auth.php';
