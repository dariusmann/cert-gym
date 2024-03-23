<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Exam;

use App\Domain\Updater\QuestionRunExamCompletedUpdater;
use App\Models\QuestionRun;
use App\Models\QuestionRunExam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommitRunExamController
{
    private QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater;

    public function __construct(
        QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater
    )
    {
        $this->questionRunExamCompletedUpdater = $questionRunExamCompletedUpdater;
    }

    public function __invoke(Request $request): Response
    {
        $runId = $request->get('question_run_id');

        /** @var QuestionRunExam $runExam */
        $runExam = QuestionRunExam::where('question_run_id', $runId)->first();

        $this->questionRunExamCompletedUpdater->update($runExam);

        return new Response('OK');
    }
}
