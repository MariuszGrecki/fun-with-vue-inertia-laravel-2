<?php

use App\Http\Controllers\AcceptOfferController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\RealtorListingOfferController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/hello', [IndexController::class, 'show']);

    Route::resource('listing', ListingController::class)
        ->only(['create', 'store']);
});

Route::resource('listing', ListingController::class)
    ->only(['index', 'show']);

Route::resource('listing.offer', ListingOfferController::class)
    ->middleware('auth')
    ->only(['store']);

Route::middleware('guest')->group(function () {
    Route::post('my-login', [AuthController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('auth.login.store');

    Route::get('register', [UserAccountController::class, 'create'])
        ->name('user-account.create');

    Route::post('register', [UserAccountController::class, 'store'])
        ->name('user-account.store');

    Route::get('my-login', [AuthController::class, 'create'])
        ->name('auth.login');
});

Route::delete('my-logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('auth.logout');

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function () {
        Route::name('listing.restore')->put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
            ->withTrashed();
        Route::resource('listing', RealtorListingController::class)
            ->only(['index', 'edit', 'update', 'destroy'])
            ->withTrashed([]);
        Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
        Route::resource('listing.offer', RealtorListingOfferController::class)
            ->only(['index']);
        Route::post('listing/{listing}/offer/{offer}/accept', AcceptOfferController::class)
            ->name('listing.offer.accept')
            ->scopeBindings();
    });

require __DIR__.'/settings.php';
