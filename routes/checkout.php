<?php

declare(strict_types=1);

use App\Http\Controllers\Checkout\CheckoutSelectPlanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/checkout/plan', CheckoutSelectPlanController::class)->name('checkout.plan');
});

require __DIR__.'/auth.php';
