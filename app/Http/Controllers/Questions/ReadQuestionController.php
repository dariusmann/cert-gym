<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\JsonResponse;

class ReadQuestionController extends Controller
{
    public function __invoke(int $questionId): JsonResponse
    {
        $question = Question::find($questionId);

        return new JsonResponse($question);
    }
}
