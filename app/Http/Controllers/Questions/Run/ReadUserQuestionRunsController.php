<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questions\Run;

use App\Domain\Checker\CheckQuestionRunExamCompleted;
use App\Domain\Updater\QuestionRunExamCompletedUpdater;
use App\Models\QuestionRunExam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuestionRun;
use Illuminate\Http\JsonResponse;

class ReadUserQuestionRunsController extends Controller
{
    private CheckQuestionRunExamCompleted $checkQuestionRunExamCompleted;
    private QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater;

    public function __construct(
        CheckQuestionRunExamCompleted   $checkQuestionRunExamCompleted,
        QuestionRunExamCompletedUpdater $questionRunExamCompletedUpdater
    )
    {
        $this->checkQuestionRunExamCompleted = $checkQuestionRunExamCompleted;
        $this->questionRunExamCompletedUpdater = $questionRunExamCompletedUpdater;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var QuestionRun[] $questionRuns */
        $questionRuns = QuestionRun::where('user_id', $request->user()->getId())
            ->where('type', '!=', 'random')
            ->orderByDesc('created_at')
            ->get();

        foreach ($questionRuns as $run) {

            /** @var QuestionRunExam $runExam */
            $runExam = QuestionRunExam::where("question_run_id", $run->getId())->first();

            if ($run->isExam()
                && $runExam !== null
                && $this->checkQuestionRunExamCompleted->check($runExam)) {
                $this->questionRunExamCompletedUpdater->update($runExam);
                $run->setFinished();
            }
        }

        return new JsonResponse($questionRuns);
    }
}
