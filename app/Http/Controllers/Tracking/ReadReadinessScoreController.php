<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReadReadinessScoreController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();


        $countMapping = [
            2 => 12,   // Parent category ID => Number of questions
            9 => 6,    // Parent category ID => Number of questions
            13 => 24,  // Parent category ID => Number of questions
            26 => 12,  // Parent category ID => Number of questions
            33 => 10,  // Parent category ID => Number of questions
            39 => 11   // Parent category ID => Number of questions
        ];
        
     
        
        $totalReadiness = 0;
        $categoryCount = count($countMapping);
        
        foreach ($countMapping as $parentCategoryId => $questionCount) {
            // Find subcategories of the parent category
            $subcategories = Category::where('parent_id', $parentCategoryId)->pluck('id');
        
            $subcategoryReadiness = 0;
        
            // Calculate readiness for each subcategory
            foreach ($subcategories as $subcategoryId) {
                // Get the most recent question attempts for the subcategory
                $questionIds = Question::where('category_id', $subcategoryId)->pluck('id');
                
                $recentQuestionAttempts = QuestionAttempt::whereIn('question_id', $questionIds)
                    ->where('user_id', $user->getId())
                    ->orderByDesc('created_at')
                    ->take($questionCount)
                    ->get();
        
                // Count the total number of questions attempted
                $totalQuestions = $recentQuestionAttempts->count();
        
                // Count the total number of correct answers
                $totalCorrectAnswers = $recentQuestionAttempts->where('answered_correctly', true)->count();
        
                // Calculate readiness for the subcategory
                $subcategoryReadiness += $totalQuestions > 0 ? ( $totalCorrectAnswers / $totalQuestions) * 100 : 0;
                
                
            }
        
            // Calculate average readiness for the parent category
            $parentCategoryReadiness = $subcategories->count() > 0 ? $subcategoryReadiness / $subcategories->count() : 0;
        
            // Add parent category readiness to total readiness
            $totalReadiness += $parentCategoryReadiness;
        }
        
        // Calculate average readiness across all parent categories
        $averageReadiness = $categoryCount > 0 ? $totalReadiness / $categoryCount : 0;



       
        return new JsonResponse([
          
            'ReadinessScore' => round($averageReadiness)
        ]);

    }

   

   
}
