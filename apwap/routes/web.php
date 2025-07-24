<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\CalendarController;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/catalog', [ShopController::class, 'catalog'])->name('catalog');
    Route::get('/product/{product}', [ShopController::class, 'show'])->name('product');
    Route::get('/category/{category}', [ShopController::class, 'category'])->name('category');
    Route::get('/search', [ShopController::class, 'search'])->name('search');
    
    Route::middleware('auth')->group(function () {
        Route::get('/pet/{pet}/recommendations', [ShopController::class, 'petRecommendations'])->name('pet.recommendations');
    });
});


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
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('pets', PetController::class);
    Route::get('/pets/{pet}/calendar', [CalendarController::class, 'index'])->name('pets.calendar.index');
    Route::get('/pets/{pet}/calendar/events', [CalendarController::class, 'getEvents'])->name('pets.calendar.events');
    Route::post('/pets/{pet}/calendar/events', [CalendarController::class, 'store'])->name('pets.calendar.events.store');
    Route::put('/pets/{pet}/calendar/events/{event}', [CalendarController::class, 'update'])->name('pets.calendar.events.update');
    Route::delete('/pets/{pet}/calendar/events/{event}', [CalendarController::class, 'destroy'])->name('pets.calendar.events.destroy');

    Route::prefix('consultations')->name('consultations.')->group(function () {
        Route::get('/', [ConsultationController::class, 'index'])->name('index');
        Route::get('/create', [ConsultationController::class, 'create'])->name('create');
        Route::post('/', [ConsultationController::class, 'store'])->name('store');
        Route::get('/{consultation}', [ConsultationController::class, 'show'])->name('show');
        Route::get('/{consultation}/edit', [ConsultationController::class, 'edit'])->name('edit');
        Route::patch('/{consultation}', [ConsultationController::class, 'update'])->name('update');
        
        Route::get('/{consultation}/prepare', [ConsultationController::class, 'prepare'])->name('prepare');
        Route::patch('/{consultation}/prepare', [ConsultationController::class, 'prepareSave'])->name('prepare.save');
        Route::post('/{consultation}/prepare/send', [ConsultationController::class, 'prepareSend'])->name('prepare.send');
        
        Route::get('/{consultation}/teleconsultation', [ConsultationController::class, 'teleconsultation'])->name('teleconsultation');
        Route::post('/{consultation}/teleconsultation/chat', [ConsultationController::class, 'teleconsultationChat'])->name('teleconsultation.chat');
        Route::post('/{consultation}/teleconsultation/extend', [ConsultationController::class, 'teleconsultationExtend'])->name('teleconsultation.extend');
        Route::get('/teleconsultation/create', [ConsultationController::class, 'teleconsultationCreate'])->name('teleconsultation.create');
        Route::get('/teleconsultation/emergency', [ConsultationController::class, 'teleconsultationEmergency'])->name('teleconsultation.emergency');
        
        Route::post('/{consultation}/start', [ConsultationController::class, 'start'])->name('start');
        Route::post('/{consultation}/complete', [ConsultationController::class, 'complete'])->name('complete');
        Route::patch('/{consultation}/cancel', [ConsultationController::class, 'cancel'])->name('cancel');
        
        Route::get('/emergency/center', [ConsultationController::class, 'emergency'])->name('emergency');
        
        Route::get('/history/list', [ConsultationController::class, 'history'])->name('history');
    });
});

require __DIR__.'/auth.php';