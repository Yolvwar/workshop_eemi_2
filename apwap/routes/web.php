<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Boutique principale (accessible sans auth)
Route::prefix('shop')->name('shop.')->group(function () {
    // Pages principales
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/catalog', [ShopController::class, 'catalog'])->name('catalog');
    Route::get('/product/{product}', [ShopController::class, 'show'])->name('product');
    Route::get('/category/{category}', [ShopController::class, 'category'])->name('category');
    Route::get('/search', [ShopController::class, 'search'])->name('search');
    
    // Recommandations pour animaux (nécessite auth)
    Route::middleware('auth')->group(function () {
        Route::get('/pet/{pet}/recommendations', [ShopController::class, 'petRecommendations'])->name('pet.recommendations');
    });
});

// ========== ROUTES PANIER ET COMMANDES (nécessitent auth) ==========

Route::middleware('auth')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'updateQuantity'])->name('update');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
        Route::get('/mini', [CartController::class, 'mini'])->name('mini');
        
        Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
        Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');
    });
    
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'process'])->name('process');
        Route::post('/shipping/calculate', [CheckoutController::class, 'calculateShipping'])->name('shipping.calculate');
        Route::post('/coupon/validate', [CheckoutController::class, 'validateCoupon'])->name('coupon.validate');
    });
    
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/success', [CheckoutController::class, 'success'])->name('success');
        Route::get('/{order}/track', [OrderController::class, 'track'])->name('track');
        Route::get('/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('download-invoice');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/reorder', [OrderController::class, 'reorder'])->name('reorder');
    });
});

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
});

require __DIR__.'/auth.php';
