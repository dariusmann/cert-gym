<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Models\Question;
use App\Models\QuestionRun;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RunExamPageController
{
    public function __invoke(Request $request, int $runId): Response
    {
        /** @var QuestionRun $questionRun */
        $questionRun = QuestionRun::find($runId);

        $questionRunQuestions = $questionRun->getQuestionRunQuestions();

        $questionIds = $questionRunQuestions->orderBy('order')->pluck('question_id')->toArray();

        $questions = Question::find($questionIds);

        return Inertia::render('Practice/ExamRun', [
            'examRun' => [
                'id' => $questionRun->getId(),
                'questions' => $questions
            ]
        ]);
    }
}
