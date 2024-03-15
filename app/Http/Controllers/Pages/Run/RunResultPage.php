<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionAttempt;
use App\Models\QuestionResponse;
use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RunResultPage
{
    public function __invoke(Request $request, int $runId): Response
    {
        $questionRunQuestions = QuestionRunQuestion::where('question_run_id', $runId)->get();

        $result = [];

        /** @var QuestionRunQuestion $runQuestion */
        foreach ($questionRunQuestions as $runQuestion) {
            $result[] = [
                'id' => $runQuestion->getId(),
                'runQuestion' => $runQuestion,
                'attempt' => QuestionAttempt::find($runQuestion->getAttemptId()),
                'question' => Question::find($runQuestion->getQuestionId())->toArray(),
                'answers' => $runQuestion->getAttemptId() !== null ? $this->resolveAnswers($runQuestion->getAttemptId()) : []
            ];
        }

        return Inertia::render('Run/Result', [
            'runQuestions' => $result,
        ]);
    }

    private function resolveAnswers(int $attemptId): Collection
    {
        $answerIds = QuestionResponse::where('attempt_id', $attemptId)->pluck('answer_id')->all();

        return QuestionAnswer::whereIn('id', $answerIds)->get();
    }
}
