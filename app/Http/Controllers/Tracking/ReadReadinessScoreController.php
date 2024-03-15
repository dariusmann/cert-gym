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

        $totalReadiness = 0;
        $rootTaskListCategory = Category::where('short_code', 'tl-root')->first();
        $mainCategories = Category::where('parent_id', $rootTaskListCategory->getId())->get();

        foreach ($mainCategories as $mainCategory) {
            $subcategoryReadiness = 0;

            $subcategories = Category::where('parent_id', $mainCategory->id)->pluck('id');
        
            // Get the most recent question attempts for the subcategory
            $questionIds = Question::whereIn('category_id', $subcategories)->pluck('id');

            $count = $this->getQuestionCountAgainstEachMainCategory($mainCategory->short_code);
            
            $recentQuestionAttempts = QuestionAttempt::whereIn('question_id', $questionIds)
                ->where('user_id', $user->getId())
                ->orderByDesc('created_at')
                ->take($count)
                ->get();
    
            // Count the total number of questions attempted
            $totalQuestions = $recentQuestionAttempts->count();
    
            // Count the total number of correct answers
            $totalCorrectAnswers = $recentQuestionAttempts->where('answered_correctly', true)->count();
    
            // Calculate readiness for the subcategory
            $subcategoryReadiness = $totalQuestions > 0 ? ( $totalCorrectAnswers / $totalQuestions) * 100 : 0;
       
           
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
            'A' => 12, // 12  questions from subcategories of the first category
            'B' => 6,  // 6   questions from subcategories of the second category
            'C' => 24, // 24  questions from subcategories of the third category
            'D' => 12, // 12  questions from subcategories of the fourth category
            'E' => 10, // 10  questions from subcategories of the fifth category
            'F' => 11  // 11  questions from subcategories of the sixth category
        ];

        // Return the count based on the category ID, default to 0 if not found
        return $countMapping[$short_code] ?? 0;
    }

   

   
}
