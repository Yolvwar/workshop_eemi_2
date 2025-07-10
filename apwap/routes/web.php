<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('pets', function () {
        return view('pets.index');
    })->name('pets.index');

    Route::get('consultations', function () {
        return view('consultations.index');
    })->name('consultations.index');

    Route::get('shop', function () {
        return view('shop.index');
    })->name('shop.index');
});

require __DIR__.'/auth.php';
