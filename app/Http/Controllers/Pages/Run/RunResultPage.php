<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RunResultPage
{
    public function __invoke(Request $request, int $runId): Response
    {
        /** @var QuestionRun $run */
        $run = QuestionRun::find($runId);

        $questionRunQuestions = QuestionRunQuestion::where('question_run_id', $runId)->get();

        return Inertia::render('Run/Result', [
            'run' => [
                'id' => $runId,
                'run_questions' => $questionRunQuestions->toArray(),
                'type' => $run->getType()
            ]
        ]);
    }
}
