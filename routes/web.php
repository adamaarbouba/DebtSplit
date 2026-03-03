<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Redirect;
use App\Http\Middleware\CheckIfBanned;
use Illuminate\Support\Facades\Route;


Route::middleware([CheckIfBanned::class])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [Redirect::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    // Auth & Profile Routes
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Colocation Routes
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocation.index');
    Route::get('/colocation/{id}', [ColocationController::class, 'show'])->name('colocation.show');
    Route::get('/colocations/join', [ColocationController::class, 'join'])->name('colocation.join');
    Route::post('/colocations/join', [ColocationController::class, 'processJoin'])->name('colocation.processJoin');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocation.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocation.store');
    Route::patch('/colocations/{id}/cancel', [ColocationController::class, 'cancel'])->name('colocation.cancel');
    Route::delete('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocation.leave');
    Route::delete('/colocations/{colocation}/kick/{user}', [ColocationController::class, 'kick'])->name('colocation.kick');
    Route::patch('/colocations/{colocation}/token', [ColocationController::class, 'refreshToken'])->name('colocation.token.refresh');

    // Expense Routes
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('/colocations/{colocation}/expenses/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])->name('expense.show');
    Route::patch('/expenses/{expense}/paid', [ExpenseController::class, 'paid'])->name('expense.paid');
    Route::patch('/colocations/{colocation}/expenses/{expense}/paid', [ExpenseUserController::class, 'markAsPaid'])->name('expense.user.paid');

    // Category Routes
    Route::get('/colocations/{colocation}/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/colocations/{colocation}/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::patch('/colocations/{colocation}/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/colocations/{colocation}/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::patch('/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('users.toggle-ban');
    });
});

require __DIR__ . '/auth.php';
