<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\User;
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

    private function getQuestionCountAgainstEachMainCategory($short_code)
    {
        // Define the counts of questions for each main category
        $countMapping = [
            'A' => 12,
            'B' => 6,
            'C' => 24,
            'D' => 12,
            'E' => 10,
            'F' => 11
        ];

        return $countMapping[$short_code] ?? 0;
    }

    /**
     * @return mixed
     */
    private function resolveMainCategories()
    {
        $rootTaskListCategory = Category::where('short_code', 'tl-root')->first();
        $mainCategories = Category::where('parent_id', $rootTaskListCategory->getId())->get();
        return $mainCategories;
    }

    /**
     * @param mixed $mainCategory
     * @return mixed
     */
    private function getSubCategories(mixed $mainCategory)
    {
        $subcategories = Category::where('parent_id', $mainCategory->id)->pluck('id');
        return $subcategories;
    }

    /**
     * @param mixed $subcategories
     * @param mixed $mainCategory
     * @param User $user
     * @return mixed
     */
    private function getRecentQuestionAttempts(mixed $subcategories, mixed $mainCategory, User $user)
    {
        $questionIds = Question::whereIn('category_id', $subcategories)->pluck('id');

        $count = $this->getQuestionCountAgainstEachMainCategory($mainCategory->short_code);

        $recentQuestionAttempts = QuestionAttempt::whereIn('question_id', $questionIds)
            ->where('user_id', $user->getId())
            ->orderByDesc('created_at')
            ->take($count)
            ->get();
        return $recentQuestionAttempts;
    }


}
