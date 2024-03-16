<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadReadinessScoreController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $totalReadiness = 0;
        $mainCategories = $this->resolveMainCategories();

        foreach ($mainCategories as $mainCategory) {
            $subcategories = $this->getSubCategories($mainCategory);

            // Get the most recent question attempts for the subcategory
            $recentQuestionAttempts = $this->getRecentQuestionAttempts($subcategories, $mainCategory, $user);

            // Count the total number of questions attempted
            $totalQuestions = $recentQuestionAttempts->count();

            // Count the total number of correct answers
            $totalCorrectAnswers = $recentQuestionAttempts->where('answered_correctly', true)->count();

            // Calculate readiness for the subcategory
            $subcategoryReadiness = $totalQuestions > 0 ? ($totalCorrectAnswers / $totalQuestions) * 100 : 0;

            // Add parent category readiness to total readiness
            $totalReadiness += $subcategoryReadiness;
        }

        // Calculate average readiness across all parent categories
        $averageReadiness = $mainCategories->count() > 0 ? $totalReadiness / $mainCategories->count() : 0;

        return new JsonResponse([
            'ReadinessScore' => round($averageReadiness)
        ]);
    }

    private function getQuestionCountAgainstEachMainCategory($short_code): int
    {
        // Define the counts of questions for each main category
        $countMapping = [
            'A' => 24,
            'B' => 12,
            'C' => 48,
            'D' => 24,
            'E' => 20,
            'F' => 22
        ];

        return $countMapping[$short_code] ?? 0;
    }

    private function resolveMainCategories(): Collection
    {
        $rootTaskListCategory = Category::where('short_code', 'tl-root')->first();
        return Category::where('parent_id', $rootTaskListCategory->getId())->get();
    }

    private function getSubCategories(mixed $mainCategory): Collection
    {
        return Category::where('parent_id', $mainCategory->id)->pluck('id');
    }

    private function getRecentQuestionAttempts(mixed $subcategories, mixed $mainCategory, User $user): Collection
    {
        $questionIds = Question::whereIn('category_id', $subcategories)->pluck('id');

        $count = $this->getQuestionCountAgainstEachMainCategory($mainCategory->short_code);

        return QuestionAttempt::whereIn('question_id', $questionIds)
            ->where('user_id', $user->getId())
            ->orderByDesc('created_at')
            ->take($count)
            ->get();
    }
}
