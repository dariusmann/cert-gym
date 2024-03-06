<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Run;

use App\Domain\Builder\RunByQuestionsBuilder;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateCategoryRunController extends Controller
{
    private RunByQuestionsBuilder $runByQuestionsBuilder;

    public function __construct(RunByQuestionsBuilder $runByQuestionsBuilder)
    {
        $this->runByQuestionsBuilder = $runByQuestionsBuilder;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $categoryIds = $request->get('category_ids');

        /** @var User $user */
        $user = $request->user();

        $questions = Question::whereIn('category_id', $categoryIds)->get();

        $shuffledQuestions = $questions->shuffle();

        $questionRun = $this->runByQuestionsBuilder->create($shuffledQuestions, $user, 'categories');

        return new JsonResponse([
            'id' => $questionRun->getId()
        ]);
    }
}
