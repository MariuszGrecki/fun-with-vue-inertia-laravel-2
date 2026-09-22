<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/hello', [IndexController::class, 'show']);

    Route::resource('listing', ListingController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

Route::get('my-login', [AuthController::class, 'create'])
    ->middleware('guest')
    ->name('auth.login');
Route::post('my-login', [AuthController::class, 'store'])
    ->middleware(['guest', 'throttle:6,1'])
    ->name('auth.login.store');
Route::delete('my-logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('auth.logout');


require __DIR__.'/settings.php';
