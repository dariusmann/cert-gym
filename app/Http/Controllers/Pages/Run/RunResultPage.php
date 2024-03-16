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

        $resultRunQuestions = [];

        /** @var QuestionRunQuestion $runQuestion */
        foreach ($questionRunQuestions as $runQuestion) {
            $resultRunQuestions[] = $runQuestion->toArray();
        }

        return Inertia::render('Run/Result', [
            'run' => [
                'id' => $runId,
                'run_questions' => $resultRunQuestions
            ]
        ]);
    }
}
