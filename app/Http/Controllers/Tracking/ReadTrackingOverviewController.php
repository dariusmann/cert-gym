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

class ReadTrackingOverviewController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        // Total count of question attempts for the user
        $total = QuestionAttempt::where('user_id', $user->getId())->count();

         // Count of correct answered question attempts for the user
         $correctAnswered = QuestionAttempt::where('user_id', $user->getId())
         ->where('answered_correctly', true)
         ->count();

         // Most recent 100 question attempts for the user
         $recentAttempts = QuestionAttempt::where('user_id', $user->getId())
            ->orderByDesc('created_at')
            ->take(100)
            ->get();

        // Count of correct answered question attempts among the most recent 100
        $recentCorrectAnswered = $recentAttempts->where('answered_correctly', true)->count();

        // Calculate accuracy rate
        $accuracyRate = $total > 0 ? ($recentCorrectAnswered / $recentAttempts->count()) * 100 : 0;

       
        return new JsonResponse([
            'total' => $total,
            'correct_answered' => $correctAnswered,
            'accuracy_rate' => round($accuracyRate)
        ]);

    }

   

   
}
