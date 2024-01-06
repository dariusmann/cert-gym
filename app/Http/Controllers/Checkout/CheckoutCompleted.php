<?php

declare(strict_types=1);

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutCompleted extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Checkout/Completed');
    }
}
