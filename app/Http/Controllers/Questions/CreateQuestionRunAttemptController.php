<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Controller;
use App\Models\QuestionAttempt;
use App\Models\QuestionResponse;
use App\Models\QuestionRunQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CreateQuestionRunAttemptController extends Controller
{
    // TODO: check if same user who request and if attempt already exists for run question
    public function __invoke(Request $request): JsonResponse
    {
        $runQuestionId = $request->get('question_run_question_id');
        $answersIds = $request->get('answer_ids');

        /** @var User $user */
        $user = $request->user();

        /** @var QuestionRunQuestion $questionRunQuestion */
        $questionRunQuestion = QuestionRunQuestion::find($runQuestionId);

        /** @var QuestionAttempt $questionAttempt */
        $questionAttempt = QuestionAttempt::create([
            'question_id' => $questionRunQuestion->getQuestionId(),
            'user_id' => $user->getId()
        ]);

        foreach ($answersIds as $answersId) {
            QuestionResponse::create([
                'attempt_id' => $questionAttempt->getId(),
                'answer_id' => $answersId
            ]);
        }

        $questionRunQuestion->setAttemptId($questionAttempt->getId());
        $questionRunQuestion->save();

        return new JsonResponse($questionRunQuestion);
    }
}
