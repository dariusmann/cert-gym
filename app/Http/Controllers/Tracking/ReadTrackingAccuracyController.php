<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadTrackingAccuracyController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $attempts = QuestionAttempt::where('user_id', $user->getId())->get();

        $groupedAttemptsByDate = [];

        foreach ($attempts as $attempt) {
            $groupedAttemptsByDate[$attempt->getCreatedAt()->format('Y-m-d')][] = $attempt;
        }

        $accuracyRates = [];
        foreach ($groupedAttemptsByDate as $groupedAttempts) {
            $accuracyRates[] = $this->calculateAccuracyRates($groupedAttempts);
        }

        return new JsonResponse([
            'accuracyRates' => $accuracyRates,
            'dates' => $this->resolveDateLabels(array_keys($groupedAttemptsByDate))
        ]);
    }

    public function resolveDateLabels(array $dates): array
    {
        $labels = [];

        foreach ($dates as $date) {
            $labels[] = Carbon::create($date)->format('j M');
        }

        return $labels;
    }

    public function calculateAccuracyRates(array $attempts): float
    {
        $count = count($attempts);

        $correctAttempts = 0;

        /** @var QuestionAttempt $attempt */
        foreach ($attempts as $attempt) {
            if ($attempt->answeredCorrectly()) {
                $correctAttempts++;
            }
        }

        return round($correctAttempts / $count * 100);
    }
}
