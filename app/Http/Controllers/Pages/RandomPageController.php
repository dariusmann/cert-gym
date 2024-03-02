<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RandomPageController
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Practice/Random');
    }
}
