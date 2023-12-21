<?php

declare(strict_types=1);

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;
use Spark\FrontendState;
use Spark\GuessesBillableTypes;
use Spark\Http\Controllers\RetrievesBillableModels;

class CheckoutSelectPlanController extends Controller
{
    use GuessesBillableTypes;
    use RetrievesBillableModels;
    public function __invoke(Request $request): Response
    {
        $type = $this->guessBillableType();

        $billable = $this->billable($type, null);

        Inertia::share(app(FrontendState::class)->current($type, $billable));

        return Inertia::render('Checkout/SelectPlan', [
            'subscribingTo' => request('subscribe') ? $this->planToSubscribeTo($type) : null,
        ]);
    }
}
