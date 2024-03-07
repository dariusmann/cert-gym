<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Answer;

use App\Models\QuestionAnswer;
use App\Models\QuestionResponse;
use App\Models\QuestionRunQuestion;
use Illuminate\Http\JsonResponse;

class ReadQuestionAttemptAnswerController
{
    // TODO: check if request id is form user
    public function __invoke(int $attemptId): JsonResponse
    {
        $answerIds = QuestionResponse::where('attempt_id', $attemptId)->pluck('answer_id')->all();

        $answers = QuestionAnswer::whereIn('id', $answerIds)->get();

//        $questionAnswers = QuestionAnswer::join('question_responses', 'question_responses.answer_id', 'question_answers.id')
//            ->where('question_responses.attempt_id', '=', $attemptId)
//            ->get();

        return new JsonResponse($answers);
    }
}
