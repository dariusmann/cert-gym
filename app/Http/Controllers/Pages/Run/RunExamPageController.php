<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages\Run;

use App\Domain\Checker\CheckQuestionRunExamCompleted;
use App\Domain\Updater\QuestionRunExamCompletedUpdater;
use App\Models\QuestionRun;
use App\Models\QuestionRunExam;
use App\Models\QuestionRunQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RunExamPageController
{
    private CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted;
    private QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater;

    public function __construct(
        CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted,
        QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater
    )
    {
        $this->checkQuestionRunExamCompleted = $checkQuestionRunExamCompleted;
        $this->questionRunExamCompletedUpdater = $questionRunExamCompletedUpdater;
    }

    public function __invoke(Request $request, int $runId): RedirectResponse|Response
    {
        /** @var QuestionRun $questionRun */
        $questionRun = QuestionRun::find($runId);

        /** @var QuestionRunExam $questionRunExam */
        $questionRunExam = QuestionRunExam::where('question_run_id', $questionRun->getId())->first();

        if ($questionRunExam !== null && $this->checkQuestionRunExamCompleted->check($questionRunExam)) {
            $this->questionRunExamCompletedUpdater->update($questionRunExam);

            return new RedirectResponse(route('page.run.result', ['runId' => $runId]));
        }

        $questionRunQuestions = $questionRun->getQuestionRunQuestions()->orderBy('order')->get();

        $resultRunQuestions = [];

        /** @var QuestionRunQuestion $runQuestion */
        foreach ($questionRunQuestions as $runQuestion) {
            $resultRunQuestions[] = $runQuestion->toArray();
        }

        return Inertia::render('Practice/ExamRun', [
            'examRun' => [
                'id' => $questionRun->getId(),
                'run_questions' => $resultRunQuestions
            ]
        ]);
    }
}
