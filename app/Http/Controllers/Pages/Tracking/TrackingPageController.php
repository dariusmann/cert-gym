<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Tracking;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TrackingPageController
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Tracking/Tracking');
    }
}
