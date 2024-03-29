<?php

declare(strict_types=1);

namespace App\Http\Controllers\Docs;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageDocsController
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Docs/Docs');
    }
}
