<?php

declare(strict_types=1);

use App\Http\Controllers\Checkout\CheckoutCompleted;
use App\Http\Controllers\Checkout\CheckoutSelectPlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/checkout/plan', CheckoutSelectPlanController::class)->name('checkout.plan');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout/complete', CheckoutCompleted::class)->name('checkout.complete');
});

require __DIR__.'/auth.php';
