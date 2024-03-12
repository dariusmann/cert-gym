<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Models\QuestionRun;
use App\Models\QuestionRunQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RunPageController
{
    public function __invoke(Request $request, int $runId): Response
    {
        /** @var QuestionRun $questionRun */
        $questionRun = QuestionRun::find($runId);

        $questionRunQuestions = $questionRun->getQuestionRunQuestions()->orderBy('order')->get();

        $resultRunQuestions = [];

        /** @var QuestionRunQuestion $runQuestion */
        foreach ($questionRunQuestions as $runQuestion) {
            $resultRunQuestions[] = $runQuestion->toArray();
        }

        return Inertia::render('Practice/Run', [
            'questionRun' => [
                'id' => $questionRun->getId(),
                'questions' => $resultRunQuestions
            ]
        ]);
    }
}
