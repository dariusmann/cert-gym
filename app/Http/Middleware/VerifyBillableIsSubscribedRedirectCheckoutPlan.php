<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spark\GuessesBillableTypes;
use Spark\Spark;
use Symfony\Component\HttpFoundation\Response;

class VerifyBillableIsSubscribedRedirectCheckoutPlan
{
    use GuessesBillableTypes;

    /**
     * Verify the incoming request's user has a subscription.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $billableType
     * @param  string  $plan
     * @return Response
     */
    public function handle($request, $next, $billableType = null, $plan = null)
    {
        $billableType = $billableType ?: $this->guessBillableType($billableType);

        if ($this->subscribed($request, $billableType, $plan)) {
            return $next($request);
        }

        $redirect = route('checkout.plan');

        if ($request->header('X-Inertia')) {
            return Inertia::location($redirect);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response('Subscription Required.', 402);
        }

        return redirect($redirect);
    }

    /**
     * Determine if the given user is subscribed to the given plan.
     *
     * @param Request $request
     * @param string $type
     * @param string $plan
     * @return bool
     */
    protected function subscribed($request, $type, $plan): bool
    {
        if (! $billable = Spark::resolveBillable($type, $request)) {
            return false;
        }

        $subscription = $billable->subscription();

        if ($plan && (! $subscription || $subscription->stripe_price != $plan)) {
            return false;
        }

        return ($subscription && $subscription->active()) ||
            $billable->onGenericTrial();
    }
}
