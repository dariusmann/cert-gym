<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Flag;

use App\Models\QuestionAttempt;
use App\Models\QuestionResponse;
use App\Models\QuestionRunExamFlag;
use App\Models\QuestionRunQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class CreateRunQuestionExamFlagController
{
    public function __invoke(Request $request): JsonResponse
    {
        $runQuestionId = $request->get('run_question_id');

        $flag = QuestionRunExamFlag::where('question_run_question_id', $runQuestionId)->first();

        if ($flag !== null) {
            throw new ConflictHttpException('Flag already created');
        }

        /** @var QuestionRunQuestion $questionRunQuestion */
        $questionRunQuestion = QuestionRunQuestion::find($runQuestionId);

        if ($questionRunQuestion->getAttemptId() !== null) {
            QuestionResponse::where('attempt_id', $questionRunQuestion->getAttemptId())->delete();
            QuestionAttempt::destroy($questionRunQuestion->getAttemptId());
        }

        $flag = QuestionRunExamFlag::create([
            'question_run_question_id' => $runQuestionId
        ]);

        return new JsonResponse($flag);
    }
}
