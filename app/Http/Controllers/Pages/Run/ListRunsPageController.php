<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ListRunsPageController
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Run/ListRuns');
    }
}
