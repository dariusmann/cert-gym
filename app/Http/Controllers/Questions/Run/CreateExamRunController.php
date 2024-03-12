<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Run;

use App\Domain\Builder\RunByQuestionsBuilder;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateExamRunController  extends Controller
{
    private RunByQuestionsBuilder $runByQuestionsBuilder;

    public function __construct(RunByQuestionsBuilder $runByQuestionsBuilder)
    {
        $this->runByQuestionsBuilder = $runByQuestionsBuilder;
    }

    public function __invoke(Request $request): JsonResponse
    {

        /** @var User $user */
        $user = $request->user();


        $questions = $this->getRandomQuestions();
        $shuffledQuestions = $questions->shuffle();

        $examRun = $this->runByQuestionsBuilder->create($shuffledQuestions, $user, 'exam');

        return new JsonResponse([
            'id' => $examRun->getId()
        ]);
    }



    public function getRandomQuestions()
    {


        $rootTaskListCategory = Category::where('short_code', 'tl-root')->first();
        $mainCategories = Category::where('parent_id', $rootTaskListCategory->getId())->get();

        $randomQuestions = new Collection();

        // Loop through each main category
        foreach ($mainCategories as $mainCategory) {
            // Get all subcategories of the main category
            $subcategories = Category::where('parent_id', $mainCategory->id)->pluck('id','short_code')->toArray();

            // Define the count of random questions for the current main category
            $count = $this->getRandomQuestionCount($mainCategory->short_code);

            // Get random questions from each subcategory
            $questions = Question::whereIn('category_id', $subcategories)->inRandomOrder()->limit($count)->get();

            // $randomQuestions = array_merge($randomQuestions, $questions->toArray());
            $randomQuestions = $randomQuestions->merge($questions);
        }

        return $randomQuestions;
    }

    private function getRandomQuestionCount($short_code)
    {
        // Define the counts of random questions for each main category
        $countMapping = [
            'A' => 12, // 12 random questions from subcategories of the first category
            'B' => 6,  // 6 random questions from subcategories of the second category
            'C' => 24, // 24 random questions from subcategories of the third category
            'D' => 12, // 12 random questions from subcategories of the fourth category
            'E' => 10, // 10 random questions from subcategories of the fifth category
            'F' => 11  // 11 random questions from subcategories of the sixth category
        ];

        // Return the count based on the category ID, default to 0 if not found
        return $countMapping[$short_code] ?? 0;
    }
}
