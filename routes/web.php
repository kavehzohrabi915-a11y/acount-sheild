<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterPasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Breeze Auth Routes
require __DIR__.'/auth.php';

// Master Password Routes
Route::middleware('auth')->group(function () {
    Route::get('/master-password', [MasterPasswordController::class, 'show'])
        ->name('master-password.show');
    
    Route::post('/master-password', [MasterPasswordController::class, 'verify'])
        ->name('master-password.verify');
});

// Protected Routes
Route::middleware(['auth', 'master.password'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('accounts', AccountController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});